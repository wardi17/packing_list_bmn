# 📦 PackingList System

Sistem PackingList ini digunakan untuk mencatat dan memproses data transaksi pengiriman barang, supplier, dan detail transaksi lainnya. Proyek ini menggunakan **SQL Server** dan **ODBC** sebagai koneksi ke database.

## 🔧 Prasyarat

- SQL Server 2008 atau lebih tinggi
- PHP (jika digunakan untuk integrasi backend)
- Koneksi ODBC sudah diaktifkan

---

## ⚙️ Langkah Instalasi

### 1️⃣ Buat Koneksi ODBC

1. Buka **ODBC Data Source Administrator** (Cari "ODBC" di menu Start).
2. Pilih tab `System DSN` → klik **Add**.
3. Pilih **SQL Server** → klik **Finish**.
4. Masukkan:
   - **Name**: `BAMBI_BMI`
   - **Server**: nama instance SQL Server Anda
5. Klik **Next** dan selesaikan wizard dengan credential yang sesuai.

---

### 2️⃣ Buat Database

Buka SQL Server Management Studio (SSMS) dan jalankan:

```sql
CREATE DATABASE [bambi-bmi];
GO

-setelah itu buat table yang ada di folder sp,fun&table
1. buat tabel POTRANSACTION
2. buat tabel  POTRANSACTIONDETAIL
3. buat tabel supplier
4. buat table 
