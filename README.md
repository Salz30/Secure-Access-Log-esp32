# 🔐 Secure Access Log System (IoT)

## 📖 Deskripsi Singkat
Proyek ini adalah sistem pencatatan akses pintar berbasis Internet of Things (IoT) yang dirancang untuk mensimulasikan sistem Absensi yang aman. Menggunakan mikrokontroler **ESP32 D1 R32** dan sensor **RFID RC522**, sistem ini membaca identitas kartu fisik dan mencatat aktivitas akses ke dalam *database* secara *real-time*.

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

## 🔌 Panduan Wiring (Pinout)

### 1. Wiring Sensor RFID RC522 ke ESP32 D1 R32
| Pin RC522 | Pin ESP32 (D1 R32) | Keterangan |
| :--- | :--- | :--- |
| **SDA (SS)** | IO05 (5) | Pin *Chip Select* untuk komunikasi SPI |
| **SCK** | IO18 (18) | Pin sinkronisasi (*Clock*) |
| **MOSI** | IO23 (23) | Pin kirim data (*Master Out Slave In*) |
| **MISO** | IO19 (19) | Pin terima data (*Master In Slave Out*) |
| **RST** | IO13 (13) | Pin untuk me-reset modul pembaca |
| **IRQ** | (Tidak Dihubungkan) | Tidak perlu dipasang kabel |
| **GND** | GND | *Ground* / Kutub Negatif |
| **3.3V** | 3V3 | *Power* / Kutub Positif (**Wajib 3.3 Volt**) |

### 2. Wiring Indikator LED
| Komponen | Jalur Sambungan (Wiring) |
| :--- | :--- |
| **LED Hijau (Diterima)** | • Lubang **IO14** ESP32 ➔ Resistor ➔ Kaki Panjang LED Hijau.<br>• Kaki Pendek LED Hijau ➔ Lubang **GND** ESP32. |
| **LED Merah (Ditolak)** | • Lubang **IO27** ESP32 ➔ Resistor ➔ Kaki Panjang LED Merah.<br>• Kaki Pendek LED Merah ➔ Lubang **GND** ESP32. |

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

### Fase 3: Pemrograman Firmware & RTOS (PIC: Irham)
- [x] Inisialisasi pembacaan UID dari sensor RFID.
- [x] Implementasi **FreeRTOS** (pemisahan *task* pembacaan sensor dan transmisi HTTP).
- [x] Penulisan algoritma enkripsi XOR pada data yang akan dikirim.
- [x] Setup koneksi WiFi dan mekanisme *Auto-Reconnect*.
### Dokumentasi:
<img width="1134" height="1004" alt="Screenshot 2026-06-22 190750" src="https://github.com/user-attachments/assets/651121e1-8d16-4aa9-93ee-6d93ef8e8158" />
<img width="1115" height="994" alt="Screenshot 2026-06-22 190804" src="https://github.com/user-attachments/assets/6873e001-bf78-41fe-8cb1-e431edd363ed" />

### Fase 4: Pengembangan Web & Database (PIC: Arika)
- [x] Desain arsitektur *database* MySQL (Tabel `access_logs` dan `registered_cards`).
- [x] Pembuatan koneksi PDO PHP yang aman dari *SQL Injection*.
- [x] Pembuatan *endpoint* API (`api/access.php`) untuk menerima data dari ESP32.
- [x] Desain dan implementasi UI *Dashboard* pemantauan akses.
- [x] Pembuatan fitur manajemen kartu (*Add User* & *Toggle Access*).
### Dokumentasi:
<img width="1024" height="360" alt="Screenshot 2026-06-22 191247" src="https://github.com/user-attachments/assets/f5e5af2c-fac4-4750-b7c1-363d51d3cac3" />
<img width="1637" height="633" alt="Screenshot 2026-06-22 191201" src="https://github.com/user-attachments/assets/32683f1f-ba68-46c6-9194-25c18927da38" />
<img width="1286" height="964" alt="image" src="https://github.com/user-attachments/assets/84a84501-fc2f-4650-94e4-19895c298448" />
<img width="709" height="409" alt="image" src="https://github.com/user-attachments/assets/260d499c-a026-4eb0-93f9-6aed0ab9c51c" />

### Fase 5: Pengujian Sistem Terintegrasi
- [x] Uji coba kartu yang terdaftar (Akses Diterima & LED Hijau).
- [x] Uji coba kartu yang tidak terdaftar (Akses Ditolak & LED Merah).
- [x] Uji coba pemblokiran kartu melalui *dashboard* secara *real-time*.
### Dokumentasi:
https://github.com/user-attachments/assets/9cef2165-20d0-40ed-8dff-8fb5db186b6d






