<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture
{
    public const EPISODES = [
        ['title' => 'The Arrival of Raditz', 'number' => '1', 'synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
        ['title' => 'The Arrival of Bobby', 'number' => '2', 'synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
        ['title' => 'The Arrival of Johns', 'number' => '3', 'synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
        ['title' => 'The Arrival of JeanMichel', 'number' => '4', 'synopsis' => 'After five years of peace, a new threat is coming for Goku and his friends, Goku\'s evil brother Radditz.'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $episodeLive) {
            $episode = new Episode();
            $episode->setTitle($episodeLive['title']);
            $episode->setNumber($episodeLive['number']);
            $episode->setSynopsis($episodeLive['synopsis']);
            $episode->setseason($this->getReference($episodeLive['season']));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {   
        return [
            SeasonFixtures::class,
        ];
    }
}
