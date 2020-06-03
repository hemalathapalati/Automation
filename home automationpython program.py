import mysql.connector
from mysql.connector import Error
from datetime import datetime, timezone
from dateutil import tz
import paho.mqtt.client as mqtt
def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))

    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("temp-hum")
def on_message(client, userdata, msg):
    print("topic: "+msg.topic+" data: "+str(msg.payload))
    data=str(msg.payload)
    values=data.split("'")
    #print(values)
    value=values[1].split('+')
    print(value)
    data_add(value[0],value[1])
 
    

    #print(datetime.now().replace(tzinfo=timezone.utc).astimezone(tz=None))

def data_add(temp,hum):
    from_zone = tz.gettz('UTC')
    to_zone = tz.gettz('Asia/Kolkata')
    dt=str(datetime.now())
    # print(dt)
    #utc = datetime.strptime(str(datetime.now()), '%d-%m-%Y %H:%M:%S')
    utc = datetime.now().replace(tzinfo=from_zone)
    dt = utc.astimezone(to_zone)
    dt=str(dt)
    try:

        connection = mysql.connector.connect(host='localhost',
                                             database='weather',
                                             user='root',
                                             password='Iot@1234')
        cursor = connection.cursor()
        mySql_insert_query = "INSERT INTO temp_hum (temp, hum, dt) VALUES ('"+temp+"','"+hum+"','"+dt+"') "
        #recordTuple = (temp,hum,dt)
      
        cursor.execute(mySql_insert_query)
        connection.commit()
        print("Record inserted successfully into temp_hum table")

    except mysql.connector.Error as error:
        print("Failed to insert into MySQL table {}".format(error))
    finally:
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("MySQL connection is closed")




client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.connect("3.210.97.249", 1883, 60)

# Blocking call that processes network traffic, dispatches callbacks and
# handles reconnecting.
# Other loop*() functions are available that give a threaded interface and a
# manual interface.
client.loop_forever()
