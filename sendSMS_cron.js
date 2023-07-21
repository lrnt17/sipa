const axios = require('axios');
const cron = require('node-cron');

// Define the cron schedule (runs every minute in this example)
cron.schedule('* * * * *', async () => {
  try {
    const apiUrl = 'https://semaphore.co/api/v4/messages';
    const apiKey = 'c17f81a2eb07d0ad839118cad67d2c55'; // Your API KEY
    const phoneNumber = '09234726098';
    const senderName = 'SEMAPHORE';

    // Prepare the request payload
    const payload = {
      apikey: apiKey,
      number: phoneNumber,
      message: `"Hi, this is SiPa! Do not forget to take your prescribed contraceptive pills today.For more information about contraceptive methods, please visit our website.Thanks!`,
      sendername: senderName,
    };

    // Send the POST request to the API
    const response = await axios.post(apiUrl, payload);
    console.log(`Message sent successfully. Response: ${response.data}`);
  } catch (error) {
    console.error(`Error sending the message: ${error}`);
  }
});
