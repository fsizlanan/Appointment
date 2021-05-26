var express = require('express');
var app = express();
var http = require("http").createServer(app);
var io = require("socket.io")(http);

app.get("/", function(req, res) {
    res.send("Burası Ana Sayfa");
});

io.on("connection", function (socket){
    socket.on("new_appointment_create", function() {
        io.emit("admin_appointment_list");
    });
});

http.listen(3000, function() {
    console.log("Server Çalışıyor...");
});
