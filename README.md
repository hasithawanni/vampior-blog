# 🌌 Vampior Blog - Multi-User Editorial Platform

A high-end, full-stack blogging application built for the **Vampior Designs** internship assessment. This platform features a custom **Glassmorphism UI**, robust Role-Based Access Control (RBAC), and integrated social authentication.

## 🛠️ Technical Implementation

### Core Architecture

* **Authentication**: Built with Laravel Breeze and expanded with **Laravel Socialite** for Google and GitHub SSO.
* **Governance (RBAC)**: Implemented using **Spatie Laravel-Permission** to define Admin, Editor, and Reader roles.
* **Content Engine**: Integrated the **Trix Editor** for rich-text support and optimized image handling with **Object-Center** subject tracking.
* **Performance**: Implemented server-side caching for the global dashboard feed.
* **Security**: Implemented stateless OAuth 2.0 flows for Socialite to ensure robust cross-platform authentication.

### Bespoke Design Identity

* **Glassmorphism UI**: A unified dark-mode aesthetic featuring frosted containers (`backdrop-blur-2xl`), neon-blue interactive elements, and deep radial gradients.
* **Responsive Flow**: Fully adaptive navigation and layout systems for mobile and desktop editorial experiences.
* **Identity Vault**: A pipeline-style user profile and security center tailored for the Vampior brand.

---

## 🚀 Setup & Installation

Follow these steps to initialize the environment:

1. **Clone & Dependencies**:
```bash
composer install
npm install && npm run build

```


2. **Environment**:
* Rename `.env.example` to `.env` and configure your database.
* Add your `GOOGLE_CLIENT_ID` and `GITHUB_CLIENT_ID` for Socialite.


3. **Database & Governance**:
```bash
php artisan migrate --seed

```


*Note: The seeder creates default categories and the necessary RBAC roles.*
4. **Media Assets**:
```bash
php artisan storage:link

```


5. **Launch**:
```bash
php artisan serve

```


🔑 Test Credentials
To explore the different role perspectives without manual registration:

Admin User: admin@vampior.com / password123
Editor User: editor@vampior.com / password123


---

## 📂 Feature Breakdown

| Feature | Description |
| --- | --- |
| **Global Feed** | Immersive glass cards with cached high-performance delivery. |
| **My Library** | A personalized "Save for Later" system for authenticated users. |
| **Admin Core** | A dedicated moderation panel for managing user roles and approving content. |
| **Rich Editing** | Full CRUD functionality with media uploads and rich-text formatting. |

