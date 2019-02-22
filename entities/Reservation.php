<?php
/**
 * @Entity @Table(name="reservation")
 * @ORM\Entity(repositoryClass="ReservationRepository")
 **/
class Reservation
{
	/** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /* @Column(type="string") **/
    //protected $name;
	
	/**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $updated;
	
	/**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $created;
	
	/**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $visitDate;
	
	/**
     * @ManyToOne(targetEntity="Worker")
     **/
	protected $worker;
	
	/**
     * @ManyToOne(targetEntity="Customer")
     **/
	protected $customer;
	
	/**
     * @ManyToOne(targetEntity="Status")
     **/
	protected $status;
    
    
    public function __construct()
    {
        //$this->name = $name;
        //$this->email = $email;
    }
    # Accessors
    public function getId() : int { return $this->id; }
	public function getVisitDate() : datetime { return $this->visitDate; }
    public function getWorker() : Worker { return $this->worker; }
    public function getCustomer() : Customer { return $this->customer; }
	public function getStatus() : Status { return $this->status; }
	
	public function setVisitDate($visitDate){  $this->visitDate=$visitDate; }
	public function setWorker($worker){  $this->worker=$worker; }
    public function setCustomer($customer){  $this->customer=$customer; }
	public function setStatus($status){  $this->status=$status; }
	

    /**
     * Set updated.
     *
     * @param \DateTime|null $updated
     *
     * @return Reservation
     */
    public function setUpdated($updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set created.
     *
     * @param \DateTime|null $created
     *
     * @return Reservation
     */
    public function setCreated($created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime|null
     */
    public function getCreated()
    {
        return $this->created;
    }
}
