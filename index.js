const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server,{
    cors : { origin:"*"}
});


// Run when client connects
io.on('connection',(socket)=>{
    console.log('Someone is connect');

    socket.on('message',(data)=>{
        io.sockets.emit('message',data);
    });
    socket.on('disconnect',(socket)=>{
        console.log('someone was leave now');
    })
})

server.listen(3000,()=>{
    console.log('your server is running on port 3000');
})


