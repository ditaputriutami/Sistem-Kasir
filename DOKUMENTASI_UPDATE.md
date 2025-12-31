# Dokumentasi Update Struktur Database

## Perubahan yang Dilakukan

Sistem telah diupdate untuk menggunakan struktur tabel sesuai dengan diagram ERD yang baru. Perubahan ini diterapkan pada tabel yang sudah ada (pemasok, beli, detail_beli) tanpa membuat tabel baru.

## Struktur Tabel Setelah Update

### 1. Tabel `pemasok` (Distributor)

-   `id` - Primary Key (Auto Increment)
-   `kode_pemasok` - VARCHAR(20), kode unik pemasok
-   `nama_pemasok` - VARCHAR(100), nama pemasok/distributor
-   `alamat` - VARCHAR(100), alamat
-   `tlp` - VARCHAR(50), nomor telepon _(diubah dari `no_telepon`)_
-   `created_at` - DATETIME
-   `updated_at` - DATETIME

### 2. Tabel `beli` (Pembelian)

-   `id` - Primary Key (Auto Increment)
-   `no_faktur` - VARCHAR(255), nomor faktur pembelian
-   `pemasok_id` - Foreign Key ke tabel pemasok
-   `jumlah_pembelian` - INT, total jumlah item yang dibeli _(diubah dari `total`)_
-   `tanggal` - DATE, tanggal pembelian
-   `created_at` - DATETIME
-   `updated_at` - DATETIME

### 3. Tabel `detail_beli` (Detail Pembelian)

-   `id` - Primary Key (Auto Increment)
-   `beli_id` - Foreign Key ke tabel beli
-   `barang_id` - Foreign Key ke tabel barang
-   `quantity` - INT, jumlah barang yang dibeli _(diubah dari `jumlah`)_
-   `harga` - INT, harga satuan barang _(diubah dari `harga_beli` decimal)_
-   `created_at` - DATETIME
-   `updated_at` - DATETIME

## Perubahan Detail

### Tabel Pemasok

-   ✅ Field `no_telepon` diganti menjadi `tlp`
-   ✅ Tipe data `alamat` diubah dari TEXT menjadi VARCHAR(100)
-   ✅ Tipe data `nama_pemasok` diubah menjadi VARCHAR(100)

### Tabel Beli

-   ✅ Field `total` (decimal) diganti menjadi `jumlah_pembelian` (int)
-   ✅ `jumlah_pembelian` menyimpan total quantity item, bukan total harga

### Tabel Detail Beli

-   ✅ Field `jumlah` diganti menjadi `quantity`
-   ✅ Field `harga_beli` (decimal) diganti menjadi `harga` (int)
-   ✅ Field `subtotal` dihapus (dihitung otomatis dengan accessor)

## File yang Diupdate

### Migration

-   ✅ `2025_12_31_100001_update_pemasok_table_structure.php` - Update struktur tabel pemasok
-   ✅ `2025_12_31_100002_update_beli_table_structure.php` - Update struktur tabel beli
-   ✅ `2025_12_31_100003_update_detail_beli_table_structure.php` - Update struktur tabel detail_beli

### Model

-   ✅ `app/Models/Pemasok.php` - Update fillable: `tlp` (dari `no_telepon`)
-   ✅ `app/Models/Beli.php` - Update fillable: `jumlah_pembelian` (dari `total`)
-   ✅ `app/Models/DetailBeli.php` - Update fillable: `quantity`, `harga` (dari `jumlah`, `harga_beli`, `subtotal`)
-   ✅ Tambah accessor `getSubtotalAttribute()` di DetailBeli untuk menghitung subtotal otomatis

### Controller

-   ✅ `app/Http/Controllers/PemasokController.php` - Update validasi field `tlp`
-   ✅ `app/Http/Controllers/BeliController.php` - Update untuk menggunakan `quantity`, `harga`, dan `jumlah_pembelian`

### View

-   ✅ `resources/views/pemasok/create.blade.php` - Update field `tlp`
-   ✅ `resources/views/pemasok/edit.blade.php` - Update field `tlp`
-   ✅ `resources/views/pemasok/index.blade.php` - Update field `tlp`
-   ✅ `resources/views/beli/create.blade.php` - Update field `quantity` dan `harga`
-   ✅ `resources/views/beli/show.blade.php` - Update tampilan detail dengan informasi lengkap distributor
-   ✅ `resources/views/beli/index.blade.php` - Tampilkan `jumlah_pembelian` instead of `total`
-   ✅ `resources/views/layouts/app.blade.php` - Bersihkan sidebar dari label sistem lama/baru

### Routes

-   ✅ `routes/web.php` - Hapus route sistem baru (distributor, pembelian)

## Fitur yang Dipertahankan

-   ✅ Auto-generate No Faktur (format: BL-YYYYMMDD-0001)
-   ✅ Update stok barang otomatis saat transaksi pembelian
-   ✅ Restore stok otomatis saat hapus pembelian
-   ✅ Database transaction untuk konsistensi data
-   ✅ Validasi form input
-   ✅ Halaman detail pembelian lengkap dengan informasi distributor
-   ✅ Fitur cetak detail pembelian

## Cara Menggunakan

### Halaman Pemasok

-   Semua fitur tetap sama, hanya field `no_telepon` berubah menjadi `tlp`

### Halaman Pembelian

1. **Tambah Pembelian**: Klik "Transaksi Baru"
2. **Pilih Pemasok**: Pilih dari dropdown
3. **Tambah Item**: Klik "Tambah Item" untuk menambah barang
4. **Input Data**: Pilih barang, masukkan quantity dan harga
5. **Simpan**: Klik "Simpan Transaksi"

### Halaman Detail Pembelian

-   Klik icon mata (👁️) pada daftar pembelian
-   Menampilkan:
    -   Informasi faktur dan tanggal
    -   Data pemasok lengkap (nama, alamat, telepon)
    -   Daftar barang dengan quantity dan harga
    -   Total item dan total harga
-   Fitur cetak tersedia

## Catatan Penting

1. **Backward Compatibility**: Data lama tetap aman dan akan otomatis termigrasi ke struktur baru
2. **Subtotal**: Tidak lagi disimpan di database, dihitung otomatis dengan accessor
3. **Total**: Field `total` pada tabel beli diganti dengan `jumlah_pembelian` yang menyimpan total quantity
4. **Telepon**: Field telepon tidak lagi wajib numeric, bisa mengandung karakter lain (contoh: +62, -)
5. **Harga**: Disimpan sebagai integer (bukan decimal) untuk menyederhanakan perhitungan

## Migrasi Data

Jika ada data lama yang perlu dimigrasi:

```bash
# Migration otomatis akan memperbarui struktur tabel
php artisan migrate

# Jika perlu rollback
php artisan migrate:rollback --step=3
```

## Status

✅ **Migration**: Berhasil dijalankan
✅ **Update Model**: Selesai
✅ **Update Controller**: Selesai
✅ **Update View**: Selesai
✅ **Testing**: Siap untuk ditest
✅ **Cleanup**: File sistem baru sudah dihapus
