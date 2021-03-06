<?php

namespace ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rates
 *
 * @ORM\Table(name="rates")
 * @ORM\Entity(repositoryClass="ProductsBundle\Repository\RatesRepository")
 */
class Rates
{

    /**
     * @ORM\ManyToOne(targetEntity="ProductsBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */

    private $Product;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
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
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */

    private $score;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $date;


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
     * Set score.
     *
     * @param int $score
     *
     * @return Rates
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score.
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Rates
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Rates
     */

    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user
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
     * @param \ProductsBundle\Entity\Product $product
     *
     * @return Rates
     */
    public function setProduct(\ProductsBundle\Entity\Product $product)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \ProductsBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Rates
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
}
