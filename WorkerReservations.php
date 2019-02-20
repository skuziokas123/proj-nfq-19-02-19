<?php

include 'header.php';

//ini_set('memory_limit', '-1');

require_once('bootstrap.php');
// create a user
$entityManager = getEntityManager();

//exit();

// List all users:
$reservations = $entityManager->getRepository("Reservation")->findAll();

//exit();

//print "Reservations: " . print_r($reservations, true) . PHP_EOL;
//echo $reservations[0]->getId();

echo "<table>";

echo "<tr>";
echo "<th>ID</th>";
echo "<th>Laikas</th>";
echo "<th>Darbuotojas</th>";
echo "<th>Klientas</th>";

echo "</tr>";

foreach($reservations as $reser){
	echo "<tr>";
	echo "<td>".$reser->getId()."</td>";
	//print_r($reser->getVisitDate());
	$visitDate=$reser->getVisitDate();
	echo "<td>".$visitDate->format('Y-m-d H:i:s')."</td>";
	echo "<td>".$reser->getWorker()->getName()."</td>";
	echo "<td>".$reser->getCustomer()->getName()."</td>";
	echo "</tr>";
}

echo "</table>";

include 'footer.php';