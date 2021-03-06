<?php
/**
 * @Entity @Table(name="status")
 **/
class Status
{
	/** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
	
	
	public function getId() : int { return $this->id; }
    public function getName() : string { return $this->name; }
	
	
	

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Status
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
