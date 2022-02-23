var http = require('http');
var module = require('./module')

http.createServer(function (req, res) {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.write('Request: '+req.url)
    res.write(`Current date returned from server: ${module.getdate()}`);
    res.end();
}).listen(8080);

console.log("Listening on port " + '8080')

