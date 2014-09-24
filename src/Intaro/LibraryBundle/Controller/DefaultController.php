<?php

namespace Intaro\LibraryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Intaro\LibraryBundle\Entity\Book;
use Intaro\LibraryBundle\Form\BookType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('IntaroLibraryBundle:Book');
        $query = $repository->createQueryBuilder('b')
            ->orderBy('b.read_at', 'DESC')
            ->getQuery();
        $query->useResultCache(true, 86400, "books");
        $books = $query->getResult();

        return $this->render('IntaroLibraryBundle:Default:index.html.twig', array("books" => $books));
    }
    public function editAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $book = $em->getRepository('IntaroLibraryBundle:Book')->find($id);
        } else {
            $book = new Book();
        }

        $form = $this->createForm(new BookType(), $book);
        $request = $this->container->get('request');
        $form->handleRequest($request);

        if ($id && $form->get('delete')->isClicked()) {
            $em->remove($book);
            $em->flush();

            return $this->redirect($this->generateUrl('intaro_library_homepage'));
        }

        if ($form->isValid()) {
            $em->persist($book);
            $em->flush();

            if ($form->get('apply')->isClicked()) {
                return $this->redirect($this->generateUrl('intaro_library_edit', array("id" => $book->getId())));
            } else {
                return $this->redirect($this->generateUrl('intaro_library_homepage'));
            }
        }

        return $this->render(
            'IntaroLibraryBundle:Default:bookedit.html.twig',
            array("id" => $id, "form" => $form->createView(), "book" => $book)
        );
    }
}
