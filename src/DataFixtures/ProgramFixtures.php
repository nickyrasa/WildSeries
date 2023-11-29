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
        ['title' => 'The last of us', 'synopsis' => 'Des champignons et des gens tristes', 'category' => 'category_Aventure'],
        ['title' => 'Dragon ball Z', 'synopsis' => 'Des boules de feu et des coupes de cheveux déjantés', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Des débiles sillonnent la mer', 'category' => 'category_Aventure'],
        ['title' => 'The witcher', 'synopsis' => 'c\'est l\'histoire d\'un blond, d\'une blonde et une brune', 'category' => 'category_Action'],
        ['title' => 'The boys', 'synopsis' => 'Des super héros, bam bam pow pow', 'category' => 'category_Action'],
        ['title' => 'Scott Pilgrim', 'synopsis' => 'Un garçon et des amourettes', 'category' => 'category_Action'],
        ['title' => 'Boruto', 'synopsis' => 'Un ninja pas aussi talentueux que son père', 'category' => 'category_Animation'],
        ['title' => 'My Adventures With Superman', 'synopsis' => 'Un homme qui aime bien porter des slips par dessus le pantalon', 'category' => 'category_Animation'],
        ['title' => 'Blue Eye Samurai', 'synopsis' => 'Un asiatique qui sait bien gérer sa lame', 'category' => 'category_Aventure'],
        ['title' => 'Supernatural', 'synopsis' => 'Wouh des pouvoirs', 'category' => 'category_Fantastique'],
        ['title' => 'Charmed', 'synopsis' => 'Des femmes et des pouvoirs', 'category' => 'category_Fantastique'],
        ['title' => 'Heroes', 'synopsis' => 'Des gens simples avec des histoires compliquées', 'category' => 'category_Fantastique'],
        ['title' => 'The walking dead', 'synopsis' => 'Des morts et des vivants', 'category' => 'category_Horreur'],
        ['title' => 'Death Note', 'synopsis' => 'Un mechant qui sait ecrire', 'category' => 'category_Horreur'],
        ['title' => 'Attack on titan', 'synopsis' => 'Des grands gens tout nus', 'category' => 'category_Horreur']
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $programLine) {
        $program = new Program();
        $program->setTitle($programLine['title']);
        $program->setSynopsis($programLine['synopsis']);
        $program->setCategory($this->getReference($programLine['category']));
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
