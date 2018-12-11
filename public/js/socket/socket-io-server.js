const http = require('http').Server();
const io = require('socket.io')(http);
const Redis = require('ioredis');

// initialize new instance from Redis
var redis_client = new Redis();

// subscribe to the tweet created channel
redis_client.subscribe('tweet-created');

// listen to the channel
redis_client.on('message', (channel, message) => {
    message = JSON.parse(message);
    // emit the new tweet
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(3000, () => {
    console.log('Node server listening on Port 3000 .........');
    
});