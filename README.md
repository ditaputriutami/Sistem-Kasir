# Sistem Kasir / Pembelian Barang - Laravel

Aplikasi sistem pembelian barang berbasis web menggunakan Laravel 11, MySQL, dan Bootstrap 5.

## 📋 Fitur Aplikasi

### 1. Manajemen Barang
- CRUD data barang (Tambah, Edit, Hapus, Lihat)
- Stok otomatis bertambah dari transaksi pembelian
- Validasi form lengkap

### 2. Manajemen Pemasok
- CRUD data pemasok/distributor
- Informasi lengkap pemasok (nama, alamat, telepon)

### 3. Transaksi Pembelian
- Form transaksi dengan multi-item (bisa tambah banyak barang sekaligus)
- Nomor faktur otomatis (Format: BL-YYYYMMDD-XXXX)
- Kalkulasi subtotal dan total otomatis
- **Stok barang otomatis bertambah saat transaksi disimpan**
- Database transaction untuk konsistensi data

### 4. Laporan Pembelian
- Filter berdasarkan periode tanggal
- Rekap detail per transaksi
- Fitur cetak laporan
- Grand total otomatis

## 🚀 Cara Instalasi & Menjalankan

### Langkah 1: Buat Database MySQL

Buka MySQL (via phpMyAdmin, MySQL Workbench, atau command line) dan jalankan:

```sql
CREATE DATABASE sistem_kasir_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Langkah 2: Jalankan Migration

Buka terminal di folder project dan jalankan:

```bash
php artisan migrate
```

Perintah ini akan membuat semua tabel yang diperlukan:
- `barang` - Tabel data barang
- `pemasok` - Tabel data pemasok
- `beli` - Tabel header transaksi pembelian
- `detail_beli` - Tabel detail item pembelian

### Langkah 3: Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

## 📱 Cara Menggunakan Aplikasi

### 1. Tambah Data Barang
1. Klik menu **Data Barang**
2. Klik tombol **Tambah Barang**
3. Isi form (kode barang, nama, stok awal, satuan, harga beli)
4. Klik **Simpan**

### 2. Tambah Data Pemasok
1. Klik menu **Data Pemasok**
2. Klik tombol **Tambah Pemasok**
3. Isi form (nama pemasok, alamat, no telepon)
4. Klik **Simpan**

### 3. Buat Transaksi Pembelian
1. Klik menu **Transaksi Pembelian**
2. Klik tombol **Transaksi Baru**
3. Pilih tanggal dan pemasok
4. Klik **Tambah Item** untuk menambah barang
5. Pilih barang, isi jumlah (harga akan otomatis terisi)
6. Ulangi untuk barang lain jika perlu
7. Klik **Simpan Transaksi**
8. **Stok barang akan otomatis bertambah!**

### 4. Lihat Laporan
1. Klik menu **Laporan Pembelian**
2. Pilih periode tanggal (opsional)
3. Klik **Filter**
4. Klik **Cetak Laporan** untuk print

## 🔧 Struktur Database

### Tabel: barang
- `id` - Primary key
- `kode_barang` - Kode unik barang
- `nama_barang` - Nama barang
- `stok` - Jumlah stok (otomatis update)
- `satuan` - Satuan (pcs, kg, box, dll)
- `harga_beli` - Harga beli

### Tabel: pemasok
- `id` - Primary key
- `nama_pemasok` - Nama pemasok
- `alamat` - Alamat pemasok
- `no_telepon` - Nomor telepon

### Tabel: beli
- `id` - Primary key
- `no_faktur` - Nomor faktur (auto-generate)
- `tanggal` - Tanggal pembelian
- `pemasok_id` - Foreign key ke tabel pemasok
- `total` - Total pembelian

### Tabel: detail_beli
- `id` - Primary key
- `beli_id` - Foreign key ke tabel beli
- `barang_id` - Foreign key ke tabel barang
- `jumlah` - Jumlah barang dibeli
- `harga_beli` - Harga beli per unit
- `subtotal` - Subtotal (jumlah × harga_beli)

## 💡 Fitur Unggulan

### ✅ Penambahan Stok Otomatis
Saat transaksi pembelian disimpan, stok barang akan **otomatis bertambah** sesuai jumlah yang dibeli. Sistem menggunakan **database transaction** untuk memastikan konsistensi data.

### ✅ Validasi Form Lengkap
Semua form memiliki validasi dengan pesan error dalam Bahasa Indonesia.

### ✅ Nomor Faktur Otomatis
Sistem akan generate nomor faktur otomatis dengan format: **BL-YYYYMMDD-XXXX**
Contoh: BL-20251229-0001

### ✅ Kalkulasi Otomatis
- Subtotal dihitung otomatis (jumlah × harga)
- Total transaksi dihitung otomatis
- Grand total laporan dihitung otomatis

### ✅ UI Responsif & Modern
- Menggunakan Bootstrap 5
- Sidebar navigasi dengan gradient
- Alert notifications
- Responsive di semua ukuran layar

## 📝 Catatan Penting

1. **Database**: Pastikan MySQL server sudah berjalan
2. **PHP Version**: Minimal PHP 8.2
3. **Composer**: Diperlukan untuk instalasi Laravel
4. **Stok Otomatis**: Stok akan bertambah saat transaksi pembelian disimpan
5. **Hapus Transaksi**: Jika transaksi dihapus, stok akan dikembalikan (rollback)

## 🎨 Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5 + Bootstrap Icons
- **JavaScript**: Vanilla JS untuk form dinamis
- **Arsitektur**: MVC (Model-View-Controller)

## 📞 Troubleshooting

### Error: Database connection failed
- Pastikan MySQL server sudah berjalan
- Cek konfigurasi di file `.env`:
  - `DB_DATABASE=sistem_kasir_db`
  - `DB_USERNAME=root`
  - `DB_PASSWORD=` (kosongkan jika tidak ada password)

### Error: Class not found
Jalankan:
```bash
composer dump-autoload
```

### Error: Application key not set
Jalankan:
```bash
php artisan key:generate
```

## ✨ Selamat Menggunakan!

Aplikasi siap digunakan untuk mengelola pembelian barang dengan fitur stok otomatis.
