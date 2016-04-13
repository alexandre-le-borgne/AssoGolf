<?php
/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 11/04/2016
 * Time: 14:33
 */

namespace TournamentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TournamentBundle\Entity\Tournament;
use TournamentBundle\Entity\TournamentInscription;
use UserBundle\Entity\User;

class LoadUsersTournaments extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository("UserBundle:User")->findAll();
        $tournaments = $manager->getRepository("TournamentBundle:Tournament")->findAll();
        $inscriptions = array(0 => array(0, 1, 2), 1 => array(0, 2), 2 => array(1, 2));
        foreach ($inscriptions as $k => $v) {
            foreach ($v as $x) {
                $tournamentInscription = new TournamentInscription();
                $tournamentInscription->setTournament($tournaments[$x]);
                $tournamentInscription->setUser($users[$k]);
                $manager->persist($tournamentInscription);
            }
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
        return 3;
    }
}