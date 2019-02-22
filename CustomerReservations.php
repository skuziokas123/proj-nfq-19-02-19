<?php

include 'header.php';
require_once(__DIR__ . '/config/db-config.php');
require_once('bootstrap.php');
require_once('functions.php');

$name="";
$nameErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 if (empty($_POST["name"])) {
		$nameErr = "Vardas privalomas";
	}else{
		$name = test_input($_POST["name"]);
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
		$reservation=new Reservation();
		$reservation->setCustomer($customer[0]);
		$reservation->setVisitDate(new DateTime($dateTime));
		
		$worker=$entityManager->getRepository("Worker")->findAll();
		$reservation->setWorker($worker[0]);
		$entityManager->persist($reservation);
		$entityManager->flush();
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
<h4>prašome suvesti vardą ir spausti "Saugoti" mygtuką</h4>
 Vardas: <input type="text" name="name" value="<?php echo $name;?>">
 <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
 <input type="submit" name="saveName" value="Saugoti">
 

</form>


<?php


//echo "name = ".$name;

if($name!==""){

$tomorrow = new DateTime();
$tomorrow->modify('+1 day');

echo "<h3>Laisvi laikai</h3>";

echo "<h4>".$tomorrow->format('Y-m-d')." (rytoj)</h4></br>";

$workStartDate=new DateTime($tomorrow->format('Y-m-d').' 10:00:00');

echo "<table>";

echo "<tr>";
echo "<th>Laikas</th>";
echo "<th>Veiksmai</th>";

echo "</tr>";

while($workStartDate->format('H:i:s')!="20:00:00"){
	echo "<tr>";
	

    echo "<td>".$workStartDate->format('Y-m-d H:i:s')."</td>";
	
	
	echo "<td><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?name=".$name."&dateTime=".$workStartDate->format('Y-m-d H:i:s')."'>[Rezervuoti]</a></td>";
	
	$workStartDate->modify('+15 min');
	
	echo "</tr>";
}

echo "</table>";
}

include 'footer.php';