<?php

include 'header.php';
require_once(__DIR__ . '/config/db-config.php');
require_once('bootstrap.php');
require_once('functions.php');

$name="";
$selectWorker="";
$nameErr="";
$selectWorkerError="";
$reservation="";
$dateTime="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "Vardas privalomas";
	}else{
		$name = test_input($_POST["name"]);
	}
	
	if (empty($_POST["selectWorker"])) {
		$selectWorkerError = "Pasirinkite kirpėją";
	}else{
		
		
		$selectWorker = test_input($_POST["selectWorker"]);
		//echo "selectWorker = ".$selectWorker;
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (empty($_GET["name"])) {
		//$nameErr = "Vardas privalomas";
	}else{
		$name = test_input($_GET["name"]);
		
		$dateTime = test_input($_GET["dateTime"]);
		//echo "dateTime = ".$dateTime;
		$entityManager = getEntityManager($dbParamsConfig);
		$customer=$entityManager->getRepository("Customer")->findBy(
             array('name'=> $name) 
             //array('id' => 'ASC')
        );
		//var
		//print_r($customer);
		if(!empty($customer)){
			//echo "<h1>customer not empty</h1>";
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
			$reservation=$entityManager->getRepository("Reservation")->findBy(
				 array('id'=> $id) 
				 //array('id' => 'ASC')
			);
			$status=$entityManager->getRepository("Status")->findBy(
				 array('id'=> 1) 
				 //array('id' => 'ASC')
			);
			$reservation[0]->setStatus($status[0]);
			$entityManager->persist($reservation[0]);
			$entityManager->flush();
			//$reservationTmp=$reservation[0];
			//$reservation=$reservationTmp;
			$reservation="";
			
		}else{
		
			$reservation=new Reservation();
			$reservation->setCustomer($customer[0]);
			$reservation->setVisitDate(new DateTime($dateTime));
			
			//$worker=$entityManager->getRepository("Worker")->findAll();
			
			$worker=$entityManager->getRepository("Worker")->findBy(
				 //array('id'=> test_input($_GET["workerId"])) 
				 array('id'=>$selectWorker) 
				 //array('id' => 'ASC')
			);
			
			$reservation->setWorker($worker[0]);
			$entityManager->persist($reservation);
			$entityManager->flush();
		}
	}
	
}

/*function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}*/



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
	$entityManager = getEntityManager($dbParamsConfig);
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
 

</form>


<?php


//echo "name = ".$name;

if(($name!=="")&&($selectWorker!=="")){

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
	
	/*$entityManager = getEntityManager($dbParamsConfig);
	$worker=$entityManager->getRepository("Worker")->findBy(
             array('id'=> $selectWorker) 
             //array('id' => 'ASC')
        );*/
	
	
	echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?name=".$name."&workerId=".$selectWorker."&dateTime=".$workStartDate->format('Y-m-d H:i:s')."'>[Rezervuoti]</a></td>";
	
	$workStartDate->modify('+15 min');
	
	echo "</tr>";
}
}else{
	 echo "<td>".$reservation->getVisitDate()->format('Y-m-d H:i:s')."</td>";
	echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?action=cancelReservation&id=".$reservation->getId()."&workerId=".$selectWorker."&name=".$name."&dateTime=".$reservation->getVisitDate()->format('Y-m-d H:i:s')."'>[Atšaukti]</a></td>";
}

echo "</table>";
}

include 'footer.php';