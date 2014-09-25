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
        $books = $this->getDoctrine()
            ->getManager()
            ->getRepository('IntaroLibraryBundle:Book')
            ->findAllOrderedByDateOfReading();

        return $this->render('IntaroLibraryBundle:Default:index.html.twig', array("books" => $books));
    }
    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $book = $em->getRepository('IntaroLibraryBundle:Book')->find($id);
        } else {
            $book = new Book();
        }

        $form = $this->createForm(new BookType(), $book);
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
