<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture
{

    public const SEASONS = [
        ['number' => '1','year'=>'1996','description' =>'','program'=>'program_Dragon ball Z'],
        ['number' => '2','year'=>'1997','description' =>'','program'=>'program_Dragon ball Z'],
        ['number' => '3','year'=>'1998','description' =>'','program'=>'program_Dragon ball Z'],
        ['number' => '4','year'=>'1999','description' =>'','program'=>'program_Dragon ball Z'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $seasonShows) {
            $season = new Season();
            $season->setNumber($seasonShows['number']);
            $season->setYear($seasonShows['year']);
            $season->setDescription($seasonShows['description']);
            $season->setProgram($this->getReference($seasonShows['Program']));
            $manager->persist($season);
            $this->addReference('season_' . $seasonShows['number'], $season);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
