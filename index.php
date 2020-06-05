<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>


<style>
* {
  box-sizing: border-box;
}
.menu {
  float:left;
  width:20%;
  text-align:center;
}
.menu a {
  background-color:#e5e5e5;
  padding:8px;
  margin-top:7px;
  display:block;
  width:100%;
  color:black;
}
.main {
  float:left;
  width:60%;
  padding:0 20px;
}
.right {
  background-color:#e5e5e5;
  float:left;
  width:20%;
  padding:15px;
  margin-top:7px;
  text-align:center;
}

@media only screen and (max-width:620px) {
  /* For mobile phones: */
  .menu, .main, .right {
    width:100%;
  }

}
  table.blueTable {
  border: 0px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 1px;
}


table.blueTable tbody td {
  font-size: 15px;
}

table.blueTable tbody td.green {
  font-size: 15px;
  background: #06DF2B;
  text-align: center;
}

table.blueTable tbody td.red {
  font-size: 15px;
  background: #DF2C2C;
  color: #FFFFFF;
  text-align: center;
}

table.blueTable tbody td.orange {
  font-size: 15px;
  background: #F7FF1A;
  color: #000000;
  text-align: center;
}

table.blueTable thead {
  background: #1C6EA4;
  text-align: center;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 3px solid #444444;
}
table.blueTable thead th {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  border-left: 0px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}


</style>
</head>
<body style="font-family:Verdana;color:#aaaaaa;">

<div style="color:#21bf23;background-color:#e5e5e5;padding:15px;text-align:center;">
  <h1> Ogród Ania i Wojtek </h1>
</div>

<div style="overflow:auto">
  <div class="menu">
    <a href="?id=1">Stacja Pogodowa</a>
    <a href="?id=2">Podlewanie</a>
	<a href="?id=3">Oświetlenie</a>
    <a href="#">Wilgotność Gleby</a>
    <a href="?id=9">testy</a>
  </div>

  <div class="main">

  	<?PHP
  		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
		  
		  
		if(empty($_GET['id'])):
			$id=1;
		else:
			$id = htmlspecialchars($_GET["id"]);
		endif	;	
		
		
		if ( is_numeric($id)==false): {$id=1;} endif;
		
			
  		if ($id==1):
  		  include ('1_temperatura.php');
  		elseif ($id==2):
  		 include ('2_podlewanie.php');
  		elseif ($id==3):
  		 include ('3_oswietlenie.php');
      elseif ($id==9):
        include ('9_testy.php');
  		else:
  			echo 'błąd ';
  		endif;



  	?>

  </div>

  <div class="right">

    <p> <?php include("temperature_sensor.php");  ?></p>
  </div>
</div>

<div style="background-color:#e5e5e5;text-align:center;padding:10px;margin-top:7px;">© copyright wojciech rosa <br> 2020 version </div>

</body>
</html>
