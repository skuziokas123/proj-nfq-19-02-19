<?php
class Container{
	private $entityManager=null;
	private $dbconfig=null;
	private $reservationRepository=null;
	private $reservationsManager=null;
	
	public function __construct($dbconfig)
    {
        $this->dbconfig=$dbconfig;
    }
	
	public function getReservationsManager(){
		if($this->reservationsManager==null){
			
			$this->reservationsManager=new ReservationsManager(
				$this->getReservationRepository()->findUpcommingReservations()
			);
			
		}
		return $this->reservationsManager;
	}
	
	public function getReservationRepository(){
		
		//print_r($this->getEntityManager());
		
		if($this->reservationRepository==null){
			//echo "labas 258";
			//print_r($this->getEntityManager());
			$this->reservationRepository=new ReservationRepository($this->getEntityManager());
			
			//$this->entityManager=$entityManagerLoader->getEntityManager();
		}
		return $this->reservationRepository;
	}
	
	public function getEntityManager(){
		if($this->entityManager==null){
			$entityManagerLoader=new EntityManagerLoader($this->dbconfig);
			//$this->entityManager=new EntityManagerLoader($this->dbconfig)
			$this->entityManager=$entityManagerLoader->getEntityManager();
		}
		return $this->entityManager;
	}
	
	
	
}