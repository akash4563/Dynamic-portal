# LTSG Portal

This dynamic portal provides centralized links for various tools and services.

## Architecture

- **Frontend:** HTML, CSS, PHP
- **Data Source:** `data.json` acts as a database.
- **Backend Updates:** `update_data.py` provides logic for dynamically updating the links.

## Usage

Start the PHP development server:
```bash
php -S localhost:8000
```
Navigate to `http://localhost:8000/index.php`.

## Login

Default admin credentials configured in `auth.php`:
Username: `admin`
Password: `password`
