const tmi = require('tmi.js');
const cron = require('node-cron');
const chatCommand = require('chatcommand-parser');
const winston = require('winston');
const winstonSentry = require('winston-transport-sentry');
const logger = winston.createLogger({
  level: 'info',
  transports: [
    new winston.transports.Console(),
    new winstonSentry({
      level: 'warn',
      dsn: process.env.SENTRY_DSN,
      environment: process.env.NODE_ENV,
      release: '1.0.0',
      tags: { host: 'glitch.com' },
    })
  ]
});
const chatCommands = new chatCommand.Parser({
  'pkmn-friends': {
    friend_code: ['int'],
  }
}, '!');
const opts = {
  identity: {
    username: process.env.BOT_USERNAME,
    password: process.env.OAUTH_TOKEN
  },
  channels: [
    process.env.CHANNEL_NAME
  ]
};
const client = new tmi.client(opts);

client.on('connected', (addr, port) => {
  logger.info(`connected to ${addr}:${port}`);
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
      // client.say(target, `You rolled a ${parsed.args.friend_code}`);
      
      // send to api the channel received the message and the friend_code
      
    }
  } catch(exception) {
    logger.error(exception);
  }
});

client.connect();

cron.schedule('*/15 * * * *', () => {
  logger.info('retrieve channels from API');
  
  // client
  //   .join(channel)
  //   .then(m => {
  //     console.log("Joined: " + m)
  //   })
  //   .catch(err => {
  //     console.log("Unable to join channel: " + channel + " Error: " + err);
  //   });  
});
