# Notification App

A Laravel-based notification and messaging system.

## 🚀 Features
- Message API (store & dispatch)
- Queue processing ( Database)
- Real-time updates using Pusher
- API-based architecture

---

## 🛠 Requirements

- PHP >= 8.0  
- Composer  
- MySQL / MariaDB  
- Laravel 10+  


---

## 📦 Installation & Setup

### 1. Clone the repository
```bash
git clone https://github.com/ode12797/notification-app.git
cd notification-app
composer install
php artisan migrate
php artisan queue:work

🔧 Environment Variables to Configure

| Key              | Description            |
| ---------------- | ---------------------- |
| APP_KEY          | Laravel app key        |
| DB_*             | Database configuration |
| PUSHER_*         | Pusher credentials     |
| QUEUE_CONNECTION | redis/database         |
 
