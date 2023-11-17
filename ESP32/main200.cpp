#include <Arduino.h>
#include <WiFi.h>
#include <AsyncTCP.h>
#include <ESPAsyncWebServer.h>

const char* ssid = "Korbank-internet-df13_2.4GHz";
const char* password = "15caa495";

IPAddress staticIP(172, 16, 1, 200);
IPAddress gateway(172, 16, 1, 1);
IPAddress subnet(255, 255, 255, 0);

AsyncWebServer server(80);

void setup() {
  Serial.begin(115200);
  Serial.println("Serial test");

  WiFi.config(staticIP, gateway, subnet);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to the WiFi network" + WiFi.localIP().toString());


  server.on("/reciveTemp", HTTP_POST, [](AsyncWebServerRequest *request){
    if (request->hasParam("temp", true)) {
      String temperature = request->getParam("temp", true)->value();
      Serial.print("Received temperature: ");
      Serial.println(temperature);

      String response = "Temperature received by ESP32. Acknowledgement sent.";
      request->send(200, "text/plain", response);
    } else {
      request->send(400, "text/plain", "Bad Request");
    }
  });

  server.begin();
}

void loop() {
  Serial.println("Loop test"); //Add PWM controll
  delay(5000);
}
