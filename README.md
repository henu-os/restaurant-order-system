# 🍽️ Restaurant Automation System (RAS)

A complete Restaurant Order Management & Automation System built using **PHP (Core PHP)** and **MySQL**.

This system allows restaurants to manage employees, categories, menu items, floor plans, and customer orders with role-based login access.

---

## 🚀 Features

- 🔐 Role-Based Login System (Waiter, Cook, Busboy, Host)
- 👨‍🍳 Employee Management
- 📂 Category & Menu Item Management
- 🏢 Floor Plan/Table Management
- 🧾 Order Processing System
- 💳 Payment Handling
- 📊 Organized Dashboard Interface
- 🗄 MySQL Database Integration

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, Bootstrap
- **Backend:** PHP (Core PHP)
- **Database:** MySQL
- **Server:** XAMPP / PHP Built-in Server

---
Restaurant-Order-System/
│
├── css/
├── js/
├── includes/
│ ├── connectdb.inc.php
│ ├── settings.inc.php
│
├── Database/
│ └── oose.sql
│
├── index.php
├── login.php
├── logout.php
└── README.md


---

## ⚙️ Installation & Setup

### 1️⃣ Clone Repository

```bash
git clone https://github.com/henu-os/Restaurant-Order-System.git

## 📂 Project Structure

2️⃣ Setup Database
Start XAMPP

Open: http://localhost/phpmyadmin

Create a new database:
restaurant-order-system
Import the file:

Database/oose.sql

3️⃣ Configure Database Connection
Open:

includes/settings.inc.php
Ensure:

$dbname = "restaurant-order-system";
$dbuser = "root";
$dbpass = "";
$dblocation = "localhost";
4️⃣ Run Project
Option 1 (Recommended - XAMPP):

Place project inside:

xampp/htdocs/
Open:

http://localhost/Restaurant-Order-System/
Option 2 (PHP built-in server):

php -S localhost:8000
Open:

http://localhost:8000
🔑 Default Login Credentials
Role	Username	Password
Waiter	waiter	123
Cook	cook	123
Busboy	busboy	123
Host	host	123

📈 Future Improvements
Password hashing with bcrypt

Admin panel

Sales reports & analytics

REST API integration

UI improvements

👨‍💻 Author
Developed by Lakshit Soni

📜 License
This project is open-source and available under the MIT License.


---

# 🔥 Optional (Professional Touch)

Add this badge at top (optional):

```markdown
![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![Status](https://img.shields.io/badge/Status-Working-success)
🎯 Result

Your repo will look:
Clean
Professional
Internship-ready
Resume-worthy
Client-ready
