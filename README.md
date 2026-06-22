# DKM Al Hikmah Web Portal

A Laravel-based web portal for **DKM AL HIKMAH**, designed to support mosque information management, public activity documentation, financial transparency, and admin-controlled content using Google Sheets as a lightweight CMS.

This project was developed as a university project for **Capstone** and **KKN** subjects, with the goal of creating a practical digital solution that can be used by DKM AL HIKMAH to manage public information, internal data, and community-based financial records more efficiently.

## Overview

This project provides two main areas:

1. **Public Website**
   A public-facing information portal for visitors, employees, jamaah, and the surrounding community.

2. **Admin Portal**
   A private dashboard for managing website content, users, activities, categories, and finance-related transactions connected to Google Sheets.

The system uses Google Sheets as a lightweight database/CMS to make content and finance data easier to maintain by non-technical administrators.

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
* Public kas transparency page
* Kas usage history
* Evidence link for approved kas usage
* Musala Plant & Kantor information
* Infaq page
* Dynamic kegiatan dropdown from Google Sheets
* Custom favicon / web tab icon

### Admin Portal

* Google Sheet-based authentication
* Admin dashboard
* Role-based sidebar menu
* Role-based dashboard view
* User management CRUD
* Kategori kegiatan CRUD
* Kegiatan CRUD
* Keuangan / tabungan module
* Image upload for kegiatan
* Auto WebP image conversion using PHP GD
* Custom delete confirmation modal
* Custom approval and rejection modal
* Approval evidence upload for finance transactions
* Responsive sidebar and topbar layout
* Role support:

  * superadmin
  * admin
  * karyawan

### Keuangan Module

The finance module manages internal savings and DKM cash records.

Supported savings/funds:

* Qurban savings
* Umrah savings
* DKM kas

Supported transaction types:

* Deposit / setor tabungan
* Withdraw / ambil tabungan
* Kas expense / penggunaan kas

Transaction workflow:

1. User submits a deposit or withdrawal request.
2. Transaction is stored as pending.
3. Admin or superadmin reviews the request.
4. Admin approves or rejects the transaction.
5. Approved transactions update the related balance.
6. Approved transactions can include uploaded evidence or receipt.
7. Public page only displays approved kas usage history.

### Role-Based Access

| Role       | Access                                                                                 |
| ---------- | -------------------------------------------------------------------------------------- |
| superadmin | Full access to all admin features                                                      |
| admin      | Manage users, content, activities, categories, and finance approval                    |
| karyawan   | Access keuangan module, submit own deposit/withdraw requests, view own finance history |

Karyawan can only submit transactions for their own account, while admin and superadmin can manage and approve transactions for all users.

## Google Sheets Structure

The project uses Google Sheets as the main content and transaction storage.

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

### `users_tabungan`

| Column         | Description                |
| -------------- | -------------------------- |
| id_tabungan    | Auto-increment tabungan ID |
| id_user        | Related user ID            |
| name           | User name                  |
| qurban_balance | Current qurban balance     |
| umrah_balance  | Current umrah balance      |
| updated_at     | Last balance update time   |

### `kas_tabungan`

| Column     | Description             |
| ---------- | ----------------------- |
| id_kas     | Kas row ID              |
| balance    | Current DKM kas balance |
| updated_at | Last kas update time    |

### `trx_tabungan`

| Column            | Description                          |
| ----------------- | ------------------------------------ |
| id_transaction    | Auto-increment transaction ID        |
| transaction_code  | Unique transaction code              |
| requested_by_id   | User ID who submitted the request    |
| requested_by_name | User name who submitted the request  |
| target_user_id    | Target user ID for the transaction   |
| target_user_name  | Target user name for the transaction |
| fund_type         | qurban, umrah, or kas                |
| action_type       | deposit, withdraw, or expense        |
| amount            | Transaction amount                   |
| status            | pending, approved, or rejected       |
| note              | User/admin transaction note          |
| admin_note        | Approval/rejection note from admin   |
| approved_by_id    | Admin ID who approved/rejected       |
| approved_by_name  | Admin name who approved/rejected     |
| requested_at      | Request timestamp                    |
| approved_at       | Approval/rejection timestamp         |
| approval_evidence | Uploaded receipt/evidence path       |

## Tech Stack

* Laravel 11
* Laravel Breeze
* Bootstrap 5
* Bootstrap Icons
* Google Sheets API
* PHP GD for image processing
* SQLite for local Laravel session/auth support
* Custom admin layout
* Custom public website layout

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

## Image and Evidence Uploads

### Kegiatan Images

Kegiatan images are stored inside:

```txt
public/image/kegiatan/{slug}/{slug}.webp
```

Uploaded images are resized and converted to WebP using PHP GD.

Example:

```txt
public/image/kegiatan/kajian-rutin-ahad-pagi/kajian-rutin-ahad-pagi.webp
```

### Finance Approval Evidence

Finance approval evidence is stored inside:

```txt
public/image/keuangan/evidence/{transaction_code}/approval-evidence.{extension}
```

Example:

```txt
public/image/keuangan/evidence/TRX-20260622-0001/approval-evidence.jpg
```

Supported evidence formats:

* JPG
* JPEG
* PNG
* WebP
* PDF

## Admin Roles

| Role       | Description                                              |
| ---------- | -------------------------------------------------------- |
| superadmin | Full access to all admin features                        |
| admin      | Standard admin access for content and finance management |
| karyawan   | Limited access for personal finance requests and history |

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

Check PHP GD and WebP support:

```bash
php -r "var_dump(extension_loaded('gd'), function_exists('imagewebp'));"
```

## Project Status

Completed modules:

* Public website layout
* Public profile pages
* Public kegiatan pages
* Dynamic kegiatan categories
* Public kas transparency page
* Google Sheet login
* Admin dashboard layout
* Role-based dashboard view
* Role-based sidebar menu
* Kategori CRUD
* Kegiatan CRUD
* Users CRUD
* Keuangan / tabungan module
* Deposit request flow
* Withdraw request flow
* Kas expense recording
* Finance approval/rejection flow
* Finance evidence upload
* Custom admin UI components
* Favicon setup

Possible future improvements:

* Advanced role middleware
* Export finance report to PDF
* Monthly finance report filter
* More detailed public finance charts
* Musala content management
* Infaq content management
* Notification system for approved/rejected requests

## Academic Context

This project was created as part of a university assignment for **Capstone** and **KKN** subjects. It aims to combine technical implementation, community service, and real-world problem solving by providing DKM AL HIKMAH with a digital platform for information management and financial transparency.

## License

This project is developed for DKM AL HIKMAH internal and public information management as part of a university Capstone and KKN project.