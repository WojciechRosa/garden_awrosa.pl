
<div style='color:#000000'>

<?php


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
    global $gpio_warzywa;
    global $gpio_linia_tyl;

    $test=0;
    $test=read_pin($gpio_zawor_trawaFront) ;
    $test=$test+read_pin($gpio_zawor_trawaAltana);
    $test=$test+read_pin($gpio_rododendrony);
    $test=$test+read_pin($gpio_linia_taras);
    $test=$test+read_pin($gpio_warzywa);
    $test=$test+read_pin($gpio_linia_tyl);
    $test=6-$test;
    return $test;
    
}

function stopAll()
{
    global $gpio_pump;
    global $gpio_zawor_trawaAltana;
    global $gpio_zawor_trawaFront;
    global $gpio_rododendrony;
    global $gpio_linia_taras;
    global $gpio_warzywa;
    global $gpio_linia_tyl;

    set_pin($gpio_pump, 1);
    set_pin($gpio_zawor_trawaAltana, 1);
    set_pin($gpio_zawor_trawaFront, 1);
    set_pin($gpio_rododendrony, 1);
    set_pin($gpio_linia_taras, 1);
    set_pin($gpio_warzywa, 1);
    set_pin($gpio_linia_tyl, 1);
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
    global $gpio_warzywa;
    global $gpio_linia_tyl;


echo '<table class="blueTable">';
echo '<thead> <tr>  <th >sekcja</th>  <th >action</th> <th>status</th>   </tr> </thead> ';
    // woda
    echo '<tr>   <td > WODA STATUS </td> ';
    echo ' <td> </td>';
    if ( ifWater()<>1 )
    {echo "<td class='green'> JEST WODA ";} else {echo " <td class='red'> BRAK WODY";}
    echo '</td></tr>';
 
    // woda  max
    echo '<tr>   <td > WODA MAKSIMUM </td> ';
    echo ' <td> </td>';
    if ( read_pin($gpio_water_max_test)<>1 )
    {echo " <td class='green'> JEST MAX WODA ";} else {echo " <td class='orange'> PONIŻEJ MAXa";}
    echo '</td></tr>';
    // pompa
    
    echo '<tr>   <td > POMPA PRACA</td> ';
    echo ' <td> </td>';
    if ( read_pin($gpio_pump)<>1 )
    {echo "<td class='red'> DZIAŁA";} else {echo " <td class='green'> NIE DZIAŁA";}
    echo '</td></tr>';

    echo '<tr> <td>  </td>  </tr>';
    echo '<tr>  </tr>';

    // strefa 
    echo '<tr>   <td > trawa przód domu </td>';
    echo '<td align=center> <form method="post"> <input type="submit" value="zmień" name="zmiana_gpio_zawor_trawaFront" /> </form> </td>"';
    if (read_pin($gpio_zawor_trawaFront)<>1 )
    {echo "<td class='red'>OTWARTE";} else {echo "<td class='green'> ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa 
    echo '<tr>   <td > trawa przód altana </td>  ';
    echo '<td align=center> <form method="post"> <input type="submit" value="zmień" name="gpio_zawor_trawaAltana" /> </form> </td>"';

    if (read_pin($gpio_zawor_trawaAltana)<>1 )
    {echo "<td class='red'>OTWARTE";} else {echo " <td class='green'>ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa 
    echo '<tr>   <td > rododendrony i wisterie </td>  ';
    echo '<td align=center> <form method="post"> <input type="submit" value="zmień" name="gpio_rododendrony" /> </form> </td>"';
    if (read_pin($gpio_rododendrony)<>1 )
    {echo "<td class='red'>OTWARTE";} else {echo " <td class='green'>ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa  linia taras
    echo '<tr>   <td > linia kroplująca taras </td>  ';
    echo '<td align=center> <form method="post"> <input type="submit" value="zmień" name="gpio_linia_taras" /> </form> </td>"';
    if (read_pin($gpio_linia_taras)<>1 )
    {echo "<td class='red'>OTWARTE";} else {echo " <td class='green'> ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa 
    echo '<tr>   <td > linia kroplująca tuje </td>  ';
    echo '<td align=center> <form method="post"> <input type="submit" value="zmień" name="gpio_linia_tyl" /> </form> </td>"';
    if (read_pin($gpio_linia_tyl)<>1 )
    {echo "<td class='red'>OTWARTE";} else {echo " <td class='green'>ZAMKNIĘTE";}
    echo '</td></tr>';

    // strefa  linia taras
    echo '<tr>   <td > warzywa </td>  ';
    echo '<td align=center> <form method="post"> <input type="submit" value="zmień" name="gpio_warzywa" /> </form> </td>"';
    if (read_pin($gpio_warzywa)<>1 )
    {echo "<td class='red'>OTWARTE";} else {echo " <td class='green'> ZAMKNIĘTE";}
    echo '</td></tr>';
echo '</table>';

echo '<br>';
echo "ilość otwartych sekcji: " . ifAnyOpen();
echo '<br>';

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
if(isset($_POST['gpio_linia_tyl']))
{
     change_pin($gpio_linia_tyl);  
     pompaStartStop();
}
if(isset($_POST['gpio_warzywa']))
{
     change_pin($gpio_warzywa);  
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


</div>
