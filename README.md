# 📦 Sistem Informasi Inventory Restoran (Metode FIFO)

Aplikasi berbasis web untuk mengelola stok bahan baku restoran menggunakan metode **FIFO (First In, First Out)**. Dibangun menggunakan **Laravel 12** dan **Filament v5**, sistem ini dirancang untuk memastikan bahan baku yang paling lama masuk akan digunakan terlebih dahulu untuk mencegah kedaluwarsa.

## 🚀 Fitur Utama

- **Manajemen Master Data Produk:** Pencatatan bahan baku dengan kode barang unik (contoh: `001` untuk Ayam).
- **Inbound (Barang Masuk):** Pencatatan stok masuk berdasarkan Tanggal Produksi dan Sesi (Pagi/Siang).
- **Auto-Generate Barcode:** Sistem secara otomatis membuat barcode unik untuk setiap _batch_ barang masuk dengan format:
  `[Kode Barang 3 digit] + [Tanggal dmyyyy] + [Sesi 01/02] + [Qty]`
  _(Contoh: `001010320260150`)_
- **Kasir / Scanner Checkout:** Halaman khusus antarmuka _Point of Sale_ yang mendukung input dari _Barcode Scanner_ fisik untuk proses pengeluaran barang secara instan.
- **Logika Cerdas FIFO:** Saat pengeluaran barang, sistem otomatis memotong stok dari _batch_ paling tua. Jika stok _batch_ tertua tidak cukup, sistem akan otomatis memotong sisa kekurangannya dari _batch_ tertua berikutnya.
- **Multi-Bahasa (Localization):** Mendukung pergantian bahasa antarmuka (contoh: Indonesia & Inggris) menggunakan plugin terintegrasi.

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel 12
- **Admin Panel:** Filament v5
- **Bahasa Pemrograman:** PHP 8.2+
- **Database:** MySQL / PostgreSQL / MariaDB

## 📋 Prasyarat Sistem

Pastikan perangkat lunak berikut sudah terinstal di komputermu:

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database Server (MySQL/MariaDB)

## ⚙️ Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputermu:

1. **Clone Repository**

    ```bash
    git clone https://github.com/BangEjak04/fifo-inventory-laravel.git
    cd fifo-inventory-laravel
    ```

2. **Install Dependencies (PHP & Node)**

    ```bash
    composer install
    npm install && npm run build
    ```

3. **Konfigurasi Environment**
    ```bash
    cp .env.example .env
    ```

4. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5. ***Jalankan Migrasi Database**
    ```bash
    php artisan migrate --seed
    ```

6. **Jalankan Local Server**
    ```bash
    php artisan serve
    ```

Aplikasi sekarang dapat diakses melalui browser di: http://localhost:8000/app

📖 Alur Kerja Sistem (Workflow)

  1. Admin mendaftarkan master data bahan baku di menu Produk.

  2. Saat ada barang dari supplier, Admin membuka detail Produk dan menambah data di Riwayat Barang Masuk (Inbound). Barcode akan tercipta otomatis.

  3. Saat Dapur membutuhkan bahan, Dapur membawa barang tersebut ke Admin.

  4. Admin membuka menu Kasir / Checkout, lalu melakukan scan barcode pada barang tersebut.

  5. Sistem memproses transaksi dan secara otomatis mengurangi stok sisa (qty_remaining) di database dengan algoritma FIFO.

---
Dibuat dengan ❤️ menggunakan Laravel & Filament.