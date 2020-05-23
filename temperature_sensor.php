<?php

function temp_rasberry(){
    $f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
    $temp = floatval(fgets($f));
    fclose($f);

    return  round($temp/1000,2);
    }


function temp_czujnik(){
	exec('modprobe w1-gpio');
	exec('modprobe w1-therm');

	$base_dir = '/sys/bus/w1/devices/';
	$device_folder = glob($base_dir . '28*')[0];
	$device_file = $device_folder . '/w1_slave';

	$data = file($device_file, FILE_IGNORE_NEW_LINES);

	$temperature = null;
	if (preg_match('/YES$/', $data[0])) {
		if (preg_match('/t=(\d+)$/', $data[1], $matches, PREG_OFFSET_CAPTURE)) {
			$temperature = $matches[1][0] / 1000;
			$temperature = round($temperature,1);
		}
}
	return $temperature;
}

  $temperature= temp_czujnik();
  echo '<div style="font-family:Arial;color:#aaaaaa;background-color:#e5e5e5;padding:2px;text-align:center;">';
  echo '<p> aktualna temperatura </p>';
  echo " <h1> ${temperature}C\n </h1>";

  $temperature= temp_rasberry();
  echo '<p> temperatura servera raspi </p>';
  echo " <h1> ${temperature}C\n </h1>";


  echo "<p> aktualna data/czas";
  $now = date_create('now')->format('Y-m-d H:i:s');
  echo " <h3> ${now} </h3>";
  echo '</div>';

// zapisanie temperatury do csv
if(isset($_GET['action']))
{
  $action = htmlspecialchars($_GET["action"]);



  if ($action=="write_temp_ds")
  {
    $file="temp_garden_raspi.csv";
    $file= '/var/www/html/data/'. $file;

    $value=temp_czujnik();
    $now = date_create('now')->format('Y-m-d H:i:s');
    $line= strval($now . ',' . $value);

    $list = array (
                array($now, strval($value))
                  );

    $fp = fopen($file,"a");
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
  }

}

?>
