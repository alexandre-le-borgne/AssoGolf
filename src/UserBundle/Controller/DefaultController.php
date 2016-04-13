<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Created by PhpStorm.
 * User: GCC-MED
 * Date: 12/04/2016
 * Time: 14:39
 */
class DefaultController extends Controller
{
    /**
     * @Route ("/user/{id}", name="user")
     * @param $id
     * @return mixed
     */
    public function IndexAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        if($user == null)
            throw $this->createNotFoundException("Utilisateur inconnu");
        return $this->render("@User/user.html.twig", array("user" => $user));
    }

    /**
     * @Route ("/userInfo/{id}", name="userInfo")
     * @param $id
     * @return mixed
     */
    public function UserInfoAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        if($user == null)
            throw $this->createNotFoundException("Utilisateur inconnu");
        return $this->render("@User/user_info.html.twig", array("user" => $user));
    }
}