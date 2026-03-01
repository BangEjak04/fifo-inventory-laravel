# 📦 Sistem Informasi Inventory Restoran (Metode FIFO)

Aplikasi berbasis web untuk mengelola stok bahan baku restoran menggunakan metode **FIFO (First In, First Out)**. Dibangun menggunakan **Laravel 12** dan **Filament v5**, sistem ini dirancang untuk memastikan bahan baku yang paling lama masuk akan digunakan terlebih dahulu untuk mencegah kedaluwarsa.

## 🚀 Fitur Utama

- **Manajemen Master Data Produk:** Pencatatan bahan baku dengan kode barang unik (contoh: `001` untuk Ayam).
- **Inbound (Barang Masuk):** Pencatatan stok masuk berdasarkan Tanggal Produksi dan Sesi (Pagi/Siang).
- **Auto-Generate Barcode:** Sistem secara otomatis membuat barcode unik untuk setiap *batch* barang masuk dengan format:
  `[Kode Barang 3 digit] + [Tanggal dmyyyy] + [Sesi 01/02] + [Qty]`
  *(Contoh: `001010320260150`)*
- **Kasir / Scanner Checkout:** Halaman khusus antarmuka *Point of Sale* yang mendukung input dari *Barcode Scanner* fisik untuk proses pengeluaran barang secara instan.
- **Logika Cerdas FIFO:** Saat pengeluaran barang, sistem otomatis memotong stok dari *batch* paling tua. Jika stok *batch* tertua tidak cukup, sistem akan otomatis memotong sisa kekurangannya dari *batch* tertua berikutnya.
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
   git clone <url-repository-kamu>
   cd <nama-folder-project>