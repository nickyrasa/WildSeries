<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAMS = [
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure']
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $programLine) {
        $program = new Program();
        $program->setTitle($programLine['Title']);
        $program->setSynopsis($programLine['Synopsis']);
        $program->setCategory($this->getReference($programLine['Category']));
        $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
