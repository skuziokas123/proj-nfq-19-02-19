<?php
/**
 * @Entity @Table(name="reservations")
 **/
class Reservation
{
	/** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
	
	/**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $updated;
	
	/**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $created;
    
    
    public function __construct(string $name)
    {
        $this->name = $name;
        //$this->email = $email;
    }
    # Accessors
    public function getId() : int { return $this->id; }
    public function getName() : string { return $this->name; }
    //public function getEmail() : string { return $this->email; }
	
}