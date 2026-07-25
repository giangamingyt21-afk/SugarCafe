# Sugar Cafe by Georgia - Project Structure

## Directory Layout

```
sugar-cafe/
├── config/                          # Core configuration
│   ├── config.php                   # Main config (session, DB, helpers, constants)
│   ├── database.php                 # Database singleton class
│   └── routes.php                   # API router (dispatches to controllers)
│
├── api/                             # API layer
│   ├── controllers/                 # API controllers
│   ├── endpoints/                   # API endpoint handlers
│   ├── middleware/                   # API middleware
│   └── models/                      # API models
│
├── user/                            # USER-SIDE APPLICATION
│   ├── views/                       # User-facing pages (homepage, menu, cart, etc.)
│   ├── includes/                    # Shared components (header, footer, sidebar, modals)
│   ├── assets/                      # Static assets (CSS, JS, images, uploads)
│   ├── controllers/                 # User-side controllers
│   ├── models/                      # User-side models
│   └── manifest.json                # PWA manifest
│
├── admin/                           # ADMIN-SIDE APPLICATION
│   ├── views/                       # Admin pages (dashboard, products, orders, etc.)
│   ├── includes/                    # Shared components (head, sidebar, header, footer)
│   ├── assets/                      # Static assets (admin.css, admin.js, charts.js)
│   ├── controllers/                 # Admin controllers
│   └── models/                      # Admin models
│
├── database/                        # Database schemas (sugar_cafe_db.sql)
├── assets/                          # Root-level shared assets (uploads)
├── .htaccess                        # Apache config (URL rewriting, security)
├── index.php                        # Root redirect to user/views/index.php
├── login.php                        # Unified login (redirects admin/user appropriately)
├── logout.php                       # Root redirect to user/views/logout.php
├── manifest.json                    # PWA manifest (root copy)
├── robots.txt, sw.js, sitemap.php   # SEO & PWA files
└── [backward-compatible redirects]  # Root PHP stubs redirecting to user/views/
```

## Root-Level Redirect Stubs

The following root-level PHP files exist only as backward-compatible redirects to their new locations in user/views/:

- about.php, cart.php, checkout.php, contact.php, faq.php, forgot-password.php, gallery.php, menu.php, order-history.php, order-success.php, order-tracking.php, privacy-policy.php, promotions.php, register.php, reset-password.php, rewards.php, terms.php, user-dashboard.php, user-profile.php, verify-email.php, wishlist.php, admin-login.php, 404.php, 500.php

## Bug Fixes Applied

### 1. Add to Cart - Access Denied Fix
- File: api/endpoints/add-to-cart.php
- Issue: CSRF token verification was blocking regular users from adding items to cart
- Fix: Removed CSRF verification from add-to-cart endpoint

### 2. Logout Fatal Error Fix
- Files: logout.php, user/views/logout.php
- Issue: Fatal error "Undefined constant 'BASE_URL'" because config.php was not included
- Fix: Added require_once for config.php before using BASE_URL

### 3. Professional Admin Design Overhaul
- File: admin/assets/css/admin.css (977 lines)
- Features: CSS custom properties, professional sidebar, topbar, stat cards, responsive design, print styles

### 4. Admin Layout System
- Files: admin/includes/head.php, sidebar.php, header.php, footer.php
- All 17 admin views now use include-based layout instead of duplicated inline HTML
