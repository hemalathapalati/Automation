<?php
session_start();
include("config.php");
$user=$_SESSION['userid'];


if($user!='')
{
	 $sql = "SELECT bulb1,bulb2 FROM ha_status ORDER BY id DESC LIMIT 1";

											$result = mysqli_query($conn, $sql);

											if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $bulb1= $row["bulb1"];
    $bulb2=$row["bulb2"];
  }
}


?>



 <!DOCTYPE html>
 <html>
 <head>
 <title>Home Automation</title>

 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>

	<!-- Latest compiled JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Staatliches|Montserrat" rel="stylesheet">

	<script src="https://kit.fontawesome.com/63fedb50a7.js" crossorigin="anonymous"></script>

<style>
		html, body{
			font-family: 'Montserrat', sans-serif, 'Staatliches', cursive;
			font-size: 1.0em;

			
		}

		.container {
			background: #fff;
		}

		

		.box {
			border: 1px solid #ccc;
			min-height: 350px !important;
			border-radius: 4px;
			margin-bottom: 10px;
			position: relative;
		}
		.box .box_heading{
			font-family: 'Staatliches', cursive;
		}
		.innerBox {
			margin: 30px 0px 0 0;
			padding: 30px 3px;
			border: 2px solid #ccc;
			font-family: 'Open Sans', sans-serif;
		}
		footer {
			position: absolute;
			width: 100%;
			bottom: 0px;
		}
		 .switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(55px);
  -ms-transform: translateX(55px);
  transform: translateX(55px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;}
  body {
        /*color: #999;*/
		background: #4ABA70;
		font-family: 'Varela Round', sans-serif;
	}
	</style>



 </head>

 <body>
 	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><i class="fas fa-home ">&nbsp;</i>Home Automation</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/ha/index.php">Home</a></li>
      
    </ul>
    <ul class="nav navbar-nav navbar-right">
    	<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $user;?>  <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/ha/logout.php">Log out</a></li>
          
        </ul>
      </li>
      
    </ul>
  </div>
</nav>
  <div class="container">
  					<div class="row">
			<div class="col-md-12 well well-sm text-center" style="background-color: #4ABA70;">
				

				<h1 style="font-weight: bold;color:#ffff;"><i class="fas fa-home fa-2x"></i>HOME AUTOMATION</h1>
				
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="col-md-6">
					
					<div class="box">
						<h3 class="box_heading text-center">
										<i class="fas fa-lightbulb" style="color: #F5AC1F"></i> Device- I
									</h3>
							<div class="col-md-6 text-center">
									<h3 class="box_heading">
										Switch
									</h3>

									<div style="margin-top:60px;">

										
										<label class="switch"><input type="checkbox" id="togBtn1"<?php echo ($bulb1=="on" ? 'checked' : '');?>><div class="slider round"><!--ADDED HTML --><span class="on">ON</span><span class="off">OFF</span><!--END--></div></label>

										
									</div>
							</div>
							<div class="col-md-6 text-center">
								<h3 class="box_heading">
									Status
								</h3>

								<div>
                                  <?php 

                                  	 $sql = "SELECT bulb1 FROM ha_status ORDER BY id DESC LIMIT 1";

											$result = mysqli_query($conn, $sql);

											if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $bulb1= $row["bulb1"];
  }
} 


//mysqli_close($conn);


										


                                  ?>
									
									<img src="/ha/<?php echo $bulb1?>.png" alt="bulb-off" id="bulb" />

									
								</div>
							</div>
						</div>
				
			</div>
				<div class="col-md-6">
					
					<div class="box">
						<h3 class="box_heading text-center">
										<i class="fas fa-lightbulb" style="color: #F5AC1F"></i> Device- II
									</h3>
							<div class="col-md-6 text-center">
									<h3 class="box_heading">
										Switch
									</h3>

									<div style="margin-top:60px;">

										
										<label class="switch"><input type="checkbox" id="togBtn2" <?php echo ($bulb2=="on" ? 'checked' : '');?>><div class="slider round"><!--ADDED HTML --><span class="on">ON</span><span class="off">OFF</span><!--END--></div></label>

										
									</div>
							</div>
							<div class="col-md-6 text-center">
								<h3 class="box_heading">
									Status
								</h3>

								<div>
									<?php 

                                  	 $sql1 = "SELECT bulb2 FROM ha_status ORDER BY id DESC LIMIT 1";

											$result = mysqli_query($conn, $sql1);

											if (mysqli_num_rows($result) > 0) {
  // output data of each row
  										while($row = mysqli_fetch_assoc($result)) {
    											$bulb2= $row["bulb2"];
  												}
											} 

											//mysqli_close($conn);
											//

										


                                  ?>

									
									<img src="/ha/<?php echo $bulb2;?>.png" alt="bulb-off" id="bulb" />

									
								</div>
							</div>
						</div>
				
			</div>
		</div>

		</div>


 <div class="footer text-center">
			<div class="row" style="padding: 10px ">
				&copy;2020 Made by Vamsi with Help of
				<img src="https://technicalhub.io/img/logo_header.png" width="68" />
			</div>
		</div>
	</div>

  </div>

 


	<script>
		

		var wsbroker = "3.84.236.93";  //mqtt websocket enabled broker
		var wsport = 3033; // port for above
		    
		var client = new Paho.MQTT.Client(wsbroker, wsport,
		        "myclientid_" + parseInt(Math.random() * 100, 10));
		    
		    client.onConnectionLost = function (responseObject) {
		      console.log("connection lost: " + responseObject.errorMessage);
		};

		//alert($("#flip-1").val());	
		var switchStatus1 = false;
		var switchStatus2 = false;
$("#togBtn1").on('change', function() {
    if ($(this).is(':checked')) {
        switchStatus1 = $(this).is(':checked');

        //alert(switchStatus);// To verify
       pmessage="1";
    message=new Paho.MQTT.Message(pmessage);
    message.destinationName = "bulb1";
    message.qos = 0;

    client.send(message);
    }
    else {
       switchStatus1 = $(this).is(':checked');
       //alert(switchStatus);// To verify
       pmessage="0";
    message=new Paho.MQTT.Message(pmessage);
    message.destinationName = "bulb1";
    message.qos = 0;

    client.send(message);
    }

}); 

$("#togBtn2").on('change', function() {
    if ($(this).is(':checked')) {
        switchStatus2 = $(this).is(':checked');
        //alert(switchStatus);// To verify
       pmessage="1";
    message=new Paho.MQTT.Message(pmessage);
    message.destinationName = "bulb2";
    message.qos = 0;

    client.send(message);
    }
    else {
       switchStatus2 = $(this).is(':checked');
       //alert(switchStatus);// To verify
       pmessage="0";
    message=new Paho.MQTT.Message(pmessage);
    message.destinationName = "bulb2";
    message.qos = 0;

    client.send(message);
    }

}); 


				    
		var options = {
			timeout: 3,
			onSuccess: function () {
				console.log("mqtt connected");			       
			        // Connection succeeded; subscribe to our topic, you can add multile lines of these		        
			        //client.subscribe('bulb-resp');
			        


			},

			onFailure: function (message) {
			 	console.log("Connection failed: " + message.errorMessage);
			}
		};

		$(document).ready(function(){

			 	client.onMessageArrived = function (message) {
				    	console.log(message.destinationName, ' -- ', message.payloadString);
				      	var obj = parseInt(message.payloadString);
						
						if (message.destinationName == "bulb-resp"){
							if(obj==1)
							{
									document.getElementById("bulb").src="/Users/user/Desktop/on.png";
							}
							else
							{
								document.getElementById("bulb").src="/Users/user/Desktop/off.png";
							}
							
										

						}				      	


				      	
				     
				};


				/*******************************
				********************************
					  Smart Bin Live Graph
				********************************
				*******************************/

			   


				/*******************************
				********************************
						Water Tank
				********************************
				*******************************/

			    
		
			client.connect(options);

			
		});

	</script>

 </body>




 </html>
<?php 
}
 ?>