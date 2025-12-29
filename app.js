const http = require('http');

// Define the port to listen on
const PORT = 3000;

// Create a server that responds with "Hello, World!"
const server = http.createServer((req, res) => {
  res.statusCode = 200;               // Set HTTP status to 200 (OK)
  res.setHeader('Content-Type', 'text/plain');  // Set response type
  res.end('Hello, World!\n');         // Send response text
});

// Start the server
server.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}/`);
});
