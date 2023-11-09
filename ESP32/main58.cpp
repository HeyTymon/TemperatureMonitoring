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
IPAddress staticIP(172, 16, 1, 58);  
IPAddress gateway(172, 16, 1, 1);     
IPAddress subnet(255, 255, 255, 0);    

Adafruit_SSD1306 display(128, 64, &Wire, -1);
Adafruit_BME280 bme;
AsyncWebServer server(80);

String URL = "http://172.16.1.115/inzynierka/sendMeasure.php";

void displayNewTemperature(int timeDelay);
void displayNewHumidity(int timeDelay);
void sendData();

void setup() {
  Serial.begin(115200);

  pinMode(32, OUTPUT);
  digitalWrite(32, LOW);
  pinMode(33, INPUT_PULLUP);

  //Wifi
  WiFi.config(staticIP, gateway, subnet);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.print("Connected to WiFi. IP address: ");
  Serial.println(WiFi.localIP());


  //BME280
  if (!bme.begin(0x76)) {
    Serial.println("Could not find a valid BME280 sensor, check wiring!");
    while(1);
  }

  //OLED
  if(!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {
    Serial.println(F("SSD1306 allocation failed"));
    while(1);
  }

  display.display();
  delay(2000);
  display.clearDisplay();

  server.on("/", HTTP_GET, [](AsyncWebServerRequest *request){
    float temperature = bme.readTemperature();
    float humidity = bme.readHumidity();
    String html = "<html><body>";
    html += "<h1>Temperatura: " + String(temperature) + " &#8451;</h1>"; // Symbol stopni C
    html += "<h1>Wilgotnosc: " + String(humidity) + "%</h1>";
    html += "</body></html>";
    request->send(200, "text/html", html);
  });

  server.begin();
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

void sendData() {
  String data = "temperature=" + String(bme.readTemperature()) + "&humidity=" + String(bme.readHumidity()) + "&sensorName=Sensor56";
  HTTPClient http;
  http.begin(URL);

  http.addHeader("Content-Type", "application/x-www-form-urlencoded");  
  
  int httpCode = http.POST(data);
  String payload = http.getString();
 

  Serial.println(URL);
  Serial.println(data);
  Serial.println(httpCode);
  Serial.println(payload);
  http.end();
}