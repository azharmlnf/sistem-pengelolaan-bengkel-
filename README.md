
Ini adalah proyek sistem bengkel berbasis Laravel yang mencakup manajemen pelanggan, kendaraan, layanan servis, transaksi, dan suku cadang.  
Proyek ini menggunakan **Laravel** sebagai backend dan **Filament** sebagai admin panel.  

---

## **📌 Persyaratan Minimum**  
Pastikan perangkat Anda sudah memiliki:  
- **PHP** `>=8.1`  
- **Composer** `>=2.0`  
- **MySQL / MariaDB**  
- **Git**  

---

## **🛠️ Langkah-langkah Install dan Menjalankan Project**  
Ikuti langkah-langkah berikut untuk meng-clone dan menjalankan proyek ini:  

### **1️⃣ Clone Repository**  
```sh
git clone https://github.com/azharmlnf/sistem-pengelolaan-bengkel.git
cd sistem-pengelolaan-bengkel
```

### **2️⃣ Install Dependencies**  
```sh
composer install
```

### **3️⃣ Buat File Konfigurasi**  
Copy file `.env.example` menjadi `.env`:  
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

### **6️⃣ Buat Storage Link (Opsional, Jika Ada File Upload)**  
```sh
php artisan storage:link
```

### **7️⃣ Jalankan Server Laravel**  
```sh
php artisan serve
```
Akses aplikasi melalui: [http://127.0.0.1:8000](http://127.0.0.1:8000)  

### **8️⃣ Akses Admin Panel Filament**  
Filament menyediakan admin panel di URL berikut:  
[http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)  

Login menggunakan akun admin yang telah dibuat di seeder atau daftar akun baru.  

---

## **🚀 Perintah Tambahan**  
- **Menjalankan ulang migrasi dan seed database**  
  ```sh
  php artisan migrate:fresh --seed
  ```
- **Menjalankan queue worker (jika ada email/job processing)**  
  ```sh
  php artisan queue:work
  ```
- **Menjalankan perintah optimize (untuk meningkatkan performa)**  
  ```sh
  php artisan optimize
  ```

---

## **📸 Tampilan Admin Panel Filament**  
Berikut contoh tampilan admin panel:  

![Admin Panel Filament](https://user-images.githubusercontent.com/yourusername/admin-panel.png)  
> *(Gantilah URL gambar dengan screenshot dari admin panel Filament di sistem Anda)*  

---

## **❓ Troubleshooting**  
- Jika terjadi error **SQLSTATE[HY000]**, pastikan:  
  - Database sudah dibuat dengan nama `sistem_bengkel`.  
  - File `.env` sudah dikonfigurasi dengan benar.  
  - Jalankan ulang `php artisan migrate:fresh --seed` untuk reset database.  

- Jika mendapatkan error terkait **Filament**, coba jalankan:  
  ```sh
  php artisan cache:clear
  php artisan config:clear
  php artisan migrate --seed
  ```

---

## **💡 Kontribusi**  
Pull Request selalu terbuka untuk perbaikan dan fitur baru.  
Jika ingin berkontribusi, buat branch baru sebelum mengajukan perubahan.  

---

## **📜 Lisensi**  
Proyek ini dilisensikan di bawah [MIT License](LICENSE).  

---

Jika ada kendala, silakan buat *issue* di repository ini.  
Selamat coding! 🚀  

---

### **📌 Catatan:**  
- Gantilah **URL gambar** dengan screenshot sistem Anda.  
- Pastikan **Seeder** sudah membuat akun admin default agar pengguna dapat login ke admin panel Filament.
