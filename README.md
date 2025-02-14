

# **Sistem Bengkel Laravel** 🚗🔧

Ini adalah proyek sistem bengkel berbasis Laravel yang mencakup manajemen pelanggan, kendaraan, layanan servis, transaksi, dan suku cadang.

## **📌 Persyaratan Minimum**
Pastikan perangkat Anda sudah terinstal:  
- PHP `>=8.1`  
- Composer `>=2.0`  
- MySQL / MariaDB  
- Node.js (untuk Vite jika digunakan)  
- Git  

---

## **🛠️ Cara Install dan Menjalankan Project**
### **1️⃣ Clone Repository**
```sh
git clone https://github.com/username/repo-sistem-bengkel.git
cd repo-sistem-bengkel
```
> Gantilah `username/repo-sistem-bengkel` dengan URL repository Anda.

### **2️⃣ Install Dependencies**
```sh
composer install
npm install # (Jika menggunakan Vite untuk asset frontend)
```

### **3️⃣ Buat File Konfigurasi**
Copy file `.env.example` menjadi `.env`
```sh
cp .env.example .env
```
Kemudian edit `.env` untuk mengatur koneksi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_bengkel
DB_USERNAME=root
DB_PASSWORD=
```

### **4️⃣ Generate Application Key**
```sh
php artisan key:generate
```

### **5️⃣ Jalankan Migrasi dan Seeder**
```sh
php artisan migrate --seed
```
> Perintah ini akan membuat tabel di database dan mengisi beberapa data awal (jika ada seeder).

### **6️⃣ Jalankan Server Laravel**
```sh
php artisan serve
```
Akses aplikasi melalui: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## **🚀 Perintah Tambahan**
- **Menjalankan Vite (Jika Digunakan)**
  ```sh
  npm run dev
  ```
- **Membuat Storage Link**
  ```sh
  php artisan storage:link
  ```
- **Menjalankan Seeder Ulang**
  ```sh
  php artisan db:seed
  ```

---

## **❓ Troubleshooting**
- Jika ada error `SQLSTATE[HY000]`, pastikan:
  - Database sudah dibuat (`sistem_bengkel`).
  - Konfigurasi `.env` sesuai dengan database lokal Anda.
  - Jalankan ulang `php artisan migrate:fresh --seed` untuk reset database.
- Jika `npm run dev` gagal, coba hapus `node_modules` dan `package-lock.json`, lalu jalankan ulang:
  ```sh
  rm -rf node_modules package-lock.json
  npm install
  npm run dev
  ```

---

## **💡 Kontribusi**
Pull Request selalu terbuka untuk perbaikan dan fitur baru. Pastikan untuk membuat branch baru sebelum mengajukan perubahan.

---

## **📜 Lisensi**
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

Jika ada kendala, silakan buat *issue* di repository ini. Happy coding! 🚀
