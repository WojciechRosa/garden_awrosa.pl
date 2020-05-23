<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);


$field_name = htmlspecialchars($_GET["field_name"]);
$value = htmlspecialchars($_GET["value"]);

// wybór pliku dozapisania danych

if ($field_name=="temp"){$file='temp_garden_2.csv';}
elseif ($field_name=='soil_humidity'){$file='soil_humidity.csv';}
elseif ($field_name=='humidity'){$file='humidity_garden.csv';}
//    $file=('humidity.php');
else{    exit ('błąd nazwy pola wejściowego'); }


//sprawdzenie czy dane są numeryczne

if (is_numeric($value)) {
// zapisanie danych do pliku csv


$file= '/var/www/html/data/'. $file;

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

echo "zapisano:  " . $line;

}
else
{exit ('błąd wartości pola wejściowego');}
?>
