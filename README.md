# Laravel + React Starter Kit

A modern, production-ready starter kit with role-based authentication, Google OAuth, and a beautiful UI powered by Laravel 13, React 18, TypeScript, and Tailwind CSS.

![Welcome Page](.github/screenshots/Welcome%20-%20App%20Name.jpeg)

## ✨ Features

### 🔐 Authentication & Authorization
- **Email/Password Authentication** - Traditional login with Laravel Fortify
- **Google OAuth** - One-click sign-in with Google
- **Role-Based Access Control** - Dynamic layouts and permissions (Admin & User roles)
- **Two-Factor Authentication** - Enhanced security with 2FA
- **Email Verification** - Verify user email addresses
- **Password Reset** - Secure password recovery flow
- **Rate Limiting** - Protection against brute force attacks

### 👥 User Management
- **Profile Management** - Edit name, email, and personal information
- **Profile Photo Upload** - Secure photo storage with private access
- **Account Security** - Password changes and 2FA management
- **Session Management** - View and revoke active sessions

### 🎨 UI/UX
- **Modern Design** - Clean, professional interface with shadcn/ui
- **Dark Mode** - System-aware theme switching
- **Responsive Layout** - Mobile-first design
- **Dynamic Sidebar** - Collapsible navigation with role-based menus
- **Breadcrumbs** - Clear page navigation
- **Toast Notifications** - User-friendly feedback

### 🏗️ Architecture
- **TypeScript** - Type-safe React components
- **Inertia.js** - Modern monolith architecture
- **Server-Side Rendering** - Fast initial page loads
- **Vite** - Lightning-fast builds and HMR
- **Tailwind CSS** - Utility-first styling

---

## 📸 Screenshots

### Authentication

<details>
<summary>Login Page</summary>

![Login Page](.github/screenshots/Log%20in%20-%20App%20Name.jpeg)

**Features:**
- Email/password login
- Google OAuth integration
- Remember me option
- Password reset link
- Registration link
</details>

<details>
<summary>Register Page</summary>

![Register Page](.github/screenshots/Register%20-%20App%20Name.jpeg)

**Features:**
- First name and last name fields
- Email validation
- Password strength requirements
- Terms acceptance
- Direct link to login
</details>

### Admin Dashboard

<details>
<summary>Dashboard (Admin)</summary>

![Dashboard](.github/screenshots/Dashboard%20-%20App%20Name.jpeg)

**Admin Navigation:**
- Dashboard
- Manage Users
- Violations
- Folders
- Roles & Permissions
- Audit Trails
- Settings
</details>

### User Management

<details>
<summary>Profile Settings</summary>

![Profile Settings](.github/screenshots/Profile%20settings%20-%20App%20Name.jpeg)

**Features:**
- Update personal information
- Upload profile photo
- Change email address
- View account details
</details>

---

## 🚀 Quick Start

### Prerequisites

Make sure you have the following installed:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **npm** or **yarn** or **pnpm**
- **MySQL** >= 8.0 or **PostgreSQL** >= 13
- **Git**

### Installation

1. **Clone the repository**

```bash
git clone https://github.com/Jrcoo13/Laravel-Web-Starter-Kit.git
cd speed-detection
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install Node dependencies**

```bash
npm install
# or
yarn install
# or
pnpm install
```

4. **Set up environment**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Configure Google OAuth (Optional)**

Get credentials from [Google Cloud Console](https://console.cloud.google.com):

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

7. **Run migrations and seed roles**

```bash
php artisan migrate
php artisan db:seed --class=RoleSeeder
```

8. **Build frontend assets**

```bash
npm run build
# or for development with hot reload
npm run dev
```

9. **Start the development server**

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 🛠️ Development

### Running Development Server

```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: Vite (with HMR)
npm run dev
```

### Building for Production

```bash
# Build optimized assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Testing

```bash
# Run PHP tests
php artisan test

# Run type checking
npm run type-check

# Run linting
npm run lint
```

---

## 📁 Project Structure

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── OAuthController.php       # Google OAuth
│   │   │   ├── Settings/
│   │   │   │   └── ProfileController.php     # Profile management
│   │   │   └── ProfilePhotoController.php    # Secure photo serving
│   │   ├── Middleware/
│   │   │   ├── AdminOnly.php                 # Admin-only access
│   │   │   ├── RedirectBasedOnRole.php       # Role-based redirects
│   │   │   └── RateLimitWeb.php              # Rate limiting
│   │   └── Responses/
│   │       └── LoginResponse.php             # Custom login redirect
│   ├── Models/
│   │   ├── User.php                          # User model with roles
│   │   └── Role.php                          # Role model
│   └── Providers/
│       └── FortifyServiceProvider.php        # Fortify configuration
├── resources/
│   └── js/
│       ├── components/
│       │   ├── admin-sidebar.tsx             # Admin navigation
│       │   ├── user-sidebar.tsx              # User navigation
│       │   ├── app-sidebar.tsx               # Dynamic sidebar
│       │   └── ui/                           # UI components (shadcn)
│       ├── hooks/
│       │   ├── use-auth.ts                   # Auth utilities
│       │   └── use-role.ts                   # Role checking
│       ├── pages/
│       │   ├── auth/                         # Authentication pages
│       │   ├── admin/                        # Admin pages
│       │   ├── settings/                     # User settings
│       │   ├── dashboard.tsx                 # Admin dashboard
│       │   └── home.tsx                      # User home
│       └── types/                            # TypeScript definitions
├── routes/
│   └── web.php                               # Application routes
└── database/
    ├── migrations/                           # Database migrations
    └── seeders/
        └── RoleSeeder.php                    # Default roles
```

---

## 🔑 Default Roles

The system includes two default roles:

### Admin Role
- **Access:** Full system access
- **Dashboard:** `/dashboard`
- **Features:**
  - User management
  - Violations tracking
  - Folder management
  - Role & permission management
  - Audit trails
  - System settings

### User Role
- **Access:** Limited to personal features
- **Dashboard:** `/home`
- **Features:**
  - Profile management
  - Account settings
  - Personal data only

### Creating an Admin User

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'admin@example.com')->first();
$user->role_id = 1; // Admin role
$user->save();
```

---

## 🔐 Security Features

### Rate Limiting

```php
// Web routes: 100 requests/minute per IP
// Auth routes: 10 requests/minute per IP
// Profile routes: 20 requests/minute per IP
```

### Profile Photo Security

- Stored in private `storage/app/profile-photos` directory
- Accessed only through authenticated routes
- Policy-based ownership verification
- File type and size validation

### Session Security

- Database-backed sessions
- 120-minute session lifetime
- Secure cookie handling
- CSRF protection

### OAuth Security

- State parameter prevents CSRF
- Secure token exchange
- Auto email verification
- Random password generation for OAuth-only accounts

---

## 🎨 Customization

### Changing App Name

1. Update `.env`:
```env
APP_NAME="Your App Name"
```

2. Update `resources/js/app.tsx`:
```typescript
// Page title helper
```

### Adding Admin Menu Items

Edit `resources/js/components/admin-sidebar.tsx`:

```typescript
const adminMainNavItems: NavGroup[] = [
    {
        title: 'Main Menu',
        items: [
            // Add your menu item
            {
                title: 'New Feature',
                href: '/admin/new-feature',
                icon: YourIcon,
            },
        ],
    },
];
```

### Creating Admin Pages

1. Create page component:
```bash
# Create new admin page
touch resources/js/pages/admin/your-page.tsx
```

2. Add route:
```php
// routes/web.php
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::inertia('your-page', 'admin/your-page')->name('your-page');
    });
```

### Styling

The project uses Tailwind CSS with shadcn/ui components. Customize:

- **Colors:** `tailwind.config.js`
- **Components:** `resources/js/components/ui/`
- **Layouts:** `resources/js/layouts/`

---

## 📚 Documentation

### Additional Documentation

- [Role-Based Layouts](ROLE_BASED_LAYOUTS.md) - Complete role system documentation
- [Google OAuth Setup](GOOGLE_OAUTH_TESTING.md) - OAuth configuration guide
- [Admin Pages Setup](ADMIN_PAGES_SETUP.md) - Admin feature implementation
- [Security Guidelines](SECURITY.md) - Security best practices

### Testing Your Setup

Run the verification script:

```bash
php test-role-based-system.php
```

Expected output: All checks should pass with ✓

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🙏 Acknowledgments

Built with these amazing technologies:

- [Laravel](https://laravel.com) - PHP Framework
- [React](https://react.dev) - UI Library
- [Inertia.js](https://inertiajs.com) - Modern Monolith
- [TypeScript](https://www.typescriptlang.org) - Type Safety
- [Tailwind CSS](https://tailwindcss.com) - Styling
- [shadcn/ui](https://ui.shadcn.com) - UI Components
- [Vite](https://vitejs.dev) - Build Tool
- [Laravel Fortify](https://laravel.com/docs/fortify) - Authentication
- [Laravel Socialite](https://laravel.com/docs/socialite) - OAuth

---

## 📧 Support

If you have any questions or need help, please:

- Open an issue on GitHub
- Check the [documentation](ROLE_BASED_LAYOUTS.md)
- Run the test script: `php test-role-based-system.php`

---

## 🚀 What's Next?

Ready to build? Here are some ideas:

1. **Implement Admin Features**
   - User management CRUD
   - Violations tracking system
   - File/folder management
   - Role & permission editor

2. **Enhance User Experience**
   - Real-time notifications
   - Activity feed
   - User dashboard widgets
   - Search functionality

3. **Add Integrations**
   - Email service (SendGrid, Mailgun)
   - Cloud storage (AWS S3, DigitalOcean Spaces)
   - Analytics (Google Analytics, Plausible)
   - Monitoring (Sentry, Bugsnag)

4. **Deploy to Production**
   - Set up CI/CD pipeline
   - Configure production environment
   - Set up database backups
   - Enable SSL/HTTPS

---

Made with ❤️ using Laravel and React
