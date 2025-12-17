# ISP Admin CRM System

## 📋 Deskripsi Sistem

**ISP Admin CRM** adalah aplikasi Customer Relationship Management berbasis web untuk perusahaan Internet Service Provider (ISP). Sistem ini membantu divisi sales dalam mengelola calon customer (leads), membuat penawaran layanan (projects), dan mengelola customer yang sudah berlangganan.

### Tujuan Sistem
- Mendigitalkan proses rekap data calon customer dan customer
- Mempermudah pembuatan penawaran layanan internet
- Mengotomatisasi proses approval dari manager
- Mengelola layanan yang digunakan customer

---

## 🎯 Fitur Utama

### 1. **Manajemen Leads (Calon Customer)**
- Menambah, edit, dan hapus data calon customer
- Tracking status lead (Baru, Follow-up, Menunggu, Deal)
- Melihat riwayat project dari setiap lead

### 2. **Master Layanan Internet**
- Paket layanan bawaan sistem (50, 75, 100, 200, 300 Mbps)
- Admin/Manager dapat mengubah harga dan status aktif/nonaktif
- Tidak bisa menambah atau menghapus paket (sudah fixed)

### 3. **Manajemen Project**
- Sales membuat project/penawaran dari lead
- Pilih satu atau lebih layanan untuk ditawarkan
- Manager/Admin approve atau reject project
- Project yang diapprove otomatis membuat customer baru

### 4. **Manajemen Customer**
- Melihat daftar customer aktif
- Mengelola layanan yang digunakan customer
- Upgrade/downgrade layanan
- Suspend atau terminate layanan
- Melihat riwayat perubahan layanan

### 5. **Dashboard & Reporting**
- Statistik total leads, customers, projects
- Pending approvals untuk manager
- Recent leads dan projects

---

## 👥 User Roles & Permissions

### 1. **Admin**
✅ Full access ke semua fitur
✅ Kelola leads, projects, customers
✅ Edit master layanan
✅ Approve/reject projects

### 2. **Manager**
✅ View all data
✅ Edit master layanan
✅ Approve/reject projects
❌ Tidak bisa tambah/edit leads

### 3. **Sales**
✅ Tambah dan edit leads
✅ Buat projects dari leads
✅ View customers
❌ Tidak bisa edit master layanan
❌ Tidak bisa approve projects

---

## 🔄 Business Flow

### Flow 1: Dari Lead ke Customer

```
1. SALES menambah LEAD baru
   ↓
2. SALES membuat PROJECT dari LEAD
   (Pilih layanan yang ditawarkan)
   ↓
3. PROJECT masuk status PENDING
   ↓
4. MANAGER review PROJECT
   ├── APPROVE → Customer otomatis terbuat + Layanan aktif
   └── REJECT → Project ditolak (lead tetap ada)
```

### Flow 2: Kelola Layanan Customer

```
CUSTOMER aktif
   ↓
Admin/Manager buka "Kelola Layanan"
   ↓
Pilih aksi:
├── UPGRADE (50 Mbps → 100 Mbps)
├── DOWNGRADE (100 Mbps → 50 Mbps)
├── TAMBAH layanan baru
├── SUSPEND (pause sementara)
├── AKTIFKAN (resume dari suspend)
└── TERMINATE (hentikan permanent)
```

---

## 💾 Database Schema

### Tabel Utama

#### 1. **users**
Menyimpan data user (Admin, Manager, Sales)
- id (PK)
- name
- email
- password
- role (admin/manager/sales)
- status (aktif/nonaktif)

#### 2. **leads**
Menyimpan data calon customer
- lead_id (PK)
- company_name
- pic (Person In Charge)
- email
- address
- company_name_alias
- status (baru/follow-up/menunggu/deal)
- created_by (FK → users.id)

#### 3. **services**
Master layanan internet (fixed/bawaan)
- service_id (PK)
- service_name
- speed (Mbps)
- price
- description
- status (aktif/nonaktif)

#### 4. **projects**
Penawaran layanan ke lead
- project_id (PK)
- lead_id (FK → leads.lead_id)
- sales_id (FK → users.id)
- status (pending/approved/rejected)
- notes
- created_by (FK → users.id)

#### 5. **project_details**
Detail layanan dalam project
- project_detail_id (PK)
- project_id (FK → projects.project_id)
- service_id (FK → services.service_id)
- qty
- price
- subtotal

#### 6. **customers**
Customer yang sudah berlangganan
- customer_id (PK)
- lead_id (FK → leads.lead_id)
- name
- phone
- email
- address
- status (aktif/nonaktif)

#### 7. **customer_services**
Layanan yang digunakan customer
- customer_service_id (PK)
- customer_id (FK → customers.customer_id)
- service_id (FK → services.service_id)
- start_date
- end_date
- status (aktif/suspend/berakhir)

### Relasi Database

```
users (1) ──── (N) leads
users (1) ──── (N) projects

leads (1) ──── (N) projects
leads (1) ──── (1) customers

services (1) ──── (N) project_details
services (1) ──── (N) customer_services

projects (1) ──── (N) project_details

customers (1) ──── (N) customer_services
```

---

## 🚀 Instalasi & Setup

### Requirement
- PHP >= 8.1
- Composer
- PostgreSQL >= 14
- Node.js & NPM

### Langkah Instalasi

#### 1. Clone/Download Project
```bash
cd ISP_admin
```

#### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```

#### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=isp_admin
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

#### 4. Buat Database
Di PostgreSQL:
```sql
CREATE DATABASE isp_admin;
```

#### 5. Jalankan Migration & Seeder
```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=DummyDataSeeder
```

#### 6. Jalankan Server
```bash
php artisan serve
```

Akses: `http://localhost:8000`

---

## 🔑 Default Login

### Admin
- **Email:** admin@isp.com
- **Password:** password
- **Akses:** Full access

### Manager
- **Email:** manager@isp.com
- **Password:** password
- **Akses:** View all, approve projects, edit services

### Sales
- **Email:** sales@isp.com
- **Password:** password
- **Akses:** Manage leads, create projects

---

## 📊 Data Dummy

Setelah menjalankan seeder, sistem memiliki:

### Leads (5 data)
1. PT Maju Jaya (deal) ✅
2. CV Sejahtera Abadi (deal) ✅
3. Toko Elektronik Jaya (menunggu) ⏳
4. Restoran Sedap Malam (follow-up) 📞
5. Warnet Cepat (baru) 🆕

### Services (5 paket)
1. Paket Home 50 - 50 Mbps - Rp 250.000
2. Paket Home 75 - 75 Mbps - Rp 350.000
3. Paket Home 100 - 100 Mbps - Rp 450.000
4. Paket Business 200 - 200 Mbps - Rp 850.000
5. Paket Premium 300 - 300 Mbps - Rp 1.200.000

### Projects (4 data)
1. PT Maju Jaya - Approved ✅
2. CV Sejahtera Abadi - Approved ✅
3. Toko Elektronik Jaya - Pending ⏳
4. Warnet Cepat - Rejected ❌

### Customers (2 data)
1. PT Maju Jaya - 1 layanan (100 Mbps)
2. CV Sejahtera Abadi - 2 layanan (75 Mbps + 50 Mbps)

---

## 📱 Cara Penggunaan

### Untuk Sales

#### 1. Menambah Lead Baru
1. Login sebagai Sales
2. Menu **Leads** → Klik **"Tambah Lead"**
3. Isi form data lead
4. Klik **"Simpan"**

#### 2. Membuat Project
1. Menu **Leads** → Klik icon folder hijau 📁 di samping lead
   ATAU
   Menu **Projects** → Klik **"Buat Project"** → Pilih lead
2. Pilih satu atau lebih layanan dari dropdown
3. Atur quantity (biasanya 1)
4. Tambah layanan lain jika perlu (klik "Tambah Layanan")
5. Isi notes jika ada
6. Klik **"Buat Project"**

#### 3. Tracking Status
- Menu **Projects** → Lihat status project (Pending/Approved/Rejected)
- Jika approved → Customer otomatis terbuat

---

### Untuk Manager

#### 1. Approve/Reject Project
1. Login sebagai Manager
2. Menu **Projects** → Lihat project dengan status "Pending"
3. Klik **"Detail"** pada project
4. **Approve:**
   - Klik tombol **"Approve Project"**
   - Konfirmasi
   - Customer otomatis terbuat dengan layanan aktif
5. **Reject:**
   - Klik tombol **"Reject Project"**
   - Isi alasan rejection
   - Konfirmasi

#### 2. Edit Harga Layanan
1. Menu **Master Layanan**
2. Klik **"Edit Harga/Status"** pada layanan
3. Ubah harga atau status (Aktif/Nonaktif)
4. Klik **"Update"**

---

### Untuk Admin/Manager

#### 1. Kelola Layanan Customer

**Upgrade Layanan:**
1. Menu **Customers** → Klik **"Detail"**
2. Klik **"Kelola Layanan"**
3. Pada layanan aktif, klik **"Ganti Layanan"**
4. Pilih layanan baru yang lebih tinggi (contoh: 50 Mbps → 100 Mbps)
5. Klik **"Ganti Layanan"**
6. Layanan lama otomatis dinonaktifkan, layanan baru aktif

**Downgrade Layanan:**
- Sama seperti upgrade, tapi pilih layanan lebih rendah

**Tambah Layanan:**
1. Klik **"Tambah Layanan"** (di header card)
2. Pilih layanan baru
3. Klik **"Tambah Layanan"**
4. Customer sekarang punya 2 layanan aktif

**Suspend Layanan:**
- Klik tombol **"Suspend"**
- Layanan di-pause tapi tidak dihapus
- Bisa diaktifkan kembali kapan saja

**Terminate Layanan:**
- Klik tombol **"Hentikan"**
- Layanan dihentikan permanent
- Masuk ke riwayat layanan

---

## 🎨 Tampilan Sistem

### Dashboard
- Cards statistik (Total Leads, Customers, Projects, Pending Approvals)
- Tabel recent leads
- Tabel recent projects

### Leads
- Tabel daftar leads dengan status badge berwarna
- Tombol aksi: View, Edit, Buat Project, Delete

### Master Layanan
- Card layout untuk setiap paket
- Menampilkan kecepatan, harga, dan deskripsi
- Badge status (Aktif/Nonaktif)

### Projects
- Tabel daftar projects dengan total amount
- Badge status (Pending/Approved/Rejected)
- Detail project menampilkan info lead dan layanan

### Customers
- Tabel daftar customers
- Jumlah layanan aktif
- Tombol "Kelola Layanan" untuk manage services

---

## ⚙️ Konfigurasi

### Middleware Role-Based Access Control

File: `app/Http/Middleware/CheckRole.php`

Middleware ini memastikan hanya role tertentu yang bisa akses route:

```php
Route::middleware(['role:admin,manager'])->group(function () {
    // Hanya Admin dan Manager
});
```

### Session Configuration

File: `.env`
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### Database Configuration

File: `.env`
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=isp_admin
```

---

## 🐛 Troubleshooting

### 1. Error 419 Page Expired
**Penyebab:** CSRF token expired
**Solusi:**
```bash
php artisan config:clear
php artisan cache:clear
```
Buka browser incognito dan login ulang

### 2. View Not Found
**Penyebab:** File view belum dibuat atau salah path
**Solusi:**
```bash
php artisan view:clear
```
Cek apakah file view ada di path yang benar

### 3. Database Connection Error
**Penyebab:** Password PostgreSQL salah atau service tidak jalan
**Solusi:**
- Cek password di file `.env`
- Pastikan PostgreSQL service running
- Test koneksi di pgAdmin

### 4. Migration Error
**Penyebab:** Urutan migration salah atau tabel sudah ada
**Solusi:**
```bash
php artisan migrate:fresh
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ServiceSeeder
```

---

## 📝 Catatan Penting

### ⚠️ Customer Tidak Bisa Ditambah Manual
Customer **HANYA** dibuat otomatis saat Manager approve project. Ini by design untuk memastikan setiap customer memiliki history lengkap dari lead → project → customer.

### ⚠️ Master Layanan Fixed
Paket layanan sudah ditentukan sistem (50, 75, 100, 200, 300 Mbps). Admin/Manager hanya bisa edit harga dan status aktif/nonaktif. Tidak bisa tambah/hapus paket baru.

### ⚠️ Project Harus dari Lead
Tidak bisa membuat project tanpa lead. Flow nya: Lead → Project → Customer

### ⚠️ Role Sales Terbatas
Sales hanya bisa membuat project, tidak bisa approve. Approval harus dilakukan oleh Manager/Admin.

---

## 📞 Support

Untuk pertanyaan teknis atau bug report, hubungi tim development.

---

## 📄 License

Proprietary - PT Smart ISP Admin System

---

## 🔄 Changelog

### Version 1.0.0 (December 2025)
- ✅ Initial release
- ✅ User management dengan role-based access
- ✅ Lead management
- ✅ Master layanan (fixed packages)
- ✅ Project management dengan approval workflow
- ✅ Customer management
- ✅ Upgrade/downgrade layanan customer
- ✅ Suspend/terminate layanan
- ✅ Dashboard dan reporting

---

**Terakhir diupdate:** 17 Desember 2025
