
# Laravel Project Setup Guide

Welcome to the Laravel project! Follow the steps below to get the project running on your local machine. This guide will take you through everything from installing dependencies to running the backend and frontend servers.

## Prerequisites

Before you start, make sure you have the following tools installed:

- PHP >= 8.1
- Laravel >= 10
- Composer (for managing PHP dependencies)
- MySQL (or another database of your choice)
- Node.js (for frontend development)

## Step-by-Step Installation

### 1. Clone the Repository

Start by cloning the project repository to your local machine:


**git clone https://github.com/your-repository-name.git
cd your-repository-name**


### 2. Install Dependencies

Run the following command to install the Laravel project dependencies:


**composer install** 



### 3. Set Up the Environment Configuration


* Copy the `.env.example` file to `.env`:

**cp .env.example .env**

.

### 4. Generate Application Key


**php artisan key:generate**


### 5. Configure the Database


**DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password**


### 6. Run Database Migrations


**php artisan migrate**


### 7. Run the Seeder (Optional)


**php artisan db:seed** 
*note: please wait, this will take a while


### 8. Start the Backend Server

To run the backend, use the following command to start the Laravel development server:


**php artisan serve --port=8000**


Your backend will now be accessible at **http://127.0.0.1:8000**.

### 9. Start the Frontend Server

For the frontend, you can choose any available port other than 8000. First, install the frontend dependencies:

**php artisan serve --port=your-port**


Your frontend will now be accessible at **http://127.0.0.1:your-port**.

## Conclusion

With these steps, your Laravel application should now be up and running. You can interact with the backend via `http://127.0.0.1:8000` and the frontend on a different port like `http://localhost:your-port`.


### 1. List Book Page

![image](https://github.com/user-attachments/assets/366ba2dc-a3e9-4342-8dcc-b58a7c358f42)

### 2. Top 10 Author
![uhuy](https://github.com/user-attachments/assets/393ef0e0-70ec-48bb-8972-347cc4648965)
![image](https://github.com/user-attachments/assets/70ab87df-ea98-4b90-8995-d464bde888ae)

### 3. Input Rating Page
![uhuy1](https://github.com/user-attachments/assets/6ef18cda-2c83-460a-8b05-9e9d7683f862)
![image](https://github.com/user-attachments/assets/5f13f648-e51e-4a4b-afaa-ea34131f232c)




