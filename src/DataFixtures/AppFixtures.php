<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    // $product = new Product();
    // $manager->persist($product);
    $faker = Factory::create();
    // création de 20 utilisateurs
    for ($i = 0; $i < 20; $i++) {
      $user = new User();
      $user->setFirstName($faker->firstName);
      $user->setLastName($faker->lastName);
      $user->setBirthday($faker->dateTime);
      $manager->persist($user);
    }
    $manager->flush();
  }
}
