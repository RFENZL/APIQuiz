<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private Generator $faker;

    private $userPasswordHasher;

    /** 
    *@var UserPasswordHasherInterface
*/
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->faker =Factory::create("fr_FR");
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $publicUser = new User();
        $password= $this->faker->password(2,6);
        $publicUser
        ->setUsername($this->faker->username()."@".$password)
        ->setPassword($this->userPasswordHasher->hashPassword($publicUser,$password))
        ->setRoles(["ROLE_PUBLIC"])
        ->setUuid($this->faker->uuid());

        $manager->persist($publicUser);
        for($i=0; $i <10; $i++){
            $userUser = new User();
            $password= $this->faker->password(2,6);
            $userUser
            ->setUsername($this->faker->username()."@".$password)
            ->setPassword($this->userPasswordHasher->hashPassword($publicUser,$password))
            ->setRoles(["ROLE_USER"])
            ->setUuid($this->faker->uuid());
            $manager->persist($publicUser);
        }
        $adminUser = new User();
        $adminUser
        ->setUsername($this->faker->username()."@".$password)
        ->setPassword($this->userPasswordHasher->hashPassword($publicUser,"password"))
        ->setRoles(["ROLE_ADMIN"])
        ->setUuid($this->faker->uuid());

        $manager->flush();
    }
}
