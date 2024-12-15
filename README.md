# Guessing Game Project

## Overview
The Guessing Game is a web-based application where users can log in, play a number guessing game, and track their game history. The application allows users to:

- Start a new round by guessing a random number between 1 and 100.
- Submit guesses and receive feedback.
- Reveal the correct number.
- View their previous game results.

## Features
1. **User Authentication:**
   - Secure login system using sessions.
   - User-specific game history saved in a database.

2. **Game Mechanics:**
   - Random number generation between 1 and 100.
   - Limited number of guesses per game.
   - Feedback on each guess (“Higher” or “Lower”).

3. **Game History:**
   - Displays all previous game results, including:
     - Date of the game.
     - Game status (“Success” or “Fail”).
     - Target number.
     - Number of guesses used.

4. **Responsive Design:**
   - Uses Bootstrap for a clean and user-friendly interface.

## Requirements
### Server Requirements
- PHP 7.4 or higher
- MySQL Database
- Apache or Nginx web server

### Client Requirements
- Modern web browser (e.g., Chrome, Firefox, Edge)

## Installation
1. **Clone the Repository:**
   ```bash
   git clone https://github.com/mariem1mansour/number-guess-game
   ```
2. **Set Up the Database:**
   - Import the `schema.sql` file into your MySQL database:
     ```bash
     mysql -u your_user -p your_database < schema.sql
     ```
   - Update the database credentials in `db.php`:
     ```php
     $host = 'your_host';
     $dbname = 'your_database';
     $username = 'your_username';
     $password = 'your_password';
     ```

3. **Set Up File Permissions:**
   - Ensure `db.php` and session directories are readable/writable by the server.

4. **Launch the Server:**
   - Start a local server:
     ```bash
     php -S localhost:8000
     ```
   - Or deploy to a web server.

## Usage
1. **Register/Login:**
   - Visit `login.php` to log in or create a new account.

2. **Start a New Game:**
   - Click the “Start New Round” button and specify the number of guesses allowed.

3. **Make Guesses:**
   - Enter a number in the input field and submit your guess.
   - Receive feedback until you guess correctly or run out of attempts.

4. **View Game History:**
   - Check your game history table to see details of previous games.

## Project Structure
```
project-root/
├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── game.js
├── db.php
├── index.php
├── login.php
├── game.php
├── schema.sql
└── README.md
```

### Key Files
- `index.php`: Main dashboard after login.
- `login.php`: Handles user authentication.
- `game.php`: Backend logic for the game mechanics.
- `db.php`: Database connection.
- `schema.sql`: SQL file to create required database tables.

## Example Database Schema
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE rounds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    username VARCHAR(50),
    status ENUM('Success', 'Fail') NOT NULL,
    target_number INT NOT NULL,
    num_guesses INT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## Contributing
Contributions are welcome! Feel free to submit a pull request or open an issue to report bugs or suggest new features.

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.

## Acknowledgments
- Inspired by classic number guessing games.
- Built with PHP, Bootstrap, and JavaScript for a seamless user experience.


