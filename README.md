# DKM Al Hikmah Web Portal

A Laravel-based web portal for **DKM AL HIKMAH**, designed to manage mosque information, public activities, financial transparency, and admin-controlled content using Google Sheets as a lightweight CMS.

## Overview

This project provides two main areas:

1. **Public Website**
   A landing page and information portal for visitors, employees, and jamaah.

2. **Admin Portal**
   A private dashboard for managing categories, activities, users, and website content connected to Google Sheets.

## Features

### Public Website

* Homepage / landing page
* Profil DKM
* Sejarah
* Visi dan Misi
* Struktur Organisasi
* Kepengurusan
* Kegiatan by category
* Detail kegiatan
* Laporan keuangan transparency pages
* Musala Plant & Kantor information
* Infaq page
* Dynamic kegiatan dropdown from Google Sheets

### Admin Portal

* Google Sheet-based authentication
* Admin dashboard
* User management CRUD
* Kategori kegiatan CRUD
* Kegiatan CRUD
* Image upload for kegiatan
* Auto WebP image conversion using PHP GD
* Custom delete confirmation modal
* Responsive sidebar and topbar layout
* Role support:

  * superadmin
  * admin
  * karyawan

## Google Sheets Structure

The project uses Google Sheets as the main content storage for several modules.

### `users`

| Column   | Description                    |
| -------- | ------------------------------ |
| id_user  | Auto-increment user ID         |
| name     | User full name                 |
| email    | Login email                    |
| password | Bcrypt hashed password         |
| role     | superadmin, admin, or karyawan |
| status   | active or inactive             |

### `kategori`

| Column | Description          |
| ------ | -------------------- |
| name   | Category name        |
| slug   | Category URL slug    |
| icon   | Icon class           |
| desc   | Category description |

### `kegiatan`

| Column        | Description                |
| ------------- | -------------------------- |
| id_kegiatan   | Auto-increment kegiatan ID |
| title         | Kegiatan title             |
| slug          | Kegiatan URL slug          |
| category_slug | Related category slug      |
| date          | Kegiatan date              |
| image         | Image filename             |
| excerpt       | Short summary              |
| content       | Full content               |
| quote         | Optional quote             |

## Tech Stack

* Laravel 11
* Laravel Breeze
* Bootstrap 5
* Bootstrap Icons
* Google Sheets API
* PHP GD for image processing
* SQLite for local Laravel session/auth support
* Custom admin layout

## Requirements

* PHP 8.2+
* Composer
* Node.js & NPM
* Google Cloud service account
* Google Sheets API enabled
* PHP GD extension enabled

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd web-dkm
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Copy environment file:

```bash
cp .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Run migrations:

```bash
php artisan migrate
```

Build frontend assets:

```bash
npm run dev
```

Start the development server:

```bash
php artisan serve
```

## Environment Variables

Add the Google Sheets configuration to `.env`:

```env
GOOGLE_SERVICE_ENABLED=true
GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION="/path/to/storage/app/google-service-account.json"
POSTS_SPREADSHEET_ID="your_google_spreadsheet_id"
```

The spreadsheet ID is taken from the Google Sheet URL:

```txt
https://docs.google.com/spreadsheets/d/SPREADSHEET_ID_HERE/edit
```

## Google Service Account Setup

1. Create a Google Cloud project.
2. Enable Google Sheets API.
3. Create a service account.
4. Download the service account JSON file.
5. Place the JSON file inside Laravel storage, for example:

```txt
storage/app/google-service-account.json
```

6. Share the Google Sheet with the service account email as **Editor**.

The service account email can be found inside the JSON file under:

```json
"client_email"
```

## Image Uploads

Kegiatan images are stored inside:

```txt
public/image/kegiatan/{slug}/{slug}.webp
```

Uploaded images are resized and converted to WebP using PHP GD.

Example:

```txt
public/image/kegiatan/kajian-rutin-ahad-pagi/kajian-rutin-ahad-pagi.webp
```

## Admin Roles

| Role       | Description                       |
| ---------- | --------------------------------- |
| superadmin | Full access to all admin features |
| admin      | Standard admin access             |
| karyawan   | Limited internal user access      |

## Useful Commands

Clear Laravel cache:

```bash
php artisan optimize:clear
```

Clear application cache:

```bash
php artisan cache:clear
```

Run development server:

```bash
php artisan serve
```

Run frontend watcher:

```bash
npm run dev
```

## Project Status

Current completed modules:

* Public website layout
* Dynamic kegiatan categories
* Google Sheet login
* Admin dashboard layout
* Kategori CRUD
* Kegiatan CRUD
* Users CRUD
* Custom admin UI components

Upcoming modules:

* Laporan Keuangan CRUD
* Musala content management
* Infaq content management
* Role-based admin access control

## License

This project is developed for DKM AL HIKMAH internal and public information management.
