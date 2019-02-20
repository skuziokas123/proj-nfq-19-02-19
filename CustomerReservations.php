<?php

include 'header.php';
$tomorrow = new DateTime();
$tomorrow->modify('+1 day');

echo "<h3>Laisvi laikai</h3>";

echo "<h4>".$tomorrow->format('Y-m-d')." (rytoj)</h4></br>";

$workStartDate=new DateTime($tomorrow->format('Y-m-d').' 10:00:00');

//echo $workStartDate->format('Y-m-d H:i:s')."</br>";

//$workStartDate->modify('+15 min');

//echo $workStartDate->format('Y-m-d H:i:s')."</br>";

echo "<table>";

echo "<tr>";
echo "<th>Laikas</th>";
echo "<th>Veiksmai</th>";

echo "</tr>";

while($workStartDate->format('H:i:s')!="20:00:00"){
	echo "<tr>";
	

    echo "<td>".$workStartDate->format('Y-m-d H:i:s')."</td>";
	$workStartDate->modify('+15 min');
	
	echo "<td><a href=''>[Rezervuoti]</a></td>";
	
	echo "</tr>";
}

echo "</table>";

include 'footer.php';