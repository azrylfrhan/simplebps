# 📦 Deployment Guide - OEK System

Panduan lengkap untuk deploy OEK System ke Railway.

## ✅ Pre-Deployment Checklist

Sebelum deploy, pastikan:

- [ ] Semua code sudah di-commit dan di-push ke GitHub
- [ ] `.env` file **tidak** di-commit (check `.gitignore`)
- [ ] Branch `main` adalah production branch
- [ ] Database backup sudah dibuat
- [ ] Semua migrations sudah ditest lokal

---

## 🚀 Deployment Steps

### 1. Setup Railway Project

1. Login ke [Railway.app](https://railway.app)
2. Create New Project → Deploy from GitHub
3. Pilih repository `project-magang`
4. Railway akan auto-detect `Dockerfile` dan build

### 2. Configure Environment Variables

Add semua variable di Railway → Project Settings → Variables:

**Copy-paste dari `.env.railway.example`, kemudian update dengan nilai real:**

```
APP_NAME=OEK System
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE          # Generate lokal: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-railway-domain.com   # Update setelah Railway assign domain

DB_CONNECTION=mysql
DB_HOST=YOUR_DATABASE_HOST
DB_PORT=3306
DB_DATABASE=oek
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync                     # Ubah ke database nanti jika ada background jobs

LOG_CHANNEL=stack
LOG_LEVEL=notice
```

**⚠️ PENTING:**
- `APP_KEY` harus sama dengan local key, generate lewat: `php artisan key:generate --show`
- `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` ambil dari Railway MySQL service
- Jangan copy `.env` file langsung, setup manual satu-satu

### 3. Setup Database Service (Railway)

1. Di project Railway, click **+ Add Service**
2. Pilih **MySQL**
3. Tunggu selesai, ambil credentials:
   - Hostname
   - Port
   - Database name
   - Username
   - Password
4. Tempel ke Variables (step 2)

### 4. First Deploy Initialization

Setelah deploy pertama berhasil build:

1. **Buka Railway Shell** untuk app service
2. Jalankan:
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=AdminSeeder --force
   ```
3. Check login works dengan credentials:
   - Username: `admin` / Password: `admin123`
   - Username: `operator` / Password: `operator123`
   - ⚠️ **FORCE CHANGE PASSWORD pada login pertama**

### 5. Post-Deployment Checks

Setelah deploy, verify:

- [ ] Domain Railway bisa diakses
- [ ] Login berhasil (admin + operator)
- [ ] Force change password works
- [ ] Session tersimpan di database (cek table `sessions`)
- [ ] Cache works (cek table `cache`)
- [ ] Check logs di Railway untuk errors

---

## 📋 Important Points

### Storage & File Upload
- Dalam container, storage bersifat **ephemeral** (hilang saat restart)
- Untuk production: gunakan S3 atau Railway volume storage
- Status sekarang: file uploads hanya untuk development

### Session & Cache
- Keduanya menggunakan `database` driver (tabel `sessions` & `cache`)
- Data akan persist selama database tetap running
- Auto-cleaned oleh Laravel

### Queue & Background Jobs
- Status sekarang: `QUEUE_CONNECTION=sync` (jobs langsung dijalankan)
- Untuk async jobs nanti: ubah ke `QUEUE_CONNECTION=database` dan jalankan worker

### Logging
- Logs di container, akses lewat Railway Logs tab
- Untuk persistent logging: setup Sentry atau cloud storage

---

## 🔄 Updates & Re-deployment

Setiap kali ada code changes:

1. Commit & push ke `main`
2. Railway auto-redeploy
3. Jika ada migration baru, jalankan manual di shell:
   ```bash
   php artisan migrate --force
   ```

---

## ⚠️ Troubleshooting

### "Application failed to respond" (500 error)

Cek lokal terminal via Railway → Logs tab:

- Missing `APP_KEY` → set di Variables
- Database connection failed → verify `DB_*` variables
- Migration belum jalan → jalankan `php artisan migrate --force`

### Session/Cache errors

Pastikan tabel ada di database:
```sql
SHOW TABLES LIKE 'sessions';
SHOW TABLES LIKE 'cache';
```

Jika tidak ada, jalankan:
```bash
php artisan migrate --force
```

### Build failed (Docker error)

Cek Railway build logs, pastikan:
- `composer.json` & `package.json` valid
- No PHP 8.2 compatibility issues
- Semua GD extension available (sudah di Dockerfile)

---

## 🔐 Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production`
- [ ] `APP_KEY` di-set dan unique
- [ ] Semua credentials di Railway Variables (tidak di `.env`)
- [ ] Database credentials di-change dari default
- [ ] HTTPS domain active
- [ ] Regular password updates untuk admin account

---

## 📞 Support

Kalau ada issue:
1. Check Railway Logs → ganti `APP_DEBUG=true` temporarily
2. Jalankan checks dari Troubleshooting section
3. Verify semua variables sudah benar
4. Force redeploy jika update env

---

**Last Updated:** April 1, 2026  
**Rails Version:** Laravel 12  
**PHP Version:** 8.3
