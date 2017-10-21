<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function homeAction() {
        $books = $this->getDoctrine()->getRepository('AppBundle:Book')->findAll();
        $statuses = $this->getDoctrine()->getRepository('AppBundle:BookStatus')->findAll();
        return $this->render('default/home.html.twig', ['books' => $books, 'statuses' => $statuses]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/add", name="addBook")
     */
    public function addAction(Request $request) {
        $book = new Book();
        $atrributes = ['class' => 'form-control'];
        $choices = ['свободна' => 1,  'взята' => 2, 'зарезервирована' => 3];
        $form = $this->createFormBuilder($book)
            ->add('authors', TextType::class, array('attr' => $atrributes))
            ->add('title', TextType::class, array('attr' => $atrributes))
            ->add('year', TextType::class, array('attr' => $atrributes))
            ->add('status', ChoiceType::class, array('choices' => $choices, 'attr' => $atrributes))
            ->add('save', SubmitType::class, array('label' => 'Добавить книгу', 'attr' => array('class' => 'btn btn-flat btn-success')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $book->setAuthors($form['authors']->getData());
            $book->setTitle($form['title']->getData());
            $book->setYear($form['year']->getData());
            $book->setBookStatus($em->getRepository('AppBundle:BookStatus')->find($form['status']->getData()));
            $book->setDateCreate(new \DateTime('now'));
            $em->persist($book);
            $em->flush();

            $this->addFlash('notice', 'Book Added');

            return $this->redirectToRoute('home');
        }

        return $this->render('default/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
