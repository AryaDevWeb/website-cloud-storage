# AryaDev Cloud Storage

> A secure, scalable, and modern cloud storage ecosystem featuring a powerful Laravel-based web interface and an integrated REST API.

![Project Stage](https://img.shields.io/badge/Stage-Complete_/_In_Development-success.svg)
![Framework](https://img.shields.io/badge/Framework-Laravel_12-red.svg)
![Frontend](https://img.shields.io/badge/Frontend-Tailwind_CSS_%7C_Vanilla_JS-blue.svg)

## 📖 Overview

**AryaDev Cloud Storage** is a comprehensive File Management SaaS (Software-as-a-Service) solution. Designed with a consistent, minimalist Tailwind CSS design language, it provides users with deep file manipulation functionalities, recursive folder management, permission controls, precise storage usage analytics (via pie/donut charts), and native PDF/text integrations. It also securely serves a complete REST API using Laravel Sanctum to connect to external client applications (e.g., Mobile Apps).

## ✨ Key Features

- **Advanced File Management:** Supports recursive directory trees, file renaming, moving, soft-deletion (Trash), Starring, and Sharing.
- **Categorized Views:** Fast and intuitive file accessibility through 'Recent', 'Starred', 'Shared', and 'Trash' quick-filters.
- **Storage Analytics:** Real-time quota calculations displaying "Used vs Free" space utilizing interactive `Chart.js` components.
- **Extensible API Access:** Built-in `/api/v1` namespace secured by **Laravel Sanctum**, enabling robust stateless communication for separate mobile/desktop clients.
- **AWS S3 Cloud Support:** Integrated `league/flysystem-aws-s3-v3` allows flexible driver configuration for scalable cloud deployments.
- **Native PDF Parsing:** Uses `smalot/pdfparser` and `spatie/pdf-to-text` for advanced document inspection features on the backend.

## 💻 Tech Stack

### Backend & Core
- **Platform:** PHP ^8.2
- **Framework:** Laravel 12.x
- **Database:** PostgreSQL
- **Authentication:** Session (Web) & Laravel Sanctum (API)
- **Cloud Interface:** AWS S3 (via Flysystem)

### Frontend (Web UI)
- **Styling:** Tailwind CSS 4.0 (compiled via Vite)
- **Interactivity:** Vanilla JavaScript (Module System: `fileManager.js`, `modalManager.js`, `uploadManager.js`, `previewManager.js`)
- **Charting:** Chart.js
- **Templating:** Laravel Blade (`dashboard`, `isi`, `akun`, `trash`)

## 🗂 Project Structure

```text
├── app/                  
│   ├── Http/Controllers/      # Web UI Logic Controllers
│   ├── Http/Controllers/Api/  # Unified API endpoints for external apps
│   └── Models/                # Eloquent schemas (User, File, Folder)
├── database/                  # Migrations for tables and schema management
├── routes/                    
│   ├── web.php                # Web Interface Routing
│   └── api.php                # App API Routing (prefix: /api/v1/)
└── resources/                 
    ├── css/app.css            # Tailwind directives and core Design Tokens
    ├── js/modules/            # Modular Vanilla JavaScript logics
    └── views/                 # Blade UI structural templates
```

## 🚀 Installation & Build Instructions

### Prerequisites
- **PHP** >= 8.2 & **Composer**
- **Node.js** & **NPM**
- **PostgreSQL** Server

### Setup Guide

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd website_cloud_storage
   ```
2. **Setup the Environment:**
   Run the unified setup script (defined in `composer.json`):
   ```bash
   composer setup
   ```
   *The `setup` script will automatically execute `composer install`, duplicate `.env.example` to `.env`, generate the APP_KEY, execute database migrations, and install/build NPM dependencies.*

3. **Configure Database & Storage (Optional):**
   Update your `.env` file with custom database credentials or AWS S3 keys if you aren't using the default local bindings.
   ```ini
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=cloud_storage_db
   DB_USERNAME=arya
   DB_PASSWORD=aryaserver
   # S3_ configurations ...
   ```

4. **Start the Development Server:**
   ```bash
   composer dev
   ```
   *This initializes the Laravel HTTP Server, Queue Listeners, Log Pail, and Vite HMR concurrently.*

## 📡 API Architecture (v1)

The application provides a structured API under the `/api/v1` namespace for separate mobile/desktop implementations to communicate with the core storage engine.

### Essential Endpoints:
- **Authentication:** `POST /api/v1/auth/login`, `POST /api/v1/auth/logout`, `GET /api/v1/auth/me`
- **Files:** `GET /files`, `POST /files` (Upload), `GET /files/recent`, `GET /files/trash`
- **File Actions:** `PATCH /files/{id}` (Rename/Move), `POST /files/{id}/star`, `GET /files/{id}/download`
- **Folders:** `GET /folders/tree` (Recursive folder maps), `POST /folders`

*(Note: Except for `/login` and `/register`, all API interactions require an `Authorization: Bearer <API-Token>` header)*

## 🤝 Contributing & Maintenance

Contributions targeting modular UI updates, vanilla JS test validations, or wider cloud-driver implementations are welcomed!

1. Create a Feature Branch (`git checkout -b feature/NewImplementation`)
2. Commit your Changes (`git commit -m 'Added custom share links'`)
3. Push to Branch (`git push origin feature/NewImplementation`)
4. Open a Pull Request

## 📄 License
This project is open-sourced under the MIT License.
