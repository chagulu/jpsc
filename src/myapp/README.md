# JPSC Laravel + MySQL (Dockerized)

This repository contains a Laravel 10 (PHP 8) application and a MySQL 8 database fully containerized with Docker.
Anyone who clones the repo can spin up the full stack in minutes—no local PHP/MySQL install required.

---

## Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (or Docker Engine 20.10+)
- [Docker Compose plugin](https://docs.docker.com/compose/install/) (v2+ is built into Docker Desktop)
- (Optional) [Git](https://git-scm.com/)

---

## Quick Start

```bash
# 1. Clone the repo
git clone https://github.com/your-org/jpsc.git
cd jpsc

# 2. Start the containers
docker compose up -d --build

# 3. Check running containers
docker ps

# 4. Enter the PHP container (optional)
docker exec -it jpsc_app bash

# 5. Install PHP dependencies (first run only)
composer install

# 6. Generate Laravel APP_KEY
php artisan key:generate

# 7. Run migrations / seeders (optional)
php artisan migrate --seed
