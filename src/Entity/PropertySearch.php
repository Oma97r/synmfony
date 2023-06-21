<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;



class PropertySearch{


/**
 * @var int|null
 * @Assert\Range(min=10000, max=500000000)
 */
private $maxPrice;



/**
 * @Assert\Range(min=10, max=400)
 * @var int|null
 */
private $minSurface;


/**
 * @var ArrayCollection
 */
private $options;

public function __construct(){
    $this->options = new ArrayCollection();
}

/**
 * @return int|null
 * 
 */
public function getMaxPrice():?int {

    return $this->maxPrice;
}
public function getMinSurface():?int {

    return $this->minSurface;}



/**
 * @param int|null $maxPrice
 * @return PropertySearch
 */
public function setMaxPrice( int $maxPrice): PropertySearch {

    $this->maxPrice = $maxPrice;
    return $this;
}

/**
 * @param int|null $maxPrice
 * @return PropertySearch
 */

public function setMinSurface(int $minSurface): PropertySearch{

    $this->minSurface = $minSurface;
    return $this;
}

/**
 * @return ArrayCollection
 */
public function getOptions():ArrayCollection{
    return $this->options;

}
/**
 * @param ArrayCollection $options
 */
public function setOptions(ArrayCollection $options):void{

    $this->options = $options;
}

}