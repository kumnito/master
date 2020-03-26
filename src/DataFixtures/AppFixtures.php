<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Tag;


use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag;
            $tag->setName('Tag'.$i);
            $manager->persist($tag);

        }

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setUsername($faker->email);
            $manager->persist($user);
            $users[]=$user;

        }

        $compteur = 0;

        for ($i = 0; $i < 100; $i++) {

            $compteur++;

            $product = new Product();
            $product->setName("IPhone ".$compteur);
            $product->setDescription($faker->text);
            $product->setPrice( $faker->numberBetween(10, 10000) );
            $product->setSlug("IPhone-".$compteur);
            $product->setUser($faker->randomElement($users));

            $manager->persist($product);
        }



        $manager->flush();
    }
}
