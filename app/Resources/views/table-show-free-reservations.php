<?php

echo "<table>";

echo "<tr>";
echo "<th>Laikas</th>";
echo "<th>Veiksmai</th>";

echo "</tr>";

if($reservation===""){

	while($workStartDate->format('H:i:s')!="20:00:00"){
		echo "<tr>";

		echo "<td>".$workStartDate->format('Y-m-d H:i:s')."</td>";
			
		echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?action=register&name=".$name."&workerId=".$selectWorker."&dateTime=".$workStartDate->format('Y-m-d H:i:s')."'>[Rezervuoti]</a></td>";
				
		$workStartDate->modify('+15 min');
				
		echo "</tr>";
	}
}else{
	require('./app/Resources/views/cancel-reservation-part.php');
			
	/*echo "<td>".$reservation->getVisitDate()->format('Y-m-d H:i:s')."</td>";
	echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?action=cancelReservation&id=".$reservation->getId()."&workerId=".$selectWorker."&name=".$name."&dateTime=".$reservation->getVisitDate()->format('Y-m-d H:i:s')."'>[Atšaukti]</a></td>";*/
}

echo "</table>";