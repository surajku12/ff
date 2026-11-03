# FASHIOFY E-Commerce Database Setup

## Database Import Instructions

### Step 1: Access phpMyAdmin
1. Start your XAMPP control panel
2. Make sure Apache and MySQL services are running
3. Open your browser and go to: `http://localhost/phpmyadmin`

### Step 2: Import the Database
1. Click on "New" in the left sidebar to create a new database
2. Enter database name: `fashiofy`
3. Click "Create"
4. Click on the "fashiofy" database in the left sidebar
5. Click on the "Import" tab at the top
6. Click "Choose File" and select the `database_dump.sql` file from your project folder
7. Click "Go" to import the database structure

### Step 3: Alternative - Run Setup Script
If you prefer to create the database programmatically:
1. Make sure MySQL is running in XAMPP
2. Open command prompt and navigate to your project folder
3. Run: `php setup-db.php`
4. The script will create the database and all tables automatically

## Database Tables

### users
- Stores user account information
- Tracks login history and count

### login_logs
- Records every login attempt
- Includes IP address and user agent for security

### orders
- Stores order information
- Linked to users table

### order_items
- Stores individual items in each order
- Includes status for tracking cancellations

### cancellations
- Records product cancellations
- Tracks refund status

## Features Added

### Login Tracking
- User registration on first login
- Login count and last login timestamp
- IP address and user agent logging

### Product Cancellation Tracking
- Records when users remove items from cart
- Stores cancellation reason and timestamp
- Tracks refund status

### User Profile Display
- Shows login history and account information
- Displays in the user profile section

## Security Notes
- Passwords are hashed using PHP's password_hash()
- User input is validated on both client and server side
- SQL injection prevention using prepared statements

## Testing
1. Try logging in with any email/password (first time creates account)
2. Add items to cart and remove them to test cancellation tracking
3. Place orders to see user_id linking
4. Check phpMyAdmin to view stored data