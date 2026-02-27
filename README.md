# 📝 Blogging Website

![HTML](https://img.shields.io/badge/Frontend-HTML5-orange)
![CSS](https://img.shields.io/badge/Style-CSS3-blue)
![JavaScript](https://img.shields.io/badge/Script-JavaScript-yellow)
![PHP](https://img.shields.io/badge/Backend-PHP-purple)
![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL-blue)
![Status](https://img.shields.io/badge/Project-Active-success)

A dynamic and responsive **Full Stack Blogging Platform** built using **HTML, CSS, JavaScript, PHP, and PostgreSQL**.  
The application allows users to register, log in, create blog posts, manage content, and browse posts with category filtering.

---

## 🚀 Features

- 🔐 User Authentication (Register/Login/Logout)
- ✍️ Create, Edit, and Delete Blog Posts (CRUD)
- 🗂️ Category-Based Blog Filtering
- 🔎 Search Functionality
- 📱 Responsive Design (Mobile-Friendly)
- 🛠️ Admin Dashboard for Managing Posts & Users
- 💾 PostgreSQL Database Integration
- 🔒 Secure Session Handling & Server-Side Validation

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP |
| Database | PostgreSQL |
| Version Control | Git & GitHub |

---

## 📁 Project Structure

```
Blogging-Website/
│
├── admin/
├── config/
├── css/
├── js/
├── images/
├── database/
├── partials/
├── index.php
├── blog.php
├── about.php
└── README.md
```

---

## ⚙️ Installation & Setup

### 1️⃣ Clone Repository

```bash
git clone https://github.com/pratik2704-cmd/Blogging-Website.git
cd Blogging-Website
```

### 2️⃣ Setup PostgreSQL Database

Create a new database:

```sql
CREATE DATABASE blog_db;
```

Create required tables (Example Schema Below).

---

### 3️⃣ Configure Database Connection

Update your database configuration file inside `/config/`:

```php
<?php
$conn = pg_connect("host=localhost dbname=blog_db user=postgres password=yourpassword");
if(!$conn){
    echo "Database connection failed";
}
?>
```

---

### 4️⃣ Run the Project

- Place the project folder inside your server directory (XAMPP/WAMP/Laragon).
- Start Apache and PostgreSQL.
- Open in browser:

```
http://localhost/Blogging-Website
```

---

## 🗄️ Database Schema (Example)

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    author_id INT REFERENCES users(id) ON DELETE CASCADE,
    category_id INT REFERENCES categories(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 📸 Screenshots

### 🏠 Homepage
_Add homepage screenshot here_

### 🔐 Login Page
_Add login page screenshot here_

### 📝 Admin Dashboard
_Add dashboard screenshot here_

---

## 📈 Project Highlights

- Implemented Full CRUD operations using PHP  
- Designed relational database using PostgreSQL  
- Developed modular backend structure  
- Applied responsive UI principles  
- Secured authentication using sessions & validation  

---

## 🤝 Contributing

Contributions are welcome!

1. Fork the repository  
2. Create a new branch  
3. Commit your changes  
4. Push to your branch  
5. Open a Pull Request  

---

## 📜 License

This project is open-source and available under the MIT License.

---

⭐ If you like this project, consider giving it a star on GitHub!
