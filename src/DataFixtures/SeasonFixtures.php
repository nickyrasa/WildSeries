<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // public const SEASONS = [
        //     ['number' => '1', 'year' => '1996', 'description' => '', 'program' => 'program_Dragon ball Z'],
        //     ['number' => '2', 'year' => '1997', 'description' => '', 'program' => 'program_Dragon ball Z'],
        //     ['number' => '3', 'year' => '1998', 'description' => '', 'program' => 'program_Dragon ball Z'],
        //     ['number' => '4', 'year' => '1999', 'description' => '', 'program' => 'program_Dragon ball Z'],
        // ];

        // public function load(ObjectManager $manager)
        // {
        //     foreach (self::SEASONS as $seasonShows) {
        //         $season = new Season();
        //         $season->setNumber($seasonShows['number']);
        //         $season->setYear($seasonShows['year']);
        //         $season->setDescription($seasonShows['description']);
        //         $season->setProgramId($this->getReference($seasonShows['program']));
        //         $manager->persist($season);
        //         $this->addReference('season_' . $seasonShows['number'], $season);
        //     }
        //     $manager->flush();
        // }
        foreach (ProgramFixtures::PROGRAMS as $program) {
            for ($i = 0; $i < 50; $i++) {
                $season = new Season();
                $season->setNumber($faker->numberBetween(1, 10));
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));

                $season->setProgramId($this->getReference('program_' . $program['title']));
                $this->addReference('program_' . $program['title'] . 'season_' . $i, $season);
                $manager->persist($season);
            }
            $manager->flush();
        }
    }
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
