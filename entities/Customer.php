<?php
/**
 * @Entity @Table(name="customers")
 **/
class Customer
{
	/** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    
    
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