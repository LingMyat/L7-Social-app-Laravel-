const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server,{
    cors : { origin:"*"}
});

let users = [];

// Run when client connects
io.on('connection',(socket)=>{
    console.log('Someone is connect');

    socket.on('joinRoom',(joinRoomData)=>{
        socket.join(joinRoomData.roomId);
        users.push({
            id : socket.id,
            name : joinRoomData.name,
            profile : joinRoomData.profile,
            roomId : joinRoomData.roomId
        });
        socket.on('message',(data)=>{
            io.sockets.to(joinRoomData.roomId).emit('message',data);
        });

        socket.broadcast.to(joinRoomData.roomId).emit('joining',joinRoomData.name);
    })


    socket.on('disconnect',()=>{
        const user = users.find(e=>e.id == socket.id);
        if(user){
            let index = users.findIndex(e=>e.id == user.id);
            users.splice(index,1);
            io.sockets.to(user.roomId).emit('leaving',user.name);
        }else {
            console.log('not in room');
        }
    })
})

server.listen(3000,()=>{
    console.log('your server is running on port 3000');
})


