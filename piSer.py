import serial
import thread
import time
import requests
from uuid import getnode as get_mac

send=False
 
def activate():
	global send
	print "Start Catching"
	send = True
	time.sleep(6)
	print "End Catching"
	send = False
	time.sleep(30)
	thread.start_new_thread(activate,())

def getVal():
	userdata = {"idDispositivo": 123456789}
	resp = requests.post('http://192.168.1.102/Appapacho/WebServices/wsPromedioMedicion.php', params=userdata)
	return resp.text

def sendValue(val):
	userdata = {"idDispositivo": 123456789, "idTipoMedicion": 1, "Valor": val}
	try:
		resp = requests.post('http://192.168.1.102/Appapacho/WebServices/wsInsertMedicion.php', params=userdata)

	except:
		print "Ocurrio un error al momento de conectar"
	print resp.text

arduino = serial.Serial('/dev/ttyACM0', 9600)
 
print("Starting!")

try:
	thread.start_new_thread(activate,())
except:
	print "Error D:"
arduino.flushInput();

while True:
	val = arduino.readline();
	#val = raw_input("Escribe algo \n")
	print "La temperatura es: ", val
	prom=float(getVal())
	print prom
	if(prom>38):
		print "Temperatura muy alta."
	elif(prom<30):
		print "Temperatura muy baja."
	if(send):
		sendValue(val)

 
arduino.close() #Finalizamos la comunicacion