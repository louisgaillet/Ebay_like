<?php

namespace ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * history_bidding
 *
 * @ORM\Table(name="history_bidding")
 * @ORM\Entity(repositoryClass="ProductsBundle\Repository\history_biddingRepository")
 */
class history_bidding
{

    /**
     * @ORM\ManyToOne(targetEntity="ProductsBundle\Entity\Bidding")
     * @ORM\JoinColumn(nullable=true)
     */

    private $Bidding;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     */
    private $User;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="bid", type="integer", unique=true)
     */
    private $bid;


    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return history_bidding
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set bid.
     *
     * @param int $bid
     *
     * @return history_bidding
     */
    public function setBid($bid)
    {
        $this->bid = $bid;

        return $this;
    }

    /**
     * Get bid.
     *
     * @return int
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * Set bidding.
     *
     * @param \ProductsBundle\Entity\Bidding|null $bidding
     *
     * @return history_bidding
     */
    public function setBidding(\ProductsBundle\Entity\Bidding $bidding = null)
    {
        $this->Bidding = $bidding;

        return $this;
    }

    /**
     * Get bidding.
     *
     * @return \ProductsBundle\Entity\Bidding|null
     */
    public function getBidding()
    {
        return $this->Bidding;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return history_bidding
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->User;
    }
}