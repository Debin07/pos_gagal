# POS Gagal — Gas & Galon Management System

Created by **Debin07**
GitHub: https://github.com/Debin07

---

## ⚠️ Ownership Notice

This repository is publicly visible for portfolio and learning purposes.

Please respect the author's ownership and do not redistribute, resell, commercialize, or claim this project as your own without permission from the author.

---

## 🚀 Features

* ✅ Product Management (Gas & Gallon)
* ✅ Stock & Restock Management
* ✅ Point of Sale (POS) System
* ✅ Customer Management
* ✅ Transaction Reports
* ✅ Filament Admin Panel
* ✅ Multi-user Support
* ✅ Responsive Dashboard
* ✅ Sales History
* ✅ Inventory Monitoring

---

## 🛠️ Tech Stack

* **Backend**: Laravel 12
* **Admin Panel**: Filament 3
* **Database**: MySQL
* **Styling**: Tailwind CSS
* **Runtime**: PHP 8.2+
* **Deployment**: VPS / Cloud Server

---

## 📋 Requirements

* PHP 8.2+
* Composer
* Node.js & NPM
* MySQL / MariaDB
* Git

---

## 🔧 Installation

### 1. Clone Repository

```bash
git clone https://github.com/Debin07/pos_gagal.git
cd pos_gagal
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:

```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then run migration:

```bash
php artisan migrate
```

Optional seeder:

```bash
php artisan db:seed
```

### 5. Build Assets

```bash
npm run build
```

### 6. Run Development Server

```bash
php artisan serve
```

---

## 🌐 Deployment

This project can be deployed using:

* VPS (Ubuntu + Nginx)
* Railway
* Render
* Vercel (frontend only)
* Docker
* Local server with Cloudflare Tunnel

---

## 📦 Main Modules

* Product Management
* Inventory & Stock
* POS / Transaction
* Customer Data
* Sales Report
* Dashboard Analytics
* Admin Authentication

---

## 🔐 Admin Access

Admin account can be created manually using:

```bash
php artisan make:filament-user
```

---

## 📁 Project Structure

```bash
app/
database/
resources/
routes/
public/
```

---

## 📌 Development Status

This project is actively developed and used as:

* Learning project
* Portfolio project
* POS system experimentation
* Filament dashboard exploration

---

## 📞 Contact

GitHub: https://github.com/Debin07

---

## 📄 License & Usage

Copyright (c) 2026 Debin07

Allowed:

* Personal learning
* Private modification
* Educational purposes

Not allowed without permission:

* Commercial use
* Reselling source code
* Reuploading as your own project
* Removing author identity
* Using for paid client projects

Please contact the author for commercial licensing.
