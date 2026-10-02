# 🏎️ Romanian Karting Blog & Learning Hub

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Livewire](https://img.shields.io/badge/Livewire-488038?style=for-the-badge&logo=livewire&logoColor=white)](https://laravel-livewire.com/)

A specialized content platform and blog dedicated to the Romanian karting scene. Designed to promote local motorsport, provide learning roadmaps for aspiring drivers, cover race events, and publish technical guides on kart setup, maintenance, and driving techniques.

---

## 📌 Project Context & Credits

This project was built and customized using the [Laravel Daily Roadmap Learning Path](https://laraveldaily.com/roadmap-learning-path) template as a foundational architecture, tailored specifically for structured motorsport content delivery, categories, and interactive learning guides.

---

## ✨ Key Features

- **Motorsport Articles & News:** Coverage of local Romanian karting competitions, team highlights, and track updates.
- **Structured Learning Paths:** Step-by-step guides for beginner to senior kart drivers covering racing lines, setup tuning, and equipment.
- **Category & Tag Filtering:** Easy navigation through technical guides, race reports, kart mechanics, and driver physical preparation.
- **Admin Management Panel:** Content management dashboard for creating, editing, and scheduling blog posts and learning modules.

---

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+, Laravel Framework
- **Frontend / UI:** Laravel Blade, Livewire, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Asset Bundling:** Vite

---

## 📂 Project Structure Overview

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Blog & Roadmap routing handlers
│   │   └── Livewire/        # Dynamic content components & filters
│   └── Models/              # Post, Category, Roadmap & Tag Models
├── database/
│   ├── migrations/          # Database schema setup
│   └── seeders/             # Initial blog categories & sample posts
└── resources/
    ├── views/               # Blade views & layout templates
    └── css / js/            # Tailwind styles & client-side scripts
