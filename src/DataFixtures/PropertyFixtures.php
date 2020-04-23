<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i=0; $i < 100; $i++){
            $property = new Property();
            $property
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(2, true))
                ->setPrice($faker->numberBetween(20000000, 150000000))
                ->setRooms($faker->numberBetween(4, 10))
                ->setSold(false)
                ->setSurface($faker->numberBetween(210, 500))
                ->setBedrooms($faker->numberBetween(3, 8))
                ->setCity('Bujumbura')
                ->setHeat($faker->numberBetween(0, count(Property::HEAT)-1))
                ->setAdresse($faker->address)
                ->setAdresseCode($faker->postcode)
                ;
            $manager->persist($property);
        }
        $manager->flush();
    }
}
