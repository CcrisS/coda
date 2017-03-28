<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DealNode
 *
 * @ORM\Table(name="sf_deal_node",uniqueConstraints={
 *      @ORM\UniqueConstraint(name="deal_node_idx", columns={"deal_id", "connection_id"})})
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\DealNodeRepository")
 */
class DealNode
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
     * @var Connection
     *
     * @ORM\ManyToOne(targetEntity="Deal", inversedBy="nodes", cascade={"persist"})
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="id"), nullable=false)
     **/
    private $deal;

    /**
     * @var Connection
     *
     * @ORM\ManyToOne(targetEntity="Connection")
     * @ORM\JoinColumn(name="connection_id", referencedColumnName="id"), nullable=false)
     **/
    private $connection;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;


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
     * Set level
     *
     * @param integer $level
     * @return DealNode
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return Connection
     */
    public function getDeal()
    {
        return $this->deal;
    }

    /**
     * @param Connection $deal
     * @return $this
     */
    public function setDeal($deal)
    {
        $this->deal = $deal;
        return $this;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     * @return $this
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
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
