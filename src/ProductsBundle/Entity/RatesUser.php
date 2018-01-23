<?php

namespace ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RatesUser
 *
 * @ORM\Table(name="rates_user")
 * @ORM\Entity(repositoryClass="ProductsBundle\Repository\RatesUserRepository")
 */
class RatesUser
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */

    private $Owner;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
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
     * @return RatesUser
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
     * @return RatesUser
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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return RatesUser
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
     * Set owner.
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return RatesUser
     */
    public function setOwner(\AppBundle\Entity\User $owner)
    {
        $this->Owner = $owner;

        return $this;
    }

    /**
     * Get owner.
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->Owner;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return RatesUser
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
}
