# 🚀 Panduan Deployment ke Hostinger

Panduan lengkap untuk deploy project Begawi-Id ke Hostinger.

## 📋 Prasyarat

1. **Akun Hostinger** dengan akses hosting dan database
2. **FTP/SSH access** ke server Hostinger
3. **PHP 8.2+** terinstall di server
4. **MySQL/MariaDB** database
5. **Composer** (sudah tersedia di Hostinger atau gunakan composer.phar)

## 📦 Persiapan Composer.phar

### Windows (Lokal):

```powershell
powershell -ExecutionPolicy Bypass -File download-composer.ps1
```

### Linux/Mac atau di Server Hostinger:

```bash
bash download-composer.sh
```

**Atau download manual:**

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=. --filename=composer.phar
php -r "unlink('composer-setup.php');"
```

Setelah download, file `composer.phar` akan tersedia di root project.

## 🔧 Langkah Deployment

### 1. Persiapkan File Project

**File yang perlu di-upload:**

-   Semua file di root directory (kecuali `node_modules`, `.git`, `.env`)
-   Folder `app/`, `bootstrap/`, `config/`, `database/`, `public/`, `resources/`, `routes/`
-   File `composer.json`, `composer.lock`, `composer.phar`, `artisan`, `package.json`

**File yang TIDAK perlu di-upload:**

-   `vendor/` (akan diinstall di server)
-   `node_modules/` (akan diinstall di server jika diperlukan)
-   `.env` (buat baru di server)
-   `.git/`
-   `storage/logs/` (buat folder kosong)
-   File cache lainnya

### 2. Upload ke Hostinger

**Via FTP/SFTP:**

1. Gunakan FileZilla atau WinSCP
2. Connect ke server Hostinger
3. Upload semua file ke folder `public_html/` atau sesuai konfigurasi

**Via Git (jika tersedia):**

```bash
git clone https://your-repo-url.git
cd begawi-id
```

### 3. Setup Environment (.env)

Buat file `.env` di server dengan konfigurasi:

```env
APP_NAME=Begawi-Id
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Generate APP_KEY:**

```bash
php artisan key:generate
```

### 4. Install Dependencies

**Install Composer Dependencies:**

```bash
php composer.phar install --no-dev --optimize-autoloader
```

Jika composer sudah terinstall global:

```bash
composer install --no-dev --optimize-autoloader
```

**Install NPM Dependencies (jika perlu):**

```bash
npm install
npm run build
```

### 5. Setup Database

**Buat database di cPanel Hostinger:**

1. Login ke cPanel
2. Buat MySQL Database baru
3. Buat MySQL User baru
4. Berikan privileges ke user untuk database
5. Catat credentials untuk file `.env`

**Jalankan Migration:**

```bash
php artisan migrate --force
```

**Jalankan Seeder (optional):**

```bash
php artisan db:seed
```

### 6. Setup Storage & Permissions

**Buat symbolic link storage:**

```bash
php artisan storage:link
```

**Set permissions (Linux):**

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/storage
```

### 7. Optimize Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 8. Konfigurasi Web Server

**Untuk Hostinger, biasanya sudah otomatis. Jika perlu manual setup:**

**Apache (.htaccess di public/):**

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**Nginx:**

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Set Document Root:**

-   Pastikan Document Root mengarah ke folder `public/`
-   Bukan ke root project

### 9. SSL Certificate (HTTPS)

Hostinger biasanya menyediakan SSL gratis. Aktifkan melalui cPanel.

## 🔍 Troubleshooting

### Error: Class not found

```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

### Error: 500 Internal Server Error

1. Check file `.env` sudah benar
2. Check permissions folder `storage/` dan `bootstrap/cache/`
3. Check error log di `storage/logs/laravel.log`
4. Pastikan `APP_DEBUG=false` di production

### Error: Storage link tidak bekerja

```bash
php artisan storage:link
# Atau manual:
ln -s ../storage/app/public public/storage
```

### Error: Database connection

1. Pastikan credentials di `.env` benar
2. Pastikan database user memiliki privileges
3. Check apakah MySQL extension aktif di PHP

### Error: Composer memory limit

```bash
php -d memory_limit=-1 composer.phar install
```

## 📝 Checklist Deployment

-   [ ] Upload semua file ke server
-   [ ] Buat file `.env` dengan konfigurasi production
-   [ ] Generate `APP_KEY`
-   [ ] Install dependencies (`composer.phar install`)
-   [ ] Setup database dan jalankan migration
-   [ ] Buat symbolic link storage
-   [ ] Set permissions folder
-   [ ] Clear dan cache config, route, view
-   [ ] Test aplikasi di browser
-   [ ] Setup SSL certificate
-   [ ] Setup cron jobs (jika diperlukan)
-   [ ] Backup database

## 🔄 Update/Deploy Ulang

```bash
# Pull latest changes (jika menggunakan Git)
git pull origin main

# Install/update dependencies
php composer.phar install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Re-optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📞 Support

Jika mengalami masalah, cek:

1. Error log: `storage/logs/laravel.log`
2. Hostinger support center
3. Laravel documentation: https://laravel.com/docs

---

**Selamat Deploy! 🎉**
