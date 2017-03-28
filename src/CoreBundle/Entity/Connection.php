<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;

/**
 * Connection
 *
 * @ORM\Table(name="sf_connection",uniqueConstraints={
 *      @ORM\UniqueConstraint(name="connection_idx", columns={"initial_company_id", "end_company_id", "is_provider"})})
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\ConnectionRepository")
 * @Assert\Callback(methods={"isValid"})
 */
class Connection
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
     * @var boolean
     *
     * @ORM\Column(name="is_provider", type="boolean")
     */
    private $isProvider;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="initialConnections")
     * @ORM\JoinColumn(name="initial_company_id", referencedColumnName="id")
     */
    protected $initialCompany;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="endConnections")
     * @ORM\JoinColumn(name="end_company_id", referencedColumnName="id")
     */
    protected $endCompany;


    /**
     *
     */
    public function __construct()
    {
        $this->deals = new ArrayCollection();
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
     * Set isProvider
     *
     * @param boolean $isProvider
     * @return Connection
     */
    public function setIsProvider($isProvider)
    {
        $this->isProvider = $isProvider;

        return $this;
    }

    /**
     * Get isProvider
     *
     * @return boolean 
     */
    public function getIsProvider()
    {
        return $this->isProvider;
    }

    /**
     * @return Company
     */
    public function getInitialCompany()
    {
        return $this->initialCompany;
    }

    /**
     * @param Company $initialCompany
     * @return $this
     */
    public function setInitialCompany($initialCompany)
    {
        $this->initialCompany = $initialCompany;
        return $this;
    }

    /**
     * @return Company
     */
    public function getEndCompany()
    {
        return $this->endCompany;
    }

    /**
     * @param Company $endCompany
     * @return $this
     */
    public function setEndCompany($endCompany)
    {
        $this->endCompany = $endCompany;
        return $this;
    }
    

    /**
     * @return string
     */
    public function getTypeStr()
    {
        return ($this->getIsProvider() ? 'proveedor' : 'cliente');
    }

    /**
     * @param ExecutionContext $context
     */
    public function isValid(ExecutionContext $context)
    {
        /* Check if repeated company */
        if($this->initialCompany && $this->endCompany && $this->initialCompany == $this->endCompany){
            $context->addViolationAt('endCompany', 'Ha de seleccionar una empresa diferente a la inicial.');
        }
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->initialCompany.' --> '.$this->endCompany.' ('.$this->getTypeStr().')';
    }

}
