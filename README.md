# PetPals - Pet Selling Website

PHP/MySQL project for XAMPP where buyers can order pets, sellers can list pets, and admin can manage users, pets and orders.

## Setup

1. Copy this folder to `xampp/htdocs/pat`.
2. Start Apache and MySQL from XAMPP.
3. Open phpMyAdmin and import `database.sql`.
4. Visit `http://localhost/pat/`.

## Login Options

All seed accounts use password `123456`.

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@petpals.com` | `123456` |
| Seller | `seller@petpals.com` | `123456` |
| Buyer | `buyer@petpals.com` | `123456` |

## Main Pages

- `index.php`: Home page
- `register.php`: Register as buyer or seller with picture, radio and select input
- `login.php`: User/admin login
- `dashboard.php`: Role based dashboard
- `browse.php`: Browse and order available pets
- `add-pet.php`: Seller pet listing form
- `my-pets.php`: Seller pet list
- `orders.php`: Buyer/seller order tracking
- `profile.php`: Profile update
- `pass-change.php`: Change password
- `admin/index.php`: Admin panel

## Database

The updated SQL file is `database.sql`. It recreates the database, tables, categories, sample users and sample pets.
