<?php
/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 11/04/2016
 * Time: 13:55
 */

namespace UserBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use UserBundle\Entity\User;
use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\FOSUserBundle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');


        $usersData = array(
            array("email" => "root@root.fr", "username" => "root", "password" => "root", "lastname" => "root",
                "firstname" => "root", "register_date" => new \DateTime("-1 year"), "role" => User::ORGANIZER),
            array("email" => "toto@toto.fr", "username" => "toto", "password" => "", "lastname" => "toto",
                "firstname" => "toto", "register_date" => new \DateTime("-1 month"), "role" => User::USER),
            array("email" => "titi@titi.fr", "username" => "titi", "password" => "", "lastname" => "titi",
                "firstname" => "titi", "register_date" => new \DateTime("-1 day"), "role" => User::USER)
        );
        foreach ($usersData as $userData) {
            $user = new User();
            $user->setEnabled(true);
            $user->setEmail($userData["email"]);
            $user->setRoles(array($userData["role"]));
            $user->setUsername($userData["username"]);
            $user->setPlainPassword($userData["username"]);
            $user->setFirstname($userData["firstname"]);
            $user->setLastname($userData["lastname"]);
            $user->setRegisterDate($userData["register_date"]);
            $userManager->updateUser($user, false);
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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