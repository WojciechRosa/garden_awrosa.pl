<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>

<style>
body {
  color: green;
  background-color: #FFFFF0;
  width: device-width;
}
</style>


<title>Ogród Ania i Wojtek</title>


</head>

    <body>


    <h1> Ogród Sterowanie </h1>

<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);


// Ustawienia zmienneych globalnych 
$gpio_pump = 17;
$gpio_water_max_test = 2;
$gpio_water_test = 3;
$gpio_main_switch = 5;

$gpio_zawor_trawaAltana = 22;
$gpio_zawor_trawaFront = 13;
$gpio_rododendrony = 19;
$gpio_warzywa = 26;
$gpio_linia_taras = 6;
$gpio_linia_tyl= 5;

//Funkcje pomocnicze


echo date("Y-m-d H:i:s");
echo '<br><br>';

function set_pin($pin, $status)
    {
    $cmd1= 'gpio -g mode '. $pin .' out'  ;     
    $cmd2 = 'gpio -g write ' . $pin . " " . $status;
    exec ($cmd1);
    exec ($cmd2);
    }

function change_pin($pin)
    {
    if (read_pin($pin)==1) {$status=0;} else {$status=1;}
    set_pin($pin,$status);
    }

function read_pin($pin)
    {   
    $cmd = 'gpio -g read ' . $pin;
    return exec ($cmd);
    }

function ifWater(){
    global $gpio_water_test;
    if (read_pin($gpio_water_test)==1) {$ret=true;} else {$ret=false;};
    return $ret;
    }
function ifAnyOpen()
{
    global $gpio_zawor_trawaAltana;
    global $gpio_zawor_trawaFront;
    global $gpio_rododendrony;
    global $gpio_linia_taras;

    $test=0;
    $test=read_pin($gpio_zawor_trawaFront) ;
    $test=$test+read_pin($gpio_zawor_trawaAltana);
    $test=$test+read_pin($gpio_rododendrony);
    $test=$test+read_pin($gpio_linia_taras);
    $test=4-$test;
    return $test;
    
}

function stopAll()
{
    global $gpio_pump;
    global $gpio_zawor_trawaAltana;
    global $gpio_zawor_trawaFront;
    global $gpio_rododendrony;
    global $gpio_linia_taras;

    set_pin($gpio_pump, 1);
    set_pin($gpio_zawor_trawaAltana, 1);
    set_pin($gpio_zawor_trawaFront, 1);
    set_pin($gpio_rododendrony, 1);
    set_pin($gpio_linia_taras, 1);
    //set_pin($gpio_zawor_trawaAltana, 1);
    //set_pin($gpio_zawor_trawaFront, 1);


}


function pompaStart()
{
    global $gpio_pump;
    set_pin($gpio_pump, 0);
}
function pompaStop()
{
    global $gpio_pump;
    set_pin($gpio_pump, 1); 
}
function pompaStartStop()
{   
    if (ifWater()<>1)
        {
            if (ifAnyOpen()==0) {pompaStop(); } else {pompaStart();};}
    else    {
        //stop all brak wody
        //pompaStop();
        stopAll();
    }
}


function pompaStatus()
{
    global $gpio_zawor_trawaAltana;
    global $gpio_pump;
    global $gpio_zawor_trawaFront;
    global $gpio_rododendrony;
    global $gpio_water_max_test;
    global $gpio_linia_taras;

echo '<table witdth=100%>';
echo '<tr>  <th >sekcja</th>  <th >action</th> <th>status</th>   </tr> ';
    // woda
    echo '<tr>   <td > WODA STATUS </td> ';
    echo ' <td> </td>';
    echo '<td>';
    if ( ifWater()<>1 )
    {echo "JEST WODA ";} else {echo "BRAK WODY";}
    echo '</td></tr>';
 
    // woda  max
    echo '<tr>   <td > WODA MAKSIMUM </td> ';
    echo ' <td> </td>';
    echo '<td>';
    if ( read_pin($gpio_water_max_test)<>1 )
    {echo "JEST MAX WODA ";} else {echo "PONIŻEJ MAXa";}
    echo '</td></tr>';
    // pompa
    
    echo '<tr>   <td > POMPA PRACA</td> ';
    echo ' <td> </td>';
    echo '<td>';
    if ( read_pin($gpio_pump)<>1 )
    {echo "DZIAŁA";} else {echo "NIE DZIAŁA";}
    echo '</td></tr>';

    echo '<tr> <td> / </td>  </tr>';
    echo '<tr>  </tr>';

    // strefa 
    echo '<tr>   <td > trawa przód domu </td>';
    echo '<td> <form method="post"> <input type="submit" value="zmień" name="zmiana_gpio_zawor_trawaFront" /> </form> </td>"';
    echo '<td>';
    if (read_pin($gpio_zawor_trawaFront)<>1 )
    {echo "OTWARTE";} else {echo "ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa 
    echo '<tr>   <td > trawa przód altana </td>  ';
    echo '<td> <form method="post"> <input type="submit" value="zmień" name="gpio_zawor_trawaAltana" /> </form> </td>"';
    echo '<td>';   
    if (read_pin($gpio_zawor_trawaAltana)<>1 )
    {echo "OTWARTE";} else {echo "ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa 
    echo '<tr>   <td > rododendrony i wisterie </td>  ';
    echo '<td> <form method="post"> <input type="submit" value="zmień" name="gpio_rododendrony" /> </form> </td>"';
    echo '<td>';   
    if (read_pin($gpio_rododendrony)<>1 )
    {echo "OTWARTE";} else {echo "ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa  linia taras
    echo '<tr>   <td > linia kroplująca taras </td>  ';
    echo '<td> <form method="post"> <input type="submit" value="zmień" name="gpio_linia_taras" /> </form> </td>"';
    echo '<td>';   
    if (read_pin($gpio_linia_taras)<>1 )
    {echo "OTWARTE";} else {echo "ZAMKNIĘTE";}
    echo '</td></tr>';


echo '/<table>';

echo '<br>';
echo "ilość otwartych sekcji: " . ifAnyOpen();
echo '<br>';
echo 'temperatura serwera raspbery: ' . temp_rasberry();
}


# ---------------------------------------------------------------
#temperatury

function temp_rasberry()
{   $f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
    $temp = floatval(fgets($f));
    fclose($f);

    return  round($temp/1000,2);
    }


# ---------------------------------------------------------------



if(isset($_POST['zmiana_gpio_zawor_trawaFront']))
{
     change_pin($gpio_zawor_trawaFront);  
     pompaStartStop();
}

if(isset($_POST['gpio_zawor_trawaAltana']))
{
     change_pin($gpio_zawor_trawaAltana);  
     pompaStartStop();
}

if(isset($_POST['gpio_rododendrony']))
{
     change_pin($gpio_rododendrony);  
     pompaStartStop();
}

if(isset($_POST['gpio_linia_taras']))
{
     change_pin($gpio_linia_taras);  
     pompaStartStop();
}

if(isset($_POST['action_stop_all']))
{
    stopAll();
}


if(isset($_POST['status']))
{pompaStatus();}
else
{pompaStatus();}





?>

<br>
<form method="post">
    <input type="submit" name="action_stop_all" value="STOP ALL"  />  ____
    <input type="submit" name="status" value="STATUS"  />
</form>
<br>
<br>
<iframe width="350" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/apps/plugins/344851"></iframe>
<br>
 
<br>
<iframe width="425" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1051650/charts/1?bgcolor=%23ffffff&color=%23d62020&days=2&dynamic=true&results=60&type=line"></iframe>


</body>
