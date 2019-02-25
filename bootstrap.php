<?php
require_once(__DIR__ . '/vendor/autoload.php');
//require_once(__DIR__ . '/config/db-config.php');

$classDirs = array(
    __DIR__,
    __DIR__ . '/entities',
	__DIR__ . '/src/AppBundle/Service',
);
new \iRAP\Autoloader\Autoloader($classDirs);

$container=new Container(new DbConfig());

/*function getEntityManager($dbParams) : \Doctrine\ORM\EntityManager
{
    $entityManager = null;
    
    if ($entityManager === null)
    {
       
		$config = new \Doctrine\ORM\Configuration;
		$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/entities');
		$config->setMetadataDriverImpl($driverImpl);
		$config->setProxyDir('./app/cache/dev');
		$config->setProxyNamespace('Proxies');
		
		$entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);

		
    }
    
    return $entityManager;
}*/