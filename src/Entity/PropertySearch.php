<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
		return $this->maxPrice;
	}

    /**
     * @param int|null $maxPrice
     * 
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
	}
    /**
     * @var int|null
     * @Assert\Range(min=10)
     */
    private $minSurface;

    public function getMinSurface(): ?int
    {
		return $this->minSurface;
	}

    /**
     * @param int|null $minSurface
     * 
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }
    /**
     * @var ArrayCollection
     */
    private $options;

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
		return $this->options;
	}

    /**
     * @param ArrayCollection $options
     * 
     * @return void
     */
    public function setOptions(ArrayCollection $options)
    {
		$this->options = $options;
	}

}