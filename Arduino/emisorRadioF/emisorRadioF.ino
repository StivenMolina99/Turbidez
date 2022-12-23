#include <RH_ASK.h>
#include <SPI.h>

float valorCorriente=0.0;
float R=250;
float turbidez=0;
String corriente="";

String dato;
String cadena;
String line;

int ID_TARJ=1; // Este dato identificará cual es la tarjeta que envía los datos, tener en cuenta que se tendrá más de una tarjeta. 
              // Se debe cambiar el dato (a 2,3,4...) cuando se grabe el programa en las demás tarjetas.
RH_ASK rf_driver;   // crea objeto para modulacion por ASK
 
void setup() {
  Serial.begin(9600);
  rf_driver.init();   // inicializa objeto con valores por defecto
}
 
void loop() {
  unsigned long currentMillis = millis();
    // puntero de mensaje a emitir

  for(int i=1; i<=20; i++){
    valorCorriente =(float) analogRead(A0)*(5/1023.0)/R+valorCorriente;
  }

  valorCorriente = valorCorriente*1000/20;
  turbidez = (277.8*valorCorriente)-944.84;
  cadena = String(turbidez);
  //cadena = String(valorCorriente);
  
  const char* msg = const_cast<char*>(cadena.c_str());
  //const char* msg = const_cast<char*>(cadena.c_str());

  rf_driver.send((uint8_t *)msg, strlen(msg));// funcion para envio del mensaje
  rf_driver.waitPacketSent();     // espera al envio correcto
  Serial.print("Se ha enviado la información "+cadena);
  delay(10000);        // demora de 1 segundo entre envios
  
  valorCorriente = 0.0;    
 
}
