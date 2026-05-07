# Ominimo Blog

A simple blog application built with Laravel as part of the Ominimo Insurance backend developer interview assignment.

## Features

- User registration, login, and logout (Laravel Breeze)
- Create, edit, and delete blog posts (owners only)
- Leave comments on posts (guests and authenticated users)
- Delete comments (comment owner or post owner)
- Admin role — can delete any post or comment
- Laravel Policies for authorization
- Database seeders with sample data
- Fully containerized with Docker
- 38 feature and unit tests

---

## Tech Stack

- **Backend:** Laravel 11, PHP 8.3
- **Database:** MySQL 8
- **Frontend:** Blade, Tailwind CSS
- **Auth:** Laravel Breeze
- **Containerization:** Docker and Docker Compose

---

## Local Setup (Without Docker)

### Requirements
- PHP 8.3+
- Composer
- Node.js 20+
- MySQL 8

### Steps

**1. Clone the repository**

    git clone https://github.com/Hamza-fray/ominimo-blog.git
    cd ominimo-blog

**2. Install dependencies**

    composer install
    npm install && npm run build

**3. Configure environment**

    cp .env.example .env
    php artisan key:generate

**4. Update `.env` with your database credentials**

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ominimo_blog
    DB_USERNAME=root
    DB_PASSWORD=your_password

**5. Run migrations and seed sample data**

    php artisan migrate --seed

**6. Start the server**

    ./local.sh

Note: local.sh fixes storage permissions and starts the server in one command.
If you are running locally for the first time without having run Docker before, you can use php artisan serve directly.

Visit http://localhost:8000

---

## Local Setup (With Docker)

### Requirements
- Docker
- Docker Compose

### Steps

**1. Clone the repository**

    git clone https://github.com/Hamza-fray/ominimo-blog.git
    cd ominimo-blog
**2. Configure Docker environment**

    cp .env.docker.example .env.docker
    php artisan key:generate --env=docker
**3. Build and start containers**

    docker compose up --build

Note: The Docker setup automatically runs migrations and seeds the database on startup.

Visit http://localhost:8000

---

## Switching Between Docker and Local

Docker changes the ownership of the storage directory to www-data. After stopping Docker, always use:

    ./local.sh

This script restores permissions and starts the server automatically.

---

## Sample Credentials (after seeding)

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@example.com   | password |
| User  | user@example.com    | password |

---

## Running Tests

    php artisan test

Expected output: 38 tests passing

---

## Routes

| Method | Route                    | Description            | Auth          |
|--------|--------------------------|------------------------|---------------|
| GET    | /posts                   | List all posts         | Public        |
| GET    | /posts/create            | Create post form       | Required      |
| POST   | /posts                   | Store post             | Required      |
| GET    | /posts/{id}              | View post and comments | Public        |
| GET    | /posts/{id}/edit         | Edit post form         | Owner only    |
| PUT    | /posts/{id}              | Update post            | Owner only    |
| DELETE | /posts/{id}              | Delete post            | Owner or Admin|
| POST   | /posts/{id}/comments     | Add comment            | Public        |
| DELETE | /comments/{id}           | Delete comment         | Owner or Admin|
