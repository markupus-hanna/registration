# Registration App

A minimal MVC-style user registration system built with PHP 8+, PDO, and Composer.  
Includes basic routing, validation, CSRF protection, and Docker support.

---

## 🚀 Features

- 🧭 Clean route handling via HTTP method + URI
- 🧩 PSR-4 autoloading via Composer
- 🧪 Form validation & CSRF protection
- 🔐 Login / Register / Logout flows
- 🐳 Docker support for local development

---

## 🧱 Project Structure

```
registration/
├── app/                 # Controllers, models, views
├── core/                # App, Controller, Database, Validator, etc.
├── public/              # Entry point (index.php)
├── views/               # Blade-style PHP templates
├── routes.php           # Centralized routing table
├── .env                 # Environment variables
├── docker-compose.yml   # Docker setup
└── composer.json        # Composer autoloading & dependencies
```

---

## ⚙️ Requirements

- Docker + Docker Compose (or PHP 8.1+ with MySQL locally)
- Composer

---

## 🐳 Running with Docker

```bash
docker-compose up --build
```

App will be available at: [http://localhost:8082](http://localhost:8082)

---

## 🧪 Routes

| Route        | Method | Description                |
|--------------|--------|----------------------------|
| `/register`  | GET    | Show registration form     |
| `/register`  | POST   | Handle registration        |
| `/login`     | GET    | Show login form            |
| `/login`     | POST   | Handle login               |
| `/logout`    | GET    | Logout and destroy session |
| `/dashboard` | GET    | Protected dashboard route  |

---

## 🧼 Notes

- CSRF tokens are generated automatically per form.
- Passwords are securely hashed using `password_hash`.
- No frontend framework — pure server-side PHP views.

---

## ✅ TODO

- Add email verification
- Add user role management
- Add tests (PHPUnit)

---

## 🤝 License

MIT
