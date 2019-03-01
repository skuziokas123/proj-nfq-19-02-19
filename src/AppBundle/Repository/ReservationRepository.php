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
	
	public function cancelReservation($id){
		
		$reservation=$this->entityManager->getRepository("Reservation")->findBy(
             array('id'=> $id) 
             //array('id' => 'ASC')
        );
		$status=$this->entityManager->getRepository("Status")->findBy(
             array('id'=> 1) 
             //array('id' => 'ASC')
        );
		$reservation[0]->setStatus($status[0]);
		$this->entityManager->persist($reservation[0]);
		$this->entityManager->flush();
		
	}
	
	public function findReservationByCustomer($id){
		
		$dql='SELECT r FROM Reservation r WHERE ((r.status <> 1) 
			OR (r.status is NULL)) 
			AND (r.customer = :customer)';
		
		$query=$this->entityManager->createQuery(
			$dql
		);
		$parameters = array(
            //'from' => $from,
            'customer' => $id,
        );
		$query->setParameters($parameters);
		return $query->getResult();
	}
	
	public function findReservationsByDate($date){
		
		$dql='SELECT r FROM Reservation r WHERE ((r.status <> 1) 
			OR (r.status is NULL)) 
			AND (r.visitDate LIKE :visitDate)';
		
		$query=$this->entityManager->createQuery(
			$dql
		);
		$parameters = array(
            //'from' => $from,
            'visitDate' => '%'.$date.'%',
        );
		$query->setParameters($parameters);
		return $query->getResult();
	}
	
	public function findUpcommingReservations(){
		$dql='SELECT r FROM Reservation r WHERE ((r.status <> 1) 
			OR (r.status is NULL)) 
			AND (r.visitDate > CURRENT_TIMESTAMP())';
		
		$query=$this->entityManager->createQuery(
			$dql
		);
		/*$parameters = array(
            //'from' => $from,
            'visitDate' => '%'.$date.'%',
        );*/
		//$query->setParameters($parameters);
		return $query->getResult();
		
	}
	
}