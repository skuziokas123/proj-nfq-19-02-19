<?php



class EntityManagerLoader{
	
	private $entityManager=null;
	private $dbconfig=null;
	
	public function __construct($dbconfig)
    {
        $this->dbconfig=$dbconfig;
		$this->loadEntityManager();
    }
	
	
	private function loadEntityManager(){
		//$this->entityManager = null;
    
		//if ($entityManager === null)
		//{
		$config = new \Doctrine\ORM\Configuration;
		$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/entities');
		$config->setMetadataDriverImpl($driverImpl);
		$config->setProxyDir('./app/cache/dev');
		$config->setProxyNamespace('Proxies');
		$this->entityManager = \Doctrine\ORM\EntityManager::create($this->dbconfig->getDbParamsConfig(), $config);
			
		//}
	}
	
	public function getEntityManager(){
		return $this->entityManager;
	}
	
}