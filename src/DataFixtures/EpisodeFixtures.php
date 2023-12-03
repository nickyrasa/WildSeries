<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    // public const EPISODES = [
    //     ['title' => 'The Arrival of Raditz', 'number' => '1', 'season' => 'season_1', 'synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
    //     ['title' => 'The Arrival of Bobby', 'number' => '2','season' => 'season_1', 'synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
    //     ['title' => 'The Arrival of Johns', 'number' => '3', 'season' => 'season_1','synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
    //     ['title' => 'The Arrival of JeanMichel', 'number' => '4', 'season' => 'season_1','synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
    // ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        foreach (ProgramFixtures::PROGRAMS as $program) {
            for ($season['number'] = 1; $season['number'] <= 5; $season['number']++) {
                for ($i = 0; $i <= 10; $i++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->sentence());
                    $episode->setNumber($i);
                    $episode->setSynopsis($faker->paragraph(3, true));
                    $episode->setSeasonId($this->getReference('program_' . $program['title'] . 'season_' . $season['number']));

                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
            SeasonFixtures::class,
        ];
    }
}
