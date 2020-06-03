#include <ArduinoJson.h>


#include<ESP8266WiFi.h>
#include<PubSubClient.h>


char data[100];

#define CLIENT_ID "homeauto"
#define port 1883

const char *ssid ="vivo 1915";
const char *pswd ="prasanna2";
const char *mqtt_Server="3.225.246.87";

WiFiClient espclient;
PubSubClient client(espclient);

String bulb1_st,bulb2_st;


  
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
    Serial.println(ssid);
    Serial.println(WiFi.localIP());
    client.setServer(mqtt_Server,1883);
    client.subscribe("bulb1");
    client.subscribe("bulb2");
    client.setCallback(callback);
    pinMode(16,OUTPUT);
    pinMode(5,OUTPUT);
}

void reconnect()
  {
    while(!client.connected())
      {
      Serial.print("Attempting MQTT connection...");
      
    if(client.connect(CLIENT_ID))
      {
      Serial.println("connected");
      client.subscribe("bulb1");
      client.subscribe("bulb2");
      }  
      } 
  }
void callback(char* topic, byte* payload, unsigned int length) 
 {
  StaticJsonDocument<300> Doc;
  //JSONencoder = JSONbuffer.createObject():
  Doc["device"] = "ESP8266";
  Doc["Type"] = "bulbstatus";
  JsonArray values = Doc.createNestedArray("values");
   
  Serial.println("\nMessage arrived");
  Serial.print(topic);
  String mytopic=String(topic);
  
  for (int i = 0; i < length; i++) 
   {
    Serial.print((char)payload[i]);
   }

   if(mytopic=="bulb1")
   {   
   if((char)payload[0]=='1')
    {
    digitalWrite(16,LOW);
    bulb1_st="on";
    }
   else
   {
    digitalWrite(16,HIGH);
    bulb1_st="off";
    } 
   }
   if(mytopic=="bulb2")
   {   
   if((char)payload[0]=='1')
    {
    digitalWrite(5,LOW);
    bulb2_st="on";
    }
   else
   {
    digitalWrite(5,HIGH);
    bulb2_st="off";
    } 
   }
   values.add(bulb1_st);
   values.add(bulb2_st);
   serializeJson(Doc, data);
   //Doc.printTo(data,sizeof(data));
   //String  msg="{\"bulb1\":\""+bulb1_st+"\",\"bulb2\";\""+bulb2_st+"\"}";
   //msg.toCharArray(data,100);
   client.publish("status",data);
   Serial.println(data);
   
   
 }
  
void loop() 
{
  if(!client.connected())
    {
      reconnect();
    }
  client.loop();
}
