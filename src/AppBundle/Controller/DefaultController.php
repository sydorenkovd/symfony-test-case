<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @return Response
     * @Route("/home", name="home")
     */
    public function homeAction() {
        $books = $this->getDoctrine()->getRepository('AppBundle:Book')->findAll();
        $statuses = $this->getDoctrine()->getRepository('AppBundle:BookStatus')->findAll();
        return $this->render('default/home.html.twig', ['books' => $books, 'statuses' => $statuses]);
    }
}
