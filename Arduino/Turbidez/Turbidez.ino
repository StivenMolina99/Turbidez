#include <ESP8266HTTPClient.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>


float valorCorriente=0.0;
float R=250;
float turbidez=0;
String corriente="";
//const char* ssid     = "iPhone de kevin";      // SSID
//const char* password = "12345678";      // Password

//const char* ssid     = "TP-LINK_DE16";      // SSID
//const char* password = "67743667";      // Password

const char* ssid     = "FLIA_CORREA";      // SSID
const char* password = "Yeico1213@#";      // Password

//const char* ssid     = "WAVLINK-N";      // SSID
//const char* password = "12345678";      // Password

const char* host = "192.168.0.21";  // Dirección IP local o remota, del Servidor Web
const int   port = 80;            // Puerto, HTTP es 80 por defecto, cambiar si es necesario.
const int   watchdog = 2000;        // Frecuencia del Watchdog
unsigned long previousMillis = millis();

String dato;
String cade;
String line;

int gpio5_pin = 5; // El GPIO5 de la tarjeta ESP32, corresponde al pin D5 identificado físicamente en la tarjeta. Este pin será utilizado para una salida de un LED.
int ID_TARJ=1; // Este dato identificará cual es la tarjeta que envía los datos, tener en cuenta que se tendrá más de una tarjeta. 
              // Se debe cambiar el dato (a 2,3,4...) cuando se grabe el programa en las demás tarjetas.

 
void setup() {
  pinMode(gpio5_pin, OUTPUT);
  Serial.begin(115200);
  Serial.print("Conectando a...");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
 
  Serial.println("");
  Serial.println("WiFi conectado");  
  Serial.println("Dirección IP: ");
  Serial.println(WiFi.localIP());
}
 
void loop() {
  unsigned long currentMillis = millis();

  digitalWrite(gpio5_pin, LOW);
  for(int i=1; i<=20; i++){
    valorCorriente=(float) analogRead(A0)*(5/1023.0)/R+valorCorriente;
  }

  valorCorriente=valorCorriente*1000/20;

  turbidez=((4000/15)*valorCorriente)-(4000/3);
  

  
  if (WiFi.status() == WL_CONNECTED){ 
     HTTPClient http;  // creo el objeto http
     WiFiClient client;
     String datos_a_enviar = "sensorTurbidez=" + String(turbidez) + "&ID_TARJ=" + ID_TARJ;  

     http.begin(client, "http://turbidezlab4.online/datos_sensor.php");
     http.addHeader("Content-Type", "application/x-www-form-urlencoded");// defino texto plano..

     int codigo_respuesta = http.POST(datos_a_enviar);

     if (codigo_respuesta>0){
      Serial.println("Código HTTP: "+ String(codigo_respuesta));
        if (codigo_respuesta == 200){
          String cuerpo_respuesta = http.getString();
          Serial.println("El servidor respondió: ");
          Serial.println(cuerpo_respuesta);
        }
     } else {
        Serial.print("Error enviado POST, código: ");
        Serial.println(codigo_respuesta);
     }
     
      digitalWrite(gpio5_pin, HIGH);
      //Serial.println("Dato ENVIADO");
      //Serial.println(corriente);
      valorCorriente = 0.0;
      delay(20000);
      
       http.end();  // libero recursos
       
  } else {
     Serial.println("Error en la conexion WIFI");
  }
  //delay(1000); //espera 60s
 
}
