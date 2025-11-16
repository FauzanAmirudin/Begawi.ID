# 🔧 Troubleshooting Guide

## Masalah: Gambar Tidak Tampil Setelah Upload

### Gejala

-   Gambar berhasil di-upload melalui admin panel
-   File tersimpan di `storage/app/public/`
-   Tapi gambar tidak muncul di website (menampilkan broken image atau 404)

### Penyebab

Masalah ini terjadi karena **symbolic link** dari `public/storage` ke `storage/app/public` belum dibuat atau rusak.

Laravel menyimpan file upload di `storage/app/public/`, tetapi untuk mengaksesnya via browser, diperlukan symlink `public/storage` yang menunjuk ke `storage/app/public/`.

### Solusi

#### 1. Buat Symbolic Link (Wajib dilakukan di setiap komputer baru)

Jalankan command berikut di terminal/command prompt:

```bash
php artisan storage:link
```

Command ini akan membuat symlink `public/storage` → `storage/app/public`.

#### 2. Verifikasi Symlink Berhasil

Setelah menjalankan command, pastikan:

**Windows:**

-   Folder `public/storage` harus ada dan merupakan shortcut/symlink
-   Klik kanan → Properties, harus menunjukkan target ke `storage/app/public`

**Linux/Mac:**

```bash
ls -la public/storage
# Harus menampilkan: public/storage -> ../storage/app/public
```

#### 3. Error: "Symbolic Link Already Exists"

Jika muncul error **"The [public/storage] link already exists"**, berarti symlink sudah ada tapi mungkin rusak atau bukan symlink yang benar.

**Solusi:**

**Opsi A: Hapus dan Buat Ulang (Recommended)**

**Windows (Command Prompt):**

```bash
# Hapus symlink yang ada
rmdir public\storage

# Atau jika tidak bisa, gunakan:
del public\storage

# Lalu buat ulang
php artisan storage:link
```

**Windows (PowerShell - Lebih Aman):**

```powershell
# Hapus symlink
Remove-Item public\storage -Force

# Buat ulang
php artisan storage:link
```

**Linux/Mac:**

```bash
# Hapus symlink yang ada
rm public/storage

# Lalu buat ulang
php artisan storage:link
```

**Opsi B: Force Replace (Laravel 8+)**

Jika menggunakan Laravel 8 atau lebih baru, gunakan flag `--force`:

```bash
php artisan storage:link --force
```

**Opsi C: Hapus Manual dan Buat Ulang**

1. **Hapus folder/symlink `public/storage`** (bisa lewat File Explorer atau command)
2. **Pastikan folder sudah benar-benar terhapus**
3. **Jalankan lagi:**
    ```bash
    php artisan storage:link
    ```

**Opsi D: Cek Apakah Benar-benar Symlink**

**Windows:**

```bash
# Cek apakah public/storage adalah symlink
dir public\storage

# Jika menampilkan <SYMLINK> atau <SYMLINKD>, berarti sudah benar
# Jika menampilkan <DIR>, berarti itu folder biasa, harus dihapus dulu
```

**Linux/Mac:**

```bash
# Cek apakah symlink
ls -la public/storage

# Harus menampilkan: public/storage -> ../storage/app/public
# Jika tidak, hapus dan buat ulang
```

#### 4. Jika Symlink Gagal (Windows)

Di Windows, symlink mungkin memerlukan permission administrator. Coba:

**Opsi A: Jalankan sebagai Administrator**

1. Buka Command Prompt atau PowerShell sebagai Administrator
2. Hapus symlink yang ada: `rmdir public\storage` atau `Remove-Item public\storage -Force`
3. Jalankan: `php artisan storage:link`

**Opsi B: Buat Symlink Manual (Windows)**

```bash
# Hapus yang lama dulu
rmdir public\storage

# Buat symlink manual
mklink /D public\storage storage\app\public
```

**Opsi C: Gunakan Junction (Alternatif untuk Windows)**

```bash
# Hapus yang lama dulu
rmdir public\storage

# Buat junction
mklink /J public\storage storage\app\public
```

#### 5. Penyebab Lain yang Mungkin

**A. APP_URL di .env Salah**

`Storage::url()` menggunakan `APP_URL` dari `.env` untuk generate URL. Jika salah, gambar tidak akan tampil.

**Cek dan Perbaiki:**

1. Buka file `.env`
2. Pastikan `APP_URL` sesuai dengan URL yang Anda gunakan:

```env
# Jika menggunakan php artisan serve
APP_URL=http://localhost:8000

# Jika menggunakan Laragon/XAMPP dengan virtual host
APP_URL=http://begawi-id.test

# Jika menggunakan IP address
APP_URL=http://192.168.1.100:8000
```

3. **Clear config cache:**

```bash
php artisan config:clear
php artisan cache:clear
```

**B. Permission Folder Storage**

Folder `storage/app/public` harus bisa diakses oleh web server.

**Linux/Mac:**

```bash
# Set permission yang benar
chmod -R 775 storage
chmod -R 775 storage/app/public
chown -R www-data:www-data storage  # Ganti www-data sesuai user web server
```

**Windows:**

-   Pastikan folder `storage` tidak read-only
-   Klik kanan → Properties → Uncheck "Read-only"

**C. File Tidak Benar-benar Ter-upload**

Cek apakah file benar-benar ada di `storage/app/public/umkm/products/`:

```bash
# Cek file di folder storage
ls storage/app/public/umkm/products/  # Linux/Mac
dir storage\app\public\umkm\products\  # Windows
```

Jika file tidak ada, berarti ada masalah saat upload. Cek:

-   Error log: `storage/logs/laravel.log`
-   Permission folder `storage/app/public`
-   Ukuran file melebihi `upload_max_filesize` di `php.ini`

**D. Path di Database Salah**

Cek path yang tersimpan di database:

```sql
-- Cek path gambar produk
SELECT image_path FROM umkm_product_images LIMIT 5;
```

Path harus seperti: `umkm/products/filename.jpg`
Bukan: `/storage/umkm/products/filename.jpg` atau path absolut

**E. Web Server Tidak Support Symlink**

Beberapa web server atau hosting tidak support symlink. Solusi alternatif:

**Opsi 1: Copy file ke public (tidak disarankan untuk production)**

```bash
# Copy file dari storage ke public
cp -r storage/app/public/* public/storage/
```

**Opsi 2: Gunakan route untuk serve file**
Tambahkan di `routes/web.php`:

```php
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (file_exists($file)) {
        return response()->file($file);
    }
    abort(404);
})->where('path', '.*');
```

**F. .htaccess Blocking Access**

Cek file `public/.htaccess`, pastikan tidak memblokir akses ke folder `storage`:

```apache
# Pastikan ada rule untuk allow access ke storage
<IfModule mod_rewrite.c>
    RewriteEngine On
    # ... rules lainnya ...

    # Jangan block folder storage
    RewriteCond %{REQUEST_URI} !^/storage/
</IfModule>
```

**G. Cache Browser**

Browser mungkin cache URL yang salah. Coba:

-   Hard refresh: `Ctrl + F5` (Windows) atau `Cmd + Shift + R` (Mac)
-   Clear browser cache
-   Buka di incognito/private mode

**H. Base Path Berbeda**

Jika project dipindah ke komputer lain dengan path berbeda, pastikan:

-   Path project tidak terlalu panjang
-   Tidak ada karakter khusus di path
-   Path tidak mengandung spasi

**I. PHP Configuration**

Cek konfigurasi PHP yang mungkin mempengaruhi:

```bash
# Cek upload settings
php -i | grep upload_max_filesize
php -i | grep post_max_size
php -i | grep memory_limit
```

Edit `php.ini` jika perlu:

```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 256M
```

#### 6. Jika Masih Tidak Berfungsi

**Debug Step by Step:**

1. **Cek URL yang di-generate:**

    - Buka view source di browser
    - Cari tag `<img src="...">`
    - Copy URL dan coba akses langsung di browser
    - Jika 404, berarti symlink atau path salah

2. **Cek Log Error:**

    ```bash
    tail -f storage/logs/laravel.log
    ```

3. **Test Storage URL:**
   Buat file test di `routes/web.php`:

    ```php
    Route::get('/test-storage', function() {
        $testFile = 'umkm/products/test.jpg';
        return [
            'exists' => Storage::disk('public')->exists($testFile),
            'url' => Storage::url($testFile),
            'path' => Storage::disk('public')->path($testFile),
            'app_url' => config('app.url'),
        ];
    });
    ```

    Akses: `http://localhost:8000/test-storage`

4. **Verifikasi Symlink:**

    ```bash
    # Windows
    dir public\storage

    # Linux/Mac
    ls -la public/storage
    readlink public/storage
    ```

**Cek Konfigurasi Filesystem:**
Pastikan di `config/filesystems.php`:

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

**Clear Semua Cache:**

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear  # Laravel 8+
```

### Checklist Setup Awal

Saat setup project di komputer baru, pastikan menjalankan:

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Setup database
php artisan migrate
php artisan db:seed

# 4. ⚠️ PENTING: Buat storage link
php artisan storage:link

# 5. Build assets
npm run build

# 6. Jalankan server
php artisan serve
```

---

## Masalah Lainnya

### Database Connection Error

**Gejala:** Error saat menjalankan migration atau mengakses database

**Solusi:**

1. Pastikan file `.env` sudah dikonfigurasi dengan benar
2. Untuk SQLite: pastikan file `database/database.sqlite` ada dan bisa diakses
3. Untuk MySQL: pastikan database sudah dibuat dan kredensial benar
4. Jalankan: `php artisan config:clear`

### Permission Denied

**Gejala:** Error permission saat upload file atau write ke storage

**Solusi:**

```bash
# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Windows: Pastikan folder tidak read-only
```

### Assets Tidak Ter-load

**Gejala:** CSS/JS tidak muncul, styling hilang

**Solusi:**

```bash
# Build assets
npm run build

# Atau untuk development
npm run dev

# Clear cache
php artisan view:clear
php artisan cache:clear
```

### Route Not Found

**Gejala:** 404 error untuk route yang seharusnya ada

**Solusi:**

```bash
# Clear route cache
php artisan route:clear

# Rebuild route cache (production)
php artisan route:cache
```

---

## Tips

1. **Selalu jalankan `php artisan storage:link`** saat setup project di komputer baru
2. **Jangan commit folder `public/storage`** ke git (sudah ada di `.gitignore`)
3. **Jangan commit folder `storage/app/public`** ke git (sudah ada di `.gitignore`)
4. **Gunakan `Storage::url()`** untuk generate URL gambar, jangan hardcode path
5. **Test upload gambar** setelah setup untuk memastikan symlink berfungsi

---

## Bantuan Lebih Lanjut

Jika masalah masih terjadi:

1. Cek log error di `storage/logs/laravel.log`
2. Aktifkan debug mode di `.env`: `APP_DEBUG=true`
3. Cek permission folder dan file
4. Pastikan semua dependency sudah terinstall dengan benar
