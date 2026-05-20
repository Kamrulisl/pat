# PetPals - Pet Selling Website

PetPals is a buy and sell pet project with **2 panels only**:

- **Admin Panel**: Admin works as the seller. Admin can add pets/products, manage users, manage products and update orders.
- **User Panel**: User works as the buyer. User can browse pets/products and place orders.

There is no separate seller account. Admin is the seller, user is the buyer.

---

## English Setup Process

1. Keep this project folder inside `D:\PHP\htdocs\pat` or `xampp\htdocs\pat`.
2. Start **Apache** and **MySQL** from XAMPP.
3. Open phpMyAdmin: `http://localhost/phpmyadmin`.
4. Import `database.sql`.
5. Visit the project: `http://localhost/pat/`.

## Bangla Setup Process

1. Project folder ta `D:\PHP\htdocs\pat` ba `xampp\htdocs\pat` er moddhe rakhun.
2. XAMPP theke **Apache** and **MySQL** start korun.
3. Browser e phpMyAdmin open korun: `http://localhost/phpmyadmin`.
4. `database.sql` file import korun.
5. Website run korun: `http://localhost/pat/`.

---

## Login Options

All demo accounts use password `123456`.

| Panel | Role | Email | Password |
| --- | --- | --- | --- |
| Admin Panel | Admin as seller | `admin@petpals.com` | `123456` |
| User Panel | User as buyer | `user@petpals.com` | `123456` |

## Login Options Bangla

Sob demo account er password `123456`.

| Panel | Role | Email | Password |
| --- | --- | --- | --- |
| Admin Panel | Admin seller er kaj korbe | `admin@petpals.com` | `123456` |
| User Panel | User buyer er kaj korbe | `user@petpals.com` | `123456` |

---

## Main Features

- Admin login
- User registration and login
- Admin can add products/pets
- Admin can manage users
- Admin can manage products/pets
- Admin can update order status
- User can browse products/pets
- User can buy/order products/pets
- Profile update
- Password change
- Updated SQL file with admin, user, categories and sample pets

## Main Pages

- `index.php`: Home page
- `register.php`: User/buyer registration
- `login.php`: Admin/user login
- `dashboard.php`: Redirects users to the correct panel
- `browse.php`: User product/pet browse and order page
- `add-pet.php`: Admin product/pet add page
- `my-pets.php`: Admin product list
- `orders.php`: Admin/user order tracking
- `profile.php`: Profile update
- `pass-change.php`: Change password
- `admin/index.php`: Admin panel
- `user/index.php`: User panel

---

## Database

The updated database file is:

```text
database.sql
```

This SQL file creates:

- `Users`
- `Categories`
- `Pets`
- `Orders`
It also inserts demo admin, demo user, categories and multiple sample pets/products added by admin.

## Git Push Process

If Git shows dubious ownership, run this once:

```powershell
git config --global --add safe.directory D:/PHP/htdocs/pat
```

Then push:

```powershell
git add .
git commit -m "Use admin as seller and user as buyer"
git branch -M main
git push -u origin main
```

If remote is missing:

```powershell
git remote add origin https://github.com/Kamrulisl/pat.git
```

## Git Push Process Bangla

Jodi Git ownership error dey, ei command ekbar run korun:

```powershell
git config --global --add safe.directory D:/PHP/htdocs/pat
```

Tarpor push korun:

```powershell
git add .
git commit -m "Use admin as seller and user as buyer"
git branch -M main
git push -u origin main
```

Remote na thakle:

```powershell
git remote add origin https://github.com/Kamrulisl/pat.git
```
