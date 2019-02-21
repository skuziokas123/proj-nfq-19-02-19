<?php
require_once(__DIR__ . '/vendor/autoload.php');
//require_once(__DIR__ . '/config/db-config.php');

$classDirs = array(
    __DIR__,
    __DIR__ . '/entities',
);
new \iRAP\Autoloader\Autoloader($classDirs);
function getEntityManager($dbParams) : \Doctrine\ORM\EntityManager
{
    $entityManager = null;
    
    if ($entityManager === null)
    {
        //$paths = array(__DIR__ . '/entities');
        //$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths);
		
		$config = new \Doctrine\ORM\Configuration;
		$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/entities');
		$config->setMetadataDriverImpl($driverImpl);
		$config->setProxyDir('/app/cache/dev');
		$config->setProxyNamespace('Proxies');
		
        # set up configuration parameters for doctrine.
        # Make sure you have installed the php7.0-sqlite package.
        /*$connectionParams = array(
            'driver' => 'pdo_sqlite',
            'path'   => __DIR__ . '/data/my-database.db',
        );*/
        //$entityManager = \Doctrine\ORM\EntityManager::create($connectionParams, $config);
		
		//$dbParams = array(
			//'driver'         => 'pdo_mysql',
			//'user'           => 'root',
			//'password'       => '',
			//'host'           => '127.0.0.1',
			//'port'           => 3306,
			//'dbname'         => 'proj-nfq-19-02-19',
			//'charset'        => 'UTF-8',
		//);
		
		$entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);

		
    }
    
    return $entityManager;
}