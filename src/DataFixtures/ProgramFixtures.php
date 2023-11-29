<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const SERIE = [
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure']
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::SERIE as $programName) {
            $program = new Program();
            $program->setTitle($programName['title']);
            $program->setSynopsis($programName['synopsis']);
            $program->setCategory($this->getReference($programName['category']));
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
