<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Deal
 *
 * @ORM\Table("sf_deal")
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\DealRepository")
 */
class Deal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DealNode", mappedBy="deal", cascade={"persist"})
     */
    protected $nodes;

    /**
     *
     */
    public function __construct()
    {
        $this->connections = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Deal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return $this
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param ArrayCollection $nodes
     * @return $this
     */
    public function setNodes($nodes)
    {
        foreach ($nodes as $node) {
            $this->addNode($node);
        }

        // $this->nodes = $nodes;
        return $this;
    }

    public function addNode(DealNode $node)
    {
        $node->setDeal($this);
        $this->nodes[] = $node;

        return $this;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
