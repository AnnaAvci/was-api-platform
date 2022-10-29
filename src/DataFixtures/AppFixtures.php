<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Message;
use App\Entity\Service;
use App\Entity\Location;
use App\Entity\ServiceBook;
use App\Entity\LocationBook;
use App\Entity\ServiceComment;
use App\Entity\LocationComment;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\VarDumper\VarDumper;

class AppFixtures extends Fixture
{
    /**
     * L'encodeur de mots de passe
     *
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_UK');

        $users = [];

        for ($u = 0; $u < 10; $u++) {
            $user = new User();

            $hash = $this->encoder->hashPassword($user, "azerty");

            // ========  USER   ==========
            $user->setFirstName($faker->firstName())
                 ->setLastName($faker->lastName())
                 ->setEmail($faker->email())
                 ->setRegisteredAt($faker->dateTime())
                 ->setPassword($hash)
                 ->setCountryUser($faker->country())
                 ->setCityUser($faker->city())
                 ->setPostcodeUser($faker->postcode())
                 ->setIsVerified("true");

            $manager->persist($user);

            array_push($users, $user);

            // ========  LOCATION   ==========
            for ($l = 0; $l < mt_rand(0, 5); $l++) {
                $location = new Location();
                $location->setLocationName($faker->randomElement(['Beach House', 'Apartment with a view', 'Rustic farm']))
                        ->setOwner($user)
                        ->setCountry($faker->country())
                        ->setCity($faker->city())
                        ->setPostcode($faker->postcode())
                        ->setPrice($faker->numberBetween(0,600));

                $manager->persist($location);

                $lbook = new LocationBook();
                $lbook->setLocation($location)
                    ->setLocationClient($user)
                    ->setMessage($faker->realText(35))
                    ->setCreatedAt(new DateTime())
                    ->setDateStart($faker->dateTimeBetween($startDate = '-1 day', $endDate = '+1 day'))
                    ->setDateEnd($faker->dateTimeBetween($startDate = '-1 day', $endDate = '+1 day'))
                    ->setIsAccepted($faker->randomElement([0, 1, 2]));

                $manager->persist($lbook);

                $lcomment = new LocationComment();
                $lcomment->setLocation($location)
                    ->setCommenter($user)
                    ->setText($faker->randomElement(['Fantastic location', 'Got amazing pictures, thank you', 'Big thank you to the host!', 'Highly recommend!!']))
                    ->setPostedAt(new DateTime());

                $manager->persist($lcomment);
            }

            // ========  SERVICE   ==========
            for ($s = 0; $s < mt_rand(0, 5); $s++) {
                $service = new Service();
                $service->setServiceName($faker->randomElement(['Wedding photoshoot', 'Portrait', 'Lifestyle photoshoot', 'Artistic photoshoot']))
                    ->setOwner($user)
                    ->setCountry($faker->country())
                    ->setCity($faker->city())
                    ->setPostcode($faker->postcode())
                    ->setPrice($faker->numberBetween(0, 600));

                $manager->persist($service);

                $sbook = new ServiceBook();
                $sbook->setService($service)
                    ->setServiceClient($user)
                    ->setMessage($faker->realText(35))
                    ->setCreatedAt(new DateTime())
                    ->setDateStart($faker->dateTimeBetween($startDate = '-1 day', $endDate = '+1 day'))
                    ->setDateEnd($faker->dateTimeBetween($startDate = '-1 day', $endDate = '+1 day'))
                    ->setIsAccepted($faker->randomElement([0, 1, 2]));

                $manager->persist($sbook);

                $scomment = new ServiceComment();
                $scomment->setService($service)
                    ->setCommenter($user)
                    ->setText($faker->randomElement(['Best photographer ever!', 'Got amazing pictures, thank you', 'Highly recommend!!']))
                    ->setPostedAt(new DateTime());

                $manager->persist($scomment);
            }
          
        }

        // ========  MESSAGE   ==========
        for ($m = 0; $m < 50; $m++) {
            $message = new Message();

            $randomUser1 = $users[rand(0, 9)];
            $randomUser2 = $users[rand(0, 9)];

            if($randomUser1 !== $randomUser2){
                $message->setSender($randomUser1)
                    ->setRecipient($randomUser2)
                    ->setText($faker->words($nb = 3, $asText = true))
                    ->setCreatedAt(new DateTime())
                    ->setIsRead($faker->randomElement([0, 1]));

                $manager->persist($message);
            }
    }

        $manager->flush();

    }
}
