<?php

namespace TournamentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\UserBundle;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tournaments = $em->getRepository("TournamentBundle:Tournament")->findAll();
        $data = array("tournaments" => $tournaments);
        return $this->render('@Tournament/Default/index.html.twig', $data);
    }

    /**
     * @Route("/tournament/{id}", name="tournament")
     */
    public function tournamentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if ($tournament == null)
            throw $this->createNotFoundException("Tournoi inconnu");
        return $this->render('@Tournament/Default/tournament.html.twig', array("tournament" => $tournament));
    }

    /**
     * @route("/tournement/{id}/inscription", name="tournamentInscription")
     */
    public function tournementInscriptionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $user User
         */
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        $user = $this->getUser();
        $user->addTournament($tournament);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("tournament", array("id" => $id));
    }

    /**
     * @route("/tournement/{id}/unscription", name="tournamentUnscription")
     */
    public function tournementUninscriptionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var $user User
         */
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        $user = $this->getUser();
        $user->removeTournament($tournament);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("tournament", array("id" => $id));
    }

    /**
     * @Route("/userTournaments", name="userTournaments")
     */
    public function userTournamentsAction()
    {
        return $this->render('@Tournament/Default/user_tournaments.html.twig');
    }

    /**
     * @Route("/tournamentForm/{id}", name="tournamentForm")
     */
    public function tournamentFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tournament = $em->getRepository("TournamentBundle:Tournament")->find($id);
        if ($tournament == null)
            throw $this->createNotFoundException("Tournoi inconnu");
        return $this->render('@Tournament/Default/tournament_form.html.twig', array("tournament" => $tournament));
    }
}
