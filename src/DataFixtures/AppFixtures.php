<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Run;
use App\Entity\User;
use App\Entity\Serie;
use App\Entity\Exercice;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager/*, UserPasswordHasherInterface $userPasswordHasher*/): void
    {
        $faker = Factory::create();

        // USERS
        $users = [];

        for ($i=0; $i < 10; $i++) { 
            $user = new User();

            $password = "";
            for ($j=0; $j < 10; $j++) { 
                if ($faker->randomDigit < 3)
                    $password .= strval($faker->randomDigit);
                else
                    $password .= strval($faker->randomLetter);
            }
            // $hashedPassword = $userPasswordHasher->hashPassword(
            //     $user,
            //     $password
            // );

            $user
                ->setEmail($faker->email)
                ->setPassword($password)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsVerified($faker->boolean)
            ;
                // ->setPassword($hashedPassword)

            $users[] = $user;

            $manager->persist($user);
        }

        // EXERCICES SERIES
        $exercicesSeries = [];

        for ($i=0; $i < 20; $i++) { 
            $exerciceSerie = new Exercice();

            if ($faker->randomDigit < 2)
                $break = $faker->numberBetween(1, 30);
            else
                $break = 0;
            
            if ($faker->randomDigit < 2)
                $stop = true;
            else
                $stop = false;
            
            $numUser = $faker->numberBetween(0, count($users) - 1);

            $exerciceSerie
                ->setName($faker->word)
                ->setBreak($break)
                ->setStop($stop)
                ->setUser($users[$numUser])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsRun(false);
            ;

            $exercicesSeries[] = $exerciceSerie;

            $manager->persist($exerciceSerie);
        }

        // EXERCICES RUNS
        $exercicesRuns = [];

        for ($i=0; $i < 20; $i++) { 
            $exerciceRun = new Exercice();

            if ($faker->randomDigit < 2)
                $break = $faker->numberBetween(1, 30);
            else
                $break = 0;
            
            if ($faker->randomDigit < 2)
                $stop = true;
            else
                $stop = false;
            
            $numUser = $faker->numberBetween(0, count($users) - 1);

            $exerciceRun
                ->setName($faker->word)
                ->setBreak($break)
                ->setStop($stop)
                ->setUser($users[$numUser])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsRun(true);
            ;

            $exercicesRuns[] = $exerciceRun;

            $manager->persist($exerciceRun);
        }

        // SERIES
        $series = [];

        for ($i=0; $i < 500; $i++) { 
            $serie = new Serie();

            $repetitions = $faker->numberBetween(1, 3);
            for ($j=0; $j < $faker->numberBetween(1, 6); $j++) { 
                $repetitions *= $faker->numberBetween(1, 4);
            }

            $numExercice = $faker->numberBetween(0, count($exercicesSeries) - 1);

            $serie
                ->setRepetitions($repetitions)
                ->setExercice($exercicesSeries[$numExercice])
                ->setCreatedAt(new \DateTimeImmutable())
            ;

            $series[] = $serie;

            $manager->persist($serie);
        }

        // RUNS
        $runs = [];

        for ($i=0; $i < 500; $i++) { 
            $run = new Run();

            $km = $faker->numberBetween(1, 3);
            for ($j=0; $j < $faker->numberBetween(1, 5); $j++) { 
                $km *= $faker->numberBetween(1, 4);
            }

            $positiveElevation = $faker->numberBetween(1, 3);
            for ($j=0; $j < $faker->numberBetween(1, 6); $j++) { 
                $positiveElevation *= $faker->numberBetween(1, 6);
            }

            $numExercice = $faker->numberBetween(0, count($exercicesRuns) - 1);

            $run
                ->setKm($km)
                ->setPositiveElevation($positiveElevation)
                ->setExercice($exercicesRuns[$numExercice])
                ->setCreatedAt(new \DateTimeImmutable())
            ;

            $runs[] = $run;

            $manager->persist($run);
        }

        $manager->flush();
    }
}
