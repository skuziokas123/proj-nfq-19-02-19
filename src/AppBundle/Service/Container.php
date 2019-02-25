<?php
class Container{
	private $entityManager=null;
	private $dbconfig=null;
	
	public function __construct($dbconfig)
    {
        $this->dbconfig=$dbconfig;
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