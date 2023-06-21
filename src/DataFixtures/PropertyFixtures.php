<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10 ; $i++)
         {  
            $fake = Factory::create('fr_FR');         
            $property= new Property();
            $property->setTitle($fake->words(3, true))
                    ->setDescription($fake->sentences(3, true))
                    ->setSurface($fake->numberBetween(20,350))
                    ->setRooms($fake->numberBetween(2,10))
                    ->setBedrooms($fake->numberBetween(1,9))
                    ->setFloor($fake->numberBetween(0,15))
                    ->setPrice($fake->numberBetween(100000,100000000))
                    ->setHeat($fake->numberBetween(0,count(Property::HEAT)-1))
                    ->setCity($fake->city)
                    ->setAddress($fake->address)
                    ->setPostalCode($fake->postcode)
                    ->setImageName($fake->imageUrl($width = 640, $height = 480))
                    ->setImageSize($width = 640, $height = 480)
                    ->setUpdatedAt($fake->dateTime('now'))
                    ->setSold(false);

                $manager->persist($property);

            
        }
        

        $manager->flush();
    }
}
