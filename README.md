# TaskManager (Laravel 12)

A Mini Task Management System — Web (Blade + Bootstrap) + REST API (Sanctum), with scheduled queued email reminders.

## Features
- Web app (Bootstrap) — auth, task CRUD, pagination, filters
- REST API (`/api/v1`) — token-based auth (Sanctum), task CRUD, pagination, filters
- Scheduled queued job sends reminder emails for tasks due tomorrow
- Role-based access: `admin` can view all tasks; `user` can view own tasks
- FormRequest validation (web), API Resources (JSON output)
- Queue (database) + Mail (log in development)

---

## Quick setup (local - Windows / Linux)

### Requirements
- PHP 8.1+ (compatible with Laravel 12)
- Composer
- Node 18+ and npm
- MySQL (or compatible DB)
- Optional: Redis for queue in production (we use database driver by default)

### Install

```bash
# clone the repo
git clone <repository-url> task-manager
cd task-manager

# install PHP deps
composer install

# copy env and generate key
cp .env.example .env
php artisan key:generate

# configure .env - DB, APP_URL etc
# Example (local):
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=task_manager
# DB_USERNAME=root
# DB_PASSWORD=

# install JS deps and build assets
npm install
npm run dev

# create DB then run migrations, db name should be 'task_manager'
php artisan migrate

# create queue table
php artisan queue:table
php artisan migrate

# seed sample tasks
php artisan db:seed --class=SampleTasksSeeder

#seed admin user, default: admin@gmail.com|Admin
php artisan db:seed --class=AdminUserSeeder

# serve app
php artisan serve --host=127.0.0.1 --port=8000

# start queue worker (another terminal)
php artisan queue:work

# development scheduler (another terminal)
php artisan schedule:work

# run cron instantly
php artisan tasks:send-due-reminders

# check email content in log
Get-Content storage\logs/laravel.log -Tail 80