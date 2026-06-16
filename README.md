# 🔐 Secure Access Log System (IoT)

## 📖 Deskripsi Singkat
Proyek ini adalah sistem pencatatan akses pintar berbasis Internet of Things (IoT) yang dirancang untuk mensimulasikan sistem keamanan pintu modern. Menggunakan mikrokontroler **ESP32 D1 R32** dan sensor **RFID RC522**, sistem ini membaca identitas kartu fisik dan mencatat aktivitas akses ke dalam *database* secara *real-time*.

Proyek ini dibangun untuk memenuhi spesifikasi teknis tingkat lanjut, termasuk penerapan **FreeRTOS** untuk efisiensi *multitasking* perangkat keras, serta implementasi **Keamanan Jaringan** (Enkripsi/Dekripsi) untuk melindungi integritas data log saat ditransmisikan melalui protokol HTTP.

## ✨ Fitur Utama
- **Real-Time Multitasking (FreeRTOS):** Memisahkan tugas (*task*) pembacaan sensor RFID dan tugas transmisi WiFi, memastikan alat tidak mengalami *hang* atau *freeze* saat koneksi lambat.
- **Data Security (Encrypt & Decrypt):** Data UID RFID dienkripsi (*ciphertext*) di dalam ESP32 sebelum dikirimkan ke server, mencegah pencurian data akses melalui intersepsi jaringan (*sniffing*).
- **Web Monitoring:** *Dashboard* terpusat untuk memantau status akses (Diterima/Ditolak) beserta waktu kejadian (timestamp).

## 🛠️ Teknologi yang Digunakan
*   **Hardware:** ESP32 D1 R32, Modul RFID RC522, Breadboard, Jumper Wires.
*   **Firmware:** C/C++ (Arduino IDE) & FreeRTOS.
*   **Backend & Database:** PHP & MySQL.
*   **Frontend (UI/UX):** Web.
*   **Protokol:** HTTP POST / REST API.

## 👥 Anggota Kelompok
1. [Salman Azhar Latisio] - *Hardware & wiring alat-alat.*
2. [Irham Irawan] - *Coding & setup arduino*
3. [Arika Azhar] - *Frontend & Backend*

---
*Proyek ini dikembangkan sebagai Tugas Akhir (UAS) untuk mata kuliah Sistem Mikrokontroler.*

---
## 📈 Alur Progres Pengerjaan Tugas Akhir

Berikut adalah *timeline* dan pembagian tugas selama pengembangan proyek Secure Access Log System:
### Fase 1: Perencanaan & Persiapan (Selesai)
- [x] Diskusi ide dan penentuan spesifikasi proyek.
- [x] Pembelian komponen *hardware* (ESP32, RC522, LED, Jumper).
- [x] Pembagian tugas (*Hardware*, *Firmware*, *Web/Backend*).
### Dokumentasi:
<img width="560" height="360" alt="Belanja sensor" src="https://github.com/user-attachments/assets/a8238107-7c0f-4c6c-9ec7-76c5e9ff87e1" />
<img width="590" height="400" alt="kabel jumper" src="https://github.com/user-attachments/assets/220f1a13-6c9a-49e8-a6a3-b2089a85bd2f" />

---
### Fase 2: Perakitan Perangkat Keras (PIC: Salman) (Selesai)
- [x] *Wiring* sensor RFID RC522 ke pin SPI ESP32.
- [x] Pemasangan sirkuit indikator LED.
- [x] Pengujian konektivitas daya dan *troubleshooting hardware* (mengatasi *brownout/restart*).
### Dokumentasi:
<img width="590" height="410" alt="image" src="https://github.com/user-attachments/assets/b6c2c095-d006-445c-99cc-e0936d65d74a" />
<img width="590" height="410" alt="image" src="https://github.com/user-attachments/assets/8c2fcffc-ae92-4468-ab3a-394e0e3d04d7" />


