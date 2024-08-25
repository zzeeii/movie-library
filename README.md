# Laravel Movie Rating API

This is a Laravel-based API for managing movies, users, and ratings. The API allows users to create, update, delete, and retrieve movie records, user accounts, and ratings for movies. It includes robust exception handling to provide informative error responses.

## Table of Contents

- [Features](#features)
-[Installation](#installation)
- [Running the Application](#running-the-application)
- [Database Seeding](#database-seeding)
- [Configuration](#api-Configuration)
- [Usage](#Usage)
- [Movie Endpoints](#Movie Endpoints)
- [User Endpoints](#User Endpoints)
- [Rating Endpoints](#Rating Endpoints)
- [Error Handling](#Error Handling)

## Features

- **Movies**: CRUD operations for movies.
- **Users**: User management with unique email validation.
- **Ratings**: Rate movies with optional reviews, including CRUD operations.
- **Exception Handling**: Custom error responses for common issues like model not found, validation errors, and general exceptions.

## Installation

To get started with the Laravel Movie Rating API, follow these steps:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/zeeii/movie-library.git
    cd movie-library
    ```

2. **Install the dependencies using Composer**:
    ```bash
    composer install
    ```
3. **Install XAMPP**

## Running the Application
To run the application locally, use the following command:
 ```bash
   php artisan serve
```
The application will be available at http://localhost:8000
## Database Seeding
To populate the database with initial data, use the following command:
```bash
php artisan migrate --seed
```
This will create the necessary tables and seed the database with sample movies and users.


## Configuration

After setting up the environment variables in the `.env` file, ensure the following configurations:

- **Database Configuration**:
  Make sure your `.env` file contains the correct database settings:
  
  ```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movie_library3
DB_USERNAME=root
DB_PASSWORD=

## Usage
### Movie Endpoints
Create Movie: POST /api/movies
Retrieve All Movies: GET /api/movies
Retrieve Movie by ID: GET /api/movies/{id}
Update Movie: PUT /api/movies/{id}
Delete Movie: DELETE /api/movies/{id}
### User Endpoints
Create User: POST /api/users
Retrieve All Users: GET /api/users
Retrieve User by ID: GET /api/users/{id}
Update User: PUT /api/users/{id}
Delete User: DELETE /api/users/{id}
### Rating Endpoints
Create Rating: POST /api/ratings
Retrieve All Ratings: GET /api/ratings
Retrieve Rating by ID: GET /api/ratings/{id}
Update Rating: PUT /api/ratings/{id}
Delete Rating: DELETE /api/ratings/{id}
## Error Handling
The API provides informative error responses for different scenarios:

404 Not Found: Returned when a model is not found.
422 Validation Error: Returned when validation fails.
500 Internal Server Error: Returned for general exceptions.