<?php
/**
 * @Entity @Table(name="user")
 **/
class User
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
        
    /** @Column(type="string") **/
    protected $email;
    
    
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
    # Accessors
    public function getId() : int { return $this->id; }
    public function getName() : string { return $this->name; }
    public function getEmail() : string { return $this->email; }
}