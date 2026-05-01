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
- **Containerization:** Docker & Docker Compose

---

## Local Setup (Without Docker)

### Requirements
- PHP 8.3+
- Composer
- Node.js 20+
- MySQL 8

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/Hamza-fray/ominimo-blog.git
cd ominimo-blog

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies and build assets
npm install && npm run build

# 4. Copy environment file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ominimo_blog
DB_USERNAME=root
DB_PASSWORD=your_password

# 7. Run migrations and seed sample data
php artisan migrate --seed

# 8. Start the server
php artisan serve
```

Visit `http://localhost:8000`

---

## Local Setup (With Docker)

### Requirements
- Docker
- Docker Compose

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/Hamza-fray/ominimo-blog.git
cd ominimo-blog

# 2. Build and start containers
docker compose up --build
```

Visit `http://localhost:8000`

The Docker setup automatically runs migrations and seeds the database on startup.

---

## Sample Credentials (after seeding)

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@example.com   | password |
| User  | user@example.com    | password |

---

## Running Tests

```bash
php artisan test
```

Expected output: **38 tests passing**

---

## API Routes

| Method | Route | Description | Auth |
|--------|-------|-------------|------|
| GET | /posts | List all posts | Public |
| GET | /posts/create | Create post form | Required |
| POST | /posts | Store post | Required |
| GET | /posts/{id} | View post + comments | Public |
| GET | /posts/{id}/edit | Edit post form | Owner only |
| PUT | /posts/{id} | Update post | Owner only |
| DELETE | /posts/{id} | Delete post | Owner/Admin |
| POST | /posts/{id}/comments | Add comment | Public |
| DELETE | /comments/{id} | Delete comment | Owner/Admin |
