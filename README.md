# ☕ Sugar Cafe by Georgia - Cafe Management System

A complete web-based cafe management system for **Sugar Cafe by Georgia**, located at #38 Purok Sibsa1, Silang Cavite (Across Cavite State University).

## 🧋 About

Sugar Cafe by Georgia is your cozy corner in town. We serve handcrafted milk teas, refreshing fruit sodas, indulgent frappes, premium coffee, and delicious food — all made with love and fresh ingredients.

**Every sip has a STORY.**

## ✨ Features

### Customer Features
- **Menu Browsing** — Browse our full menu: Milk Tea, Fruit Soda, Frappe, Coffee, Food, Add-ons
- **Online Ordering** — Place orders for delivery or pickup
- **User Accounts** — Register, login, manage profile and addresses
- **Cart & Checkout** — Add to cart, apply coupons, checkout
- **Order Tracking** — Track your order status in real-time
- **Wishlist** — Save your favorite items for later
- **Reviews & Ratings** — Share your experience
- **Loyalty Points** — Earn and redeem points
- **Password Reset** — Secure password recovery via email

### Admin Features
- **Dashboard** — Sales analytics, revenue charts, order summaries
- **Product Management** — Add, edit, delete products and categories
- **Order Management** — Process orders, update statuses
- **User Management** — Manage customers and staff
- **Inventory Management** — Track stock levels
- **Promotions & Coupons** — Create and manage discounts
- **Reports** — Sales, inventory, and analytics reports
- **Settings** — Configure store settings

### Technical Features
- **Responsive Design** — Works on desktop, tablet, and mobile
- **PWA Support** — Installable as a Progressive Web App
- **JWT Authentication** — Secure API with JSON Web Tokens
- **CSRF Protection** — Built-in CSRF token validation
- **Input Validation** — Server-side and client-side validation
- **Database Schema** — 28 tables with proper relationships
- **MVC Architecture** — Clean separation of concerns

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8+ with PDO |
| **Database** | MySQL 5.7+ / MariaDB 10.2+ |
| **Frontend** | Bootstrap 5.3, Font Awesome 6 |
| **Fonts** | Playfair Display, Poppins, Great Vibes, Cormorant Garamond |
| **Charts** | Chart.js 4 |
| **Animations** | AOS (Animate on Scroll) |
| **Carousel** | Swiper.js 11 |
| **Auth** | JWT (JSON Web Tokens) |
| **PWA** | Service Worker, Web Manifest |

## 📁 Project Structure

```
sugar-cafe/
├── admin/                  # Admin panel
│   ├── controllers/        # Admin controllers
│   ├── models/             # Admin models
│   └── views/              # Admin views
├── api/                    # REST API
│   ├── config/             # Database & app config
│   ├── controllers/        # API controllers
│   ├── middleware/          # Auth, validation middleware
│   └── models/             # Data models
├── assets/                 # Static assets
│   ├── css/                # Stylesheets (sugar-cafe.css)
│   ├── js/                 # JavaScript files
│   └── images/             # Images & icons
├── database/               # Database files
│   └── sql/                # SQL schema (coffee_shop_database.sql)
├── includes/               # Shared components
│   ├── header.php          # Site header & navigation
│   └── footer.php          # Site footer
├── user/                   # User area
│   ├── controllers/        # User controllers
│   ├── models/             # User models
│   └── views/              # User views
├── index.php               # Homepage
├── menu.php                # Menu page
├── about.php               # About page
├── contact.php             # Contact page
├── cart.php                # Shopping cart
├── checkout.php            # Checkout page
├── login.php               # Login page
├── register.php            # Registration page
├── manifest.json           # PWA manifest
├── sw.js                   # Service Worker
└── .htaccess               # Apache config
```

## 🚀 Installation

### Prerequisites
- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.2+
- Apache with mod_rewrite enabled
- XAMPP/WAMP/LAMP stack

### Setup Steps

1. **Clone or copy** the project to your web server:
   ```bash
   # For XAMPP: C:/xampp/htdocs/sugar-cafe/
   # For Linux: /var/www/html/sugar-cafe/
   ```

2. **Create the database**:
   - Open phpMyAdmin or MySQL CLI
   - Import `database/sql/coffee_shop_database.sql`
   - This creates the `sugar_cafe_db` database with all 28 tables

3. **Configure database connection**:
   - Edit `api/config/database.php` if your MySQL credentials differ from:
     - Host: `localhost`
     - Username: `root`
     - Password: `` (empty)
     - Database: `sugar_cafe_db`

4. **Configure site settings**:
   - Edit `api/config/config.php` to update:
     - Site URL
     - Contact information
     - Social media links
     - Email settings

5. **Set file permissions** (Linux):
   ```bash
   chmod 755 -R sugar-cafe/
   chmod 777 -R sugar-cafe/assets/images/
   ```

6. **Access the site**:
   - Frontend: `http://localhost/sugar-cafe/`
   - Admin: `http://localhost/sugar-cafe/admin-login.php`

### Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@sugarcafe.com | superadmin123 |
| Admin | admin@sugarcafe.com | admin123 |
| Staff | staff@sugarcafe.com | staff123 |
| Customer | john@example.com | user123 |

## 🧋 Menu Categories

| Category | Items | Price |
|----------|-------|-------|
| **Milk Tea** | Classic, Wintermelon, Okaido, Taro, Matcha, Dark Chocolate, Strawberry | ₱90 |
| **Fruit Soda** | Strawberry, Blue Lemonade, Mango, Grape, Peach | ₱90 |
| **Frappe** | Cookies & Cream, Mocha, Caramel, Strawberry, Matcha, Dark Chocolate, Vanilla | ₱90 |
| **Coffee** | Espresso, Americano, Cappuccino, Café Latte, Caramel Macchiato | ₱75-₱105 |
| **Food** | Fries, Nachos, Chicken Wings, Garlic Bread | ₱65-₱120 |
| **Add-ons** | Pearls (Boba), Cheesecake Foam, Extra Shot | ₱20-₱25 |

## 🕐 Operating Hours

- **Monday - Saturday**: 11:00 AM - 10:00 PM
- **Sunday**: 1:00 PM - 7:00 PM

## 📍 Location

#38 Purok Sibsa1, Silang Cavite  
(Across Cavite State University)

## 🎨 Design

The site features a warm cream and brown color palette inspired by the cozy cafe aesthetic:

- **Primary Color**: `#6B4226` (Rich Brown)
- **Gold Accent**: `#C9A96E` (Warm Gold)
- **Cream Background**: `#FFF8F0` (Soft Cream)
- **Dark Background**: `#3E2723` (Espresso)
- **Typography**: Playfair Display (headings), Poppins (body), Great Vibes (script), Cormorant Garamond (accent)

## 📝 Database Schema

28 tables including:
- `users` — Customer, staff, and admin accounts
- `roles` — User role management
- `categories` — Product categories
- `products` — Menu items
- `orders` / `order_items` — Order management
- `payments` / `transactions` — Payment processing
- `addresses` — Customer addresses
- `reviews` — Product reviews
- `wishlist` / `favorites` — Saved items
- `coupons` / `promotions` — Discounts
- `loyalty_points` — Loyalty program
- `user_settings` — User preferences
- `notifications` — User notifications
- `settings` — Store configuration
- `inventory` / `suppliers` — Stock management
- `activity_logs` / `analytics` — Tracking & reporting

## 🔒 Security

- Password hashing with `password_hash()` / `password_verify()`
- JWT token authentication for API
- CSRF token protection on all forms
- SQL injection prevention via PDO prepared statements
- XSS prevention via `htmlspecialchars()`
- Input validation and sanitization

## 📄 License

This project is proprietary software for Sugar Cafe by Georgia.

---

**Sugar Cafe by Georgia** — *Every sip has a STORY* ☕🧋
