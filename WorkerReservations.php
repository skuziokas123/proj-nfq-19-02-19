<?php

include 'header.php';
require_once(__DIR__ . '/config/db-config.php');
require_once('functions.php');

require_once('bootstrap.php');


$entityManager = $container->getEntityManager();

if (($_SERVER["REQUEST_METHOD"] == "GET")&&(isset($_GET["action"]))) {
	if (($_GET["action"])=="cancelReservation") {
		//echo "action=cancelReservation";
		$id = test_input($_GET["id"]);
		
		$container->getReservationRepository()->cancelReservation($id);
		
		/*$reservation=$entityManager->getRepository("Reservation")->findBy(
             array('id'=> $id) 
             //array('id' => 'ASC')
        );
		$status=$entityManager->getRepository("Status")->findBy(
             array('id'=> 1) 
             //array('id' => 'ASC')
        );
		$reservation[0]->setStatus($status[0]);
		$entityManager->persist($reservation[0]);
		$entityManager->flush();*/
	}
}

$reservations = $container->getReservationRepository()->findActiveReservations();

if(!empty($reservations)){

echo "<h3>Rezervacijos</h3>";

echo "<table>";

echo "<tr>";
echo "<th>ID</th>";
echo "<th>Laikas</th>";
echo "<th>Darbuotojas</th>";
echo "<th>Klientas</th>";
echo "<th>Veiksmai</th>";

echo "</tr>";

foreach($reservations as $reser){
	echo "<tr>";
	echo "<td>".$reser->getId()."</td>";
	//print_r($reser->getVisitDate());
	$visitDate=$reser->getVisitDate();
	echo "<td>".$visitDate->format('Y-m-d H:i:s')."</td>";
	echo "<td>".$reser->getWorker()->getName()."</td>";
	echo "<td>".$reser->getCustomer()->getName()."</td>";
	echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?action=cancelReservation&id=".$reser->getId()."'>[Atšaukti]</a></td>";
	echo "</tr>";
}

echo "</table>";
}else{
	echo "<h3>Rezervacijų sąrašas tuščias</h3>";
}


include 'footer.php';