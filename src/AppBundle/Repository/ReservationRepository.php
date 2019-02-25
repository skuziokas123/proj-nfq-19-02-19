<?php

//require(__DIR__ . '\..\..\..\vendor\doctrine\orm\lib\Doctrine\ORM\EntityRepository.php');

class ReservationRepository 
//extends \Doctrine\ORM\EntityRepository
{
	private $entityManager=null;
	
	public function __construct($entityManager){
		//print_r($entityManager);
		$this->entityManager=$entityManager;
	}
	
	public function findActiveReservations(){
		//print_r($this->entityManager);
		
		//$qb = $this->createQueryBuilder('r')
                    //->select('r')
                    //->where('u.username is not null')
                    //->andWhere('u.roles IN (:role)')
                    //->where('r.status <> :statusCanceled')
                    //->orWhere('r.status is NULL')
                    //->setParameter('statusCanceled', 1);

        //return $qb->getQuery()->getResult();
		
		//echo "labas 254";
		
		//print_r($this->entityManager);
		
		return $this->entityManager->createQuery(
			'SELECT r FROM Reservation r WHERE (r.status <> 1) OR (r.status is NULL)'
		)->getResult();
	}
	
}