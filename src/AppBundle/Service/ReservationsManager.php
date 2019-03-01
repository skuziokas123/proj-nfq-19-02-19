<?php

class ReservationsManager{
	private $upcommingReservations;
	
	public function __construct($upcommingReservations){
		$this->upcommingReservations=$upcommingReservations;
	}
	
	public function isVisitDateReserved($visitDateToCheck, $selectWorker){
		foreach ($this->upcommingReservations as $reservation){
			//$reservation->getVisitDate()->format('Y-m-d H:i:s');
			if(($reservation->getVisitDate()->format('Y-m-d H:i:s')==$visitDateToCheck)&&
			($reservation->getWorker()->getId()==$selectWorker)){
				return TRUE;
			}
		}
		return FALSE;
	}
	
}