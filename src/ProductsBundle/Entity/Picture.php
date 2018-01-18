<?php

namespace ProductsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="ProductsBundle\Repository\PictureRepository")
 */
class Picture
{

    /**
     * @ORM\ManyToOne(targetEntity="ProductsBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Product;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set url
     *
     * @param string $url
     *
     * @return Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set product
     *
     * @param \ProductsBundle\Entity\Product $product
     *
     * @return Picture
     */
    public function setProduct(\ProductsBundle\Entity\Product $product)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ProductsBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->Product;
    }
}
