<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findAll();
        $statuses = $em->getRepository('AppBundle:BookStatus')->findAll();
        return $this->render('default/home.html.twig', ['books' => $books, 'statuses' => $statuses]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/add", name="addBook")
     */
    public function addAction(Request $request) {
        $book = new Book();
        $attributes = ['class' => 'form-control'];
        $options = $this->getDoctrine()->getRepository('AppBundle:BookStatus')->getOptions();
        $form = $this->createFormBuilder($book)
            ->add('authors', TextType::class,['attr' => $attributes])
            ->add('title', TextType::class, ['attr' => $attributes])
            ->add('year', IntegerType::class, ['attr' => $attributes])
            ->add('status', ChoiceType::class, ['choices' => $options, 'attr' => $attributes])
            ->add('save', SubmitType::class, ['label' => 'Добавить книгу', 'attr' => ['class' => 'btn btn-flat btn-success']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $book->setAuthors($form['authors']->getData());
                $book->setTitle($form['title']->getData());
                $book->setYear($form['year']->getData());
                $book->setBookStatus($em->getRepository('AppBundle:BookStatus')->find($form['status']->getData()));
                $book->setDateCreate(new \DateTime('now'));
                $em->persist($book);
                $em->flush();
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
            return $this->redirectToRoute('home');
        }
        return $this->render('default/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
