<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $compteur = 0;

        for ($i = 0; $i < 100; $i++) {

            $compteur++;

            $product = new Product();
            $product->setName("IPhone ".$compteur);
            $product->setDescription($faker->text);
            $product->setPrice( $faker->numberBetween(10, 10000) );
            $product->setSlug("IPhone-".$compteur);

            $manager->persist($product);
        }



        $manager->flush();
    }
}
