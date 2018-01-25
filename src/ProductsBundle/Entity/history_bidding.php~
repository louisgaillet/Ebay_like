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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;


    /**
     * @ORM\ManyToOne(targetEntity="ProductsBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;


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
     * @ORM\Column(name="bid", type="integer")
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
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return history_bidding
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * Set product.
     *
     * @param \ProductsBundle\Entity\Product|null $product
     *
     * @return history_bidding
     */
    public function setProduct(\ProductsBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \ProductsBundle\Entity\Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }
}
