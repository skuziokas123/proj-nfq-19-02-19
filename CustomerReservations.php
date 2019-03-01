<?php

include 'header.php';
require_once(__DIR__ . '/config/db-config.php');
require_once('bootstrap.php');
require_once('functions.php');

$name="";
$nameRequired=TRUE;
$selectWorker="";
$selectWorkerRequired=TRUE;
$nameErr="";
$selectWorkerError="";
$reservation="";
$showMyReservations=FALSE;
$dateTime="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//print_r($_POST);
	
	if (empty($_POST["name"])) {
		$nameErr = "Vardas privalomas";
	}else{
		$name = test_input($_POST["name"]);
	}
	
	if(isset($_POST["myReservations"])){
		echo "<h1>labas 1547</h1>";
		$selectWorkerRequired=FALSE;
		$showMyReservations=TRUE;
	
		$entityManager = $container->getEntityManager();
		$customer=$entityManager->getRepository("Customer")->findBy(
             array('name'=> $name) 
        );
		
		if(!empty($customer)){
			$reservation=$container->getReservationRepository()->findReservationByCustomer($customer[0]->getId());
			$resTmp=$reservation;
			$reservation=null;
			$reservation=$resTmp[0];
		}
	}
	
	if ((empty($_POST["selectWorker"]))&&($selectWorkerRequired==TRUE)) {
		$selectWorkerError = "Pasirinkite kirpėją";
	}else{
		
		$selectWorker = test_input($_POST["selectWorker"]);
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (empty($_GET["name"])) {

	}else{
		$name = test_input($_GET["name"]);
		
		$dateTime = test_input($_GET["dateTime"]);
	
		$entityManager = $container->getEntityManager();
		
		$customer=$entityManager->getRepository("Customer")->findBy(
             array('name'=> $name) 
        );

		if(!empty($customer)){

		}else{
			$customer=new Customer();
			$customer->setName($name);
			$entityManager->persist($customer);
			$entityManager->flush();
			$customerTmp=$customer;
			$customer=array();
			$customer[0]=$customerTmp;
			
		}
		$selectWorker=test_input($_GET["workerId"]);
		
		if((isset($_GET["action"]))&&($_GET["action"]=="cancelReservation")){
			$id = test_input($_GET["id"]);
			
			$container->getReservationRepository()->cancelReservation($id);
			
			$reservation="";
			
		}elseif((isset($_GET["action"]))&&($_GET["action"]=="register")){
		
			$reservation=new Reservation();
			$reservation->setCustomer($customer[0]);
			$reservation->setVisitDate(new DateTime($dateTime));
			
			$worker=$entityManager->getRepository("Worker")->findBy(

				 array('id'=>$selectWorker) 

			);
			
			$reservation->setWorker($worker[0]);
			$entityManager->persist($reservation);
			$entityManager->flush();
		}
	}
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<h4>Norėdami užsiregistruoti pas kirpėją</h4>
<h4>prašome suvesti vardą, pasirinkti kirpėją ir spausti "Rodyti laisvus laikus" mygtuką</h4>
 Vardas: <input type="text" name="name" value="<?php echo $name;?>">
 <span class="error">* <?php echo $nameErr;?></span>
 <br><br>
 Kirpėja(as): <select name="selectWorker">
  <option value="">--Pasirinkite--</option>
  
  <?php

	$entityManager = $container->getEntityManager();
	
	$workers=$entityManager->getRepository("Worker")->findAll();
	
	foreach($workers as $worker){
		
		$selected="";
		if($selectWorker==$worker->getId()){
			$selected="selected='selected'";
		}
		
		echo "<option value=".$worker->getId()." ".$selected.">".$worker->getName()."</option>";
	}
  
  ?>
</select> <span class="error">* <?php echo $selectWorkerError;?></span>
 
  <br><br>
 <input type="submit" name="saveName" value="Rodyti laisvus laikus">

 <h4>Jei jau registravotės</h4>

 <input type="submit" name="myReservations" value="Mano rezervacijos">
 
</form>

<?php


if(($name!=="")&&(($selectWorker!=="")||($selectWorkerRequired==FALSE))){
	
	if($showMyReservations==TRUE){
		//echo "<h1>showMyReservations==TRUE<h1>";
		if($reservation===""){
			echo "<h4>Rezervacijų nerasta. Prašome registruotis.</h4>";
		}else{
			
			require_once('./app/Resources/views/table-show-active-reservation.php');
			
			/*echo "<table>";

			echo "<tr>";
			echo "<th>Laikas</th>";
			echo "<th>Veiksmai</th>";

			echo "</tr>";
			
			echo "<td>".$reservation->getVisitDate()->format('Y-m-d H:i:s')."</td>";
			echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?action=cancelReservation&id=".$reservation->getId()."&workerId=".$selectWorker."&name=".$name."&dateTime=".$reservation->getVisitDate()->format('Y-m-d H:i:s')."'>[Atšaukti]</a></td>";
			echo "</table>";*/
			
		}
	}else{

		$tomorrow = new DateTime();
		$tomorrow->modify('+1 day');

		if($reservation===""){

		echo "<h3>Laisvi laikai</h3>";

		echo "<h4>".$tomorrow->format('Y-m-d')." (rytoj)</h4></br>";

		$workStartDate=new DateTime($tomorrow->format('Y-m-d').' 10:00:00');

		}else{
			echo "<h3>Jūs užsiregistravote</h3>";
		}

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
	}
}

include 'footer.php';