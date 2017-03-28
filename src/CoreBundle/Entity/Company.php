<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table("sf_company")
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\CompanyRepository")
 */
class Company
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Connection", mappedBy="initialCompany")
     */
    protected $initialConnections;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Connection", mappedBy="endCompany")
     */
    protected $endConnections;

    /**
     *
     */
    public function __construct()
    {
        $this->initialConnections = new ArrayCollection();
        $this->endConnections = new ArrayCollection();
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
     * @return Company
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
     * @return ArrayCollection
     */
    public function getInitialConnections()
    {
        return $this->initialConnections;
    }

    /**
     * @param ArrayCollection $initialConnections
     * @return $this
     */
    public function setInitialConnections($initialConnections)
    {
        $this->initialConnections = $initialConnections;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEndConnections()
    {
        return $this->endConnections;
    }

    /**
     * @param ArrayCollection $endConnections
     * @return $this
     */
    public function setEndConnections($endConnections)
    {
        $this->endConnections = $endConnections;
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
