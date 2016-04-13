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
        /*
        $tournaments[0]->addUser($users[0])
            ->addUser($users[1]);
        $tournaments[1]->addUser($users[0])
            ->addUser($users[2]);
        $tournaments[2]->addUser($users[0])
            ->addUser($users[1])
            ->addUser($users[2]);
        $manager->persist($tournaments[0]);
        $manager->persist($tournaments[1]);
        $manager->persist($tournaments[2]);*/
        $users[0]->addTournament($tournaments[0])->addTournament($tournaments[1])->addTournament($tournaments[2]);
        $users[1]->addTournament($tournaments[0])->addTournament($tournaments[2]);
        $users[2]->addTournament($tournaments[1])->addTournament($tournaments[2]);
        $manager->persist($users[0]);
        $manager->persist($users[1]);
        $manager->persist($users[2]);
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