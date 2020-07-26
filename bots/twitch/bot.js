require('dotenv').config();
const _ = require('lodash');
const tmi = require('tmi.js');
const cron = require('node-cron');
const chatCommand = require('chatcommand-parser');
const winston = require('winston');
const WinstonSentry = require('winston-transport-sentry');
const axios = require('axios');
const oauth = require('axios-oauth-client');
const tokenProvider = require('axios-token-interceptor');
const chatBase = require('@google/chatbase')
  .setApiKey(process.env.CHATBASE_KEY)
  .setPlatform('twitch.tv')
  .setVersion('0.0.1');
const logger = winston.createLogger({
  level: 'info',
  transports: [
    new winston.transports.Console(),
    new WinstonSentry({
      level: 'warn',
      dsn: process.env.SENTRY_DSN,
      environment: process.env.NODE_ENV,
      release: '0.0.1',
      tags: { host: 'glitch.com' },
    }),
  ],
});
const chatCommands = new chatCommand.Parser({
  'pkmn-friends': {
    friend_code: ['int'],
  }
}, '!');
const tmiOpts = {
  identity: {
    username: process.env.BOT_USERNAME,
    password: process.env.OAUTH_TOKEN,
  },
  channels: [
    process.env.CHANNEL_NAME,
  ],
};
const client = new tmi.client(tmiOpts);
const axiosOpts = {
  baseURL: process.env.API_BASE_URL,
};
const getAuthorizationCode = oauth.client(axios.create(axiosOpts), {
  url: process.env.API_OAUTH_URL,
  grant_type: 'client_credentials',
  client_id: process.env.API_CLIENT_ID,
  client_secret: process.env.API_CLIENT_SECRET,
});
const axiosInstance = axios.create(axiosOpts);
axiosInstance.interceptors.request.use(oauth.interceptor(tokenProvider, getAuthorizationCode));

client.on('connected', (addr, port) => {
  logger.info(`connected to ${addr}:${port}`);
});

client.on('message', (target, context, msg, self) => {
  if (self) { return; } // Ignore messages from the bot

  try {
    const parsed = chatCommands.parse(_.trim(msg));

    if (
      parsed
      && 'pkmn-friends' === parsed.command
      && 12 === parsed.args.friend_code.length
    ) {
      chatBase
        .newMessage()
        .setAsTypeUser()
        .setAsHandled()
        .setIntent('display-pkmn-friend-code-on-live-stream')
        .setMessage(_.trim(msg))
        .setCustomSessionId(context['room-id'])
        .setUserId(context['user-id'])
        .setMessageId(context.id)
        .send()
        .then((res) => logger.info(res.getCreateResponse()))
        .catch((err) => logger.error(err));

      // client.say(target, `You rolled a ${parsed.args.friend_code}`);

      // send to api the channel received the message and the friend_code

    }
  } catch (exception) {
    logger.error(exception);
  }
});

client.connect();

axiosInstance
  .get('/users')
  .then((response) => {
    logger.info(response.data);
  })
  .catch(() => {
    logger.info('failed');
  });

cron.schedule('*/1 * * * *', () => {
  logger.info('retrieve channels from API');

  axiosInstance
    .get('/users')
    .then((response) => {
      logger.info(response.data);

      response.data.each((channel) => {
        client
          .join(channel)
          .then((m) => {
            console.log(`Joined: ${m}`);
          })
          .catch((err )=> {
            console.log(`Unable to join channel: ${channel} Error: ${err}`);
          });
      });
    })
    .catch(() => {
      logger.info('failed');
    });
});
