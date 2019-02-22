<?php
// cli-config.php
require_once(__DIR__ . '/../bootstrap.php');
require_once(__DIR__ . '/../config/db-config.php');
$entityManager = getEntityManager($dbParamsConfig);
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);