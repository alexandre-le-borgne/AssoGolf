<?php
/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 11/04/2016
 * Time: 13:38
 */

namespace TournamentBundle\DataFixtures\ORM;

use TournamentBundle\Entity\Tournament;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTournament implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tournamentsData = array(
            array("name" => "Tournoi 1", "datetime" => new \DateTime("-1 year"), "max_players" => 10),
            array("name" => "Tournoi 2", "datetime" => new \DateTime("-1 month"), "max_players" => 50),
            array("name" => "Tournoi 3", "datetime" => new \DateTime("-1 day"), "max_players" => 100),
        );
        foreach ($tournamentsData as $tournamentData) {
            $tournament = new Tournament();
            $tournament->setName($tournamentData["name"]);
            $tournament->setDatetime($tournamentData["datetime"]);
            $tournament->setMaxPlayers($tournamentData["max_players"]);
            $manager->persist($tournament);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}