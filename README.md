# Real-time Chat App

This repository contains a project designed to test Pusher and real-time sockets by implementing a chat application. The chat app leverages Pusher for real-time communication, ensuring messages are delivered instantly to all connected users. This project serves as a practical example of integrating real-time features into a web application, making it a valuable resource for learning and experimenting with socket-based communication.

## Features

- **Real-time Messaging**: Instantly send and receive messages using Pusher.
- **User Authentication**: Basic authentication to manage user sessions.
- **Message History**: Keep a record of previous messages for each chat room.
- **Responsive Design**: User-friendly interface compatible with both desktop and mobile devices.

## Technologies Used

- **Backend**: Laravel
- **Frontend**: HTML, Bootstrap CSS, JavaScript (jQuery)
- **Real-time Communication**: Pusher
- **Database**: MySQL

## Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/abodoma17/chat-app-test.git
   cd chat-app-test
   ```

2. Configure environment variables:
   - Create a `.env` file in the root directory.
   - Add your Pusher credentials and other necessary environment variables.

3. Run migrations and start queue:
   ```bash
   php artisan migrate
   php artisan queue:work
   ```

## Contribution

Feel free to fork this repository, open issues, and submit pull requests. Contributions are welcome!
