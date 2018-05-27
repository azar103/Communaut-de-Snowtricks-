<?php

namespace OC\STBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="OC\STBundle\Repository\TrickRepository")
 */
class Trick
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

   /**
    *@ORM\OneToOne(targetEntity="OC\STBundle\Entity\Image", cascade = {"persist", "remove"})
    *@ORM\JoinColumn(nullable=false)
    */
   private $image;

   /**
    *@ORM\ManyToMany(targetEntity="OC\STBundle\Entity\Category")
    */
    private $categories;
  
   /**
    *@ORM\OneToOne(targetEntity="OC\STBundle\Entity\Video", cascade= {"persist"})
    **@ORM\JoinColumn(nullable=false)
    */
   private $video;
   
   private $singleCategory;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->categories = new  ArrayCollection();
    }
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
     * Set name
     *
     * @param string $name
     *
     * @return Trick
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
     * Set description
     *
     * @param string $description
     *
     * @return Trick
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Trick
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set image
     *
     * @param \OC\STBundle\Entity\Image $image
     *
     * @return Trick
     */
    public function setImage(Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\STBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

 
    /**
     * Add category
     *
     * @param \OC\STBundle\Entity\Category $category
     *
     * @return Trick
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \OC\STBundle\Entity\Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set video.
     *
     * @param \OC\STBundle\Entity\Video|null $video
     *
     * @return Trick
     */
    public function setVideo(\OC\STBundle\Entity\Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video.
     *
     * @return \OC\STBundle\Entity\Video|null
     */
    public function getVideo()
    {
        return $this->video;
    }

    public function setSingleCategory(Category $category = null)
    {
    // When binding invalid data, this may be null
    // But it'll be caught later by the constraint set up in the form builder
    // So that's okay!
    if (!$category) {
        return;
    }

    $this->categories->add($category);
   }

   public function getSingleCategory()
   {
    return $this->categories->first();
   }



}
