# Laravel 10 + Mazer Admin Dashboard

This documentation explains how to use **Laravel 10** integrated with **Mazer Admin Dashboard Template** for building a modern admin panel.

---

## 📌 Project Overview

This project is a **Laravel 10** web application that uses **Mazer** as the admin dashboard UI. It is suitable for information systems, admin panels, and internal applications.

---

## 🧰 Tech Stack

- **Laravel 10** – Backend Framework
- **PHP >= 8.1**
- **Mazer Admin Template** (HTML, CSS, JavaScript)
- **Bootstrap 5**
- **Vite** – Asset Bundler
- **MySQL / MariaDB** – Database

---

## 📂 Important Folder Structure

```bash
project-root/
├── app/
├── public/
│   └── assets/mazer/        # Mazer CSS & JS assets
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── dashboard.blade.php
├── routes/
│   └── web.php
├── composer.json
└── README.md
```

---

## ⚙️ Installation

### 1️⃣ Clone Repository

```bash
git clone https://github.com/username/project-name.git
cd project-name
```

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

### 3️⃣ Install Frontend Dependencies

```bash
npm install
npm run dev
```

### 4️⃣ Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Configure database in `.env`

```env
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Run Database Migration

```bash
php artisan migrate
```

### 6️⃣ Run Development Server

```bash
php artisan serve
```

Access the application at:

```
http://127.0.0.1:8000
```

---

## 🎨 Integrating Mazer with Laravel

### 1. Download Mazer

Download from:

```
https://zuramai.github.io/mazer/
```

### 2. Copy Assets

Copy the following folder into Laravel:

```
mazer/dist/assets → public/assets/mazer
```

### 3. Blade Layout (`app.blade.php`)

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/mazer/css/app.css') }}">
</head>
<body>
    @include('partials.sidebar')

    <div id="main">
        @yield('content')
    </div>

    <script src="{{ asset('assets/mazer/js/app.js') }}"></script>
</body>
</html>
```

---

## 🧪 Example Route

```php
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
});
```

---

## ✅ Best Practices

- Use **Blade layouts** to reuse UI components
- Store third-party assets inside the `public/` directory
- Separate UI components (`sidebar`, `navbar`) into `partials`
- Protect admin routes using `auth` middleware

---

## 📖 References

- Laravel Documentation: [https://laravel.com/docs/10.x](https://laravel.com/docs/10.x)
- Mazer Documentation: [https://zuramai.github.io/mazer/](https://zuramai.github.io/mazer/)

---

## 👨‍💻 Author

Disan J
Laravel 10 & Frontend Developer

---

## 📝 License

This project is licensed under the **MIT License**.
