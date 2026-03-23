La Cosmetica API
A professional backend system for a cosmetics store built with Laravel 11, PostgreSQL, and Docker, following the DTO/DAO/Service architectural pattern.

🚀 Quick Start (Docker)
Environment Setup:
Copy .env.example to .env and ensure the following:

Extrait de code
DB_CONNECTION=pgsql
DB_HOST=db
DB_PASSWORD=123456
Launch Containers:

PowerShell
docker-compose up -d --build
Initialize Application:

PowerShell
# Enter the app container
docker-compose exec app bash

# Install dependencies & Generate keys
composer install
php artisan key:generate
php artisan jwt:secret

# Run Migrations & Seeders
php artisan migrate --seed
🏗️ Architecture & Features
Design Pattern: Strict separation of concerns (DTO -> DAO -> Service).

Security: Role-based access control (Admin, Employee, Client) using Spatie.

Authentication: Stateless API authentication via JWT.

Performance: Advanced dashboard statistics using Query Builder.

📍 Key Endpoints
POST /api/login - User authentication.

GET /api/products/{slug} - Fetch product details by Slug.

POST /api/orders - Place a new order (Client only).

GET /api/admin/stats - Management dashboard stats (Admin only).

🛠️ Business Rules
Images: Maximum of 4 images per product.

Inventory: Automatic stock deduction upon order and restoration upon cancellation.

Slug: SEO-friendly URLs generated automatically from product names.