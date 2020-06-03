#include<ESP8266WiFi.h>

const char *ssid ="psshvamsi";
const char *pswd ="12345678";

WiFiClient espclient;

  
void setup() 
{
  Serial.begin(9600);
  WiFi.begin(ssid,pswd);
  while(WiFi.status()!=WL_CONNECTED)
    {
      Serial.print("...");
      delay(200);
    }  
    Serial.println("\n WIFI CONNECTED");
    Serial.println(WiFi.localIP());
    
}

void loop() 
{
}
