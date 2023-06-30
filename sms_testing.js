
const cron = require("node-cron");
const url = 'https://semaphore.co/api/v4/messages';
const apiKey = 'c17f81a2eb07d0ad839118cad67d2c55';
const senderName = 'SEMAPHORE';
const pnum = '09234726098';

function sendMessagePills() {
    
const message = `Hi, this is SiPa!\n\nDon't forget to take your prescribed contraceptive pills today.\n\n For more information about contraceptive methods, please visit our website.\n\nThanks! `;
  
    const parameters = new URLSearchParams({
      apikey: apiKey,
      number: pnum,
      message: message,
      sendername: senderName
    });
  
    fetch(url, {
      method: 'POST',
      body: parameters
    })
      .then(response => response.text())
      .then(output => {
        console.log(output); // Show the server response
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  
  
  // Example usage
  cron.schedule("2 * * * *", sendMessagePills());