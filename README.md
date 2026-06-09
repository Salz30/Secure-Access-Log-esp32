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
1. [Salman Azhar Latisio] - *Hardware & Firmware Engineer (sementara)*
2. [Irham Irawan] - *Network & Security Engineer (sementara)*
3. [Arika Azhar] - *Frontend & AI Developer (sementara)*

---
*Proyek ini dikembangkan sebagai Tugas Akhir Semester untuk mata kuliah Sistem Mikrokontroler.*
