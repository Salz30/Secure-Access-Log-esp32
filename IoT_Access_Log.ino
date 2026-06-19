#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

// ================= KONFIGURASI PIN =================
#define SS_PIN 5
#define RST_PIN 13
#define LED_HIJAU 14
#define LED_MERAH 27

MFRC522 mfrc522(SS_PIN, RST_PIN);

const char* ssid = "Salz";
const char* password = "Bagidong30";
const char* serverName = "http://10.241.40.40/PW1/iot_project/api/access.php"; 
const char* SECRET_KEY = "Salman_aja_3011";

// Gunakan Struct + Char Array agar aman dari Memory Leak di FreeRTOS
typedef struct {
  char uid[20];
} RFIDData;

QueueHandle_t rfidQueue;

String encryptUID(String uid) {
  String encryptedHex = "";
  int keyLen = String(SECRET_KEY).length();
  for (int i = 0; i < uid.length(); i++) {
    char xorChar = uid[i] ^ SECRET_KEY[i % keyLen];
    if (xorChar < 16) encryptedHex += "0";
    encryptedHex += String(xorChar, HEX);
  }
  return encryptedHex;
}

void TaskReadRFID(void *pvParameters) {
  SPI.begin();
  mfrc522.PCD_Init();
  
  for (;;) {
    if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
      String uidString = "";
      for (byte i = 0; i < mfrc522.uid.size; i++) {
        uidString += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
        uidString += String(mfrc522.uid.uidByte[i], HEX);
      }
      uidString.toUpperCase();
      Serial.println("Kartu Terdeteksi: " + uidString);
      
      // Mengemas data secara aman
      RFIDData dataToSend;
      strcpy(dataToSend.uid, uidString.c_str());
      
      xQueueSend(rfidQueue, &dataToSend, portMAX_DELAY);
      vTaskDelay(1500 / portTICK_PERIOD_MS); 
    }
    vTaskDelay(50 / portTICK_PERIOD_MS); 
  }
}

void TaskSendNetwork(void *pvParameters) {
  RFIDData receivedData;
  for (;;) {
    if (xQueueReceive(rfidQueue, &receivedData, portMAX_DELAY)) {
      
      // Auto-Reconnect WiFi jika terputus
      if (WiFi.status() != WL_CONNECTED) {
        Serial.println("Koneksi terputus. Mencoba reconnect...");
        WiFi.disconnect();
        WiFi.begin(ssid, password);
        int retryCount = 0;
        while (WiFi.status() != WL_CONNECTED && retryCount < 10) {
          vTaskDelay(500 / portTICK_PERIOD_MS);
          retryCount++;
        }
      }

      if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin(serverName);
        http.addHeader("Content-Type", "application/json");
        http.setTimeout(10000); 

        String receivedUIDString = String(receivedData.uid);
        String encryptedData = encryptUID(receivedUIDString);
        String httpRequestData = "{\"uid_encrypted\":\"" + encryptedData + "\"}";
        
        int httpResponseCode = http.POST(httpRequestData);
        
        if (httpResponseCode > 0) {
          String payload = http.getString();
          Serial.println("Response: " + payload);
          
          // Membaca isi payload spesifik, bukan sekadar status code
          if (httpResponseCode == 200 && payload.indexOf("\"status\":\"DITERIMA\"") > 0) {
            digitalWrite(LED_HIJAU, HIGH);
            vTaskDelay(2000 / portTICK_PERIOD_MS);
            digitalWrite(LED_HIJAU, LOW);
          } else {
            digitalWrite(LED_MERAH, HIGH);
            vTaskDelay(2000 / portTICK_PERIOD_MS);
            digitalWrite(LED_MERAH, LOW);
          }
        } else {
          Serial.print("Error code: "); Serial.println(httpResponseCode);
          digitalWrite(LED_MERAH, HIGH);
          vTaskDelay(500 / portTICK_PERIOD_MS);
          digitalWrite(LED_MERAH, LOW);
        }
        http.end();
      }
    }
  }
}

void setup() {
  Serial.begin(115200);
  pinMode(LED_HIJAU, OUTPUT);
  pinMode(LED_MERAH, OUTPUT);
  digitalWrite(LED_HIJAU, LOW);
  digitalWrite(LED_MERAH, LOW);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) { delay(500); }
  Serial.println("\nTerhubung ke WiFi!");

  rfidQueue = xQueueCreate(5, sizeof(RFIDData));
  xTaskCreatePinnedToCore(TaskReadRFID, "ReadRFID", 4096, NULL, 2, NULL, 1);
  xTaskCreatePinnedToCore(TaskSendNetwork, "SendNet", 8192, NULL, 1, NULL, 0);
}

void loop() {}