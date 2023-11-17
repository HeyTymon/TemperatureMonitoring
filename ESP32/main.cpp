#include <Adafruit_BME280.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <Adafruit_SSD1306.h>
#include <WiFi.h>
#include <Arduino.h>
#include <ESPAsyncWebServer.h>
#include <HTTPClient.h>

const char* ssid = "Korbank-internet-df13_2.4GHz";
const char* password = "15caa495";

IPAddress staticIP(172, 16, 1, 56);
IPAddress gateway(172, 16, 1, 1);
IPAddress subnet(255, 255, 255, 0);

Adafruit_SSD1306 display(128, 64, &Wire, -1);
Adafruit_BME280 bme;

String URL = "http://172.16.1.115/inzynierka/sendMeasure.php";
String URL2 = "http://172.16.1.115/inzynierka/checkNameAndIP.php";

String URLRP = "http://172.16.1.130/sendMeasure.php";
String URLRP2 = "http://172.16.1.130/checkNameAndIP.php";

void displayNewTemperature(int timeDelay);
void displayNewHumidity(int timeDelay);
bool checkNameAndIP(void);
void sendData(void);

void setup() {
  Serial.begin(115200);

  pinMode(32, OUTPUT);
  digitalWrite(32, LOW);
  pinMode(33, INPUT_PULLUP);

  // Wifi
  WiFi.config(staticIP, gateway, subnet);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to the WiFi network" + WiFi.localIP().toString());

  // BME280
  if (!bme.begin(0x76)) {
    Serial.println("Could not find a valid BME280 sensor, check wiring!");
    while(1);
  }

  // OLED
  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {
    Serial.println(F("SSD1306 allocation failed"));
    while(1);
  }

  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 0);
  display.print(WiFi.localIP().toString());

  delay(2000);
  display.display();
  delay(2000);
  display.clearDisplay();

  if (!checkNameAndIP()) {
    Serial.println("Name or IP is not correct!");
    while(1) {
      Serial.println("Restart the sensor!");
    }
  }
}

void loop() {
  digitalWrite(32, HIGH);
  displayNewTemperature(0);
  displayNewHumidity(5000);

  sendData();

  digitalWrite(32, LOW);
  delay(60000);
}

void displayNewTemperature(int timeDelay) {
  display.clearDisplay();

  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 0);
  display.print("Temp: ");
  display.print(bme.readTemperature());
  display.print(" C");

  display.display();

  delay(timeDelay);
}

void displayNewHumidity(int timeDelay) {
  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 10);
  display.print("Humidity: ");
  display.print(bme.readHumidity());
  display.print(" %");

  display.display();

  delay(timeDelay);
}

bool checkNameAndIP() {
  String data = "name=Sensor56&ip=" + WiFi.localIP().toString();
  Serial.println(data);
  HTTPClient http;
  http.begin(URL2);

  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(data);
  String payload = http.getString();
  Serial.println(httpCode);
  Serial.println(payload);

  return payload == "present"; 
}

void sendData(void) {
  String data = "temperature=" + String(bme.readTemperature()) + "&humidity=" + String(bme.readHumidity()) + "&sensorName=Sensor56";
  HTTPClient http;
  http.begin(URL);

  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(data);
  String payload = http.getString();

  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);
  display.setCursor(0, 20);
  display.print("HTTP Code: ");
  display.print(httpCode);

  display.display();

  Serial.println(URL);
  Serial.println(data);
  Serial.println(httpCode);
  Serial.println(payload);
  delay(100);  
  http.end();
}
