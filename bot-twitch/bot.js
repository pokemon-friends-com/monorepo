require('dotenv').config();
const _ = require('lodash');
const tmi = require('tmi.js');
const chatCommand = require('chatcommand-parser');
const winston = require('winston');
const WinstonSentry = require('winston-transport-sentry');
const axios = require('axios');
const oauth = require('axios-oauth-client');
const tokenProvider = require('axios-token-interceptor');
const chatBase = require('@google/chatbase')
  .setApiKey(process.env.CHATBASE_KEY)
  .setPlatform('twitch.tv');
const { version } = require('./package.json');
const logger = winston.createLogger({
  level: 'info',
  transports: [
    new winston.transports.Console(),
    new WinstonSentry({
      level: 'warn',
      dsn: process.env.SENTRY_DSN,
      environment: process.env.NODE_ENV,
      release: version,
      tags: { host: 'glitch.com' },
    }),
  ],
});
const chatCommands = new chatCommand.Parser({
  'pkmn-friends': {
    friend_code: ['int'],
  },
  help: {},
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
const helpMessage = (target) => {
  client.say(target, 'command usage : !pkmn-friends 111122223333');
};
const axiosInstance = axios.create(axiosOpts);

axiosInstance
  .interceptors
  .request
  .use(oauth.interceptor(tokenProvider, getAuthorizationCode));

chatBase.setVersion(version);

client.on('connected', (addr, port) => {
  logger.info(`connected to ${addr}:${port}`);

  axiosInstance
    .get('/users/channels')
    .then((response) => {
      _.forEach(response.data.data, (profile) => {
        if (profile.channel) {
          client.join(profile.channel).then((channel) => {
            logger.info(`Joined: ${channel}`);
          }).catch((error) => {
            logger.error(`Unable to join channel: ${profile.channel} Error: ${error}`);
          });
        }
      });
    })
    .catch((error) => {
      logger.error(`${error}`);
    });
});

client.on('message', (target, context, msg, self) => {
  if (self) { return; } // Ignore messages from the bot

  try {
    const parsed = chatCommands.parse(msg.trim());

    if (
      parsed
      && 'pkmn-friends' === parsed.command
      && 12 === parsed.args.friend_code.length
    ) {
      const channel = target.substr(1);

      axiosInstance
        .get(`/users/stream/${channel}/${parsed.args.friend_code}`)
        .catch((error) => {
          logger.error(`${error}`);
        });
      if (process.env.NODE_ENV === 'production') {
        chatBase
          .newMessage()
          .setAsTypeUser()
          .setAsHandled()
          .setIntent('display-pkmn-friend-code-on-live-stream')
          .setMessage(msg.trim())
          .setCustomSessionId(context['room-id'])
          .setUserId(context['user-id'])
          .setMessageId(context.id)
          .send()
          .catch((err) => logger.error(err));
      }
    } else if (parsed && 'help' === parsed.command) {
      helpMessage(target);
    }
  } catch (exception) {
    logger.error(exception);
  }
});

client.connect();
