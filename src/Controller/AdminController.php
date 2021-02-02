<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use App\Form\AddAuthorType;
use App\Form\AuthorRegisterType;
use App\Form\BookEditType;
use App\Form\BookRegisterType;
use App\Form\EditUserType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/utilisateurs", name="usersList")
     */
    public function usersList(UserRepository $userRepository)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/ajoutLivre", name="addBook")
     */
    public function addBook(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(BookRegisterType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // traitement  de l'image
            $image = $form->get('filename')->getData();
            // $fichier = md5(uniqid()) .'.'.$image->guessExtension();
            $fichier = md5(uniqid()) .'.jpg';
            // On copie le fichier dans le dossier images
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );

            // On modifie le nom de l'image
            $book->setFilename('/images/'.$fichier);

            // Traitement du document
            $file = $form->get('document')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('pdf_directory'),
                $fileName
            );
            $book->setDocument('/pdf/'.$fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('listBook');
        }

        return $this->render('admin/addBook.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/livre/appercu", name="shortcut")
     */
    public function shortcut(BookRepository $bookRepository)
    {
        return $this->render('livre/appercu.html.twig', [
            'books' => $bookRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/liste_des_livres", name="listBook")
     */
    public function listBook(BookRepository $bookRepository)
    {
        return $this->render('admin/listBook.html.twig', [
            'books' => $bookRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/edition_livre-{id}", name="editBook")
     */
    public function editBook(Book $book, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(BookEditType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('listBook');
        }
        return $this->render('admin/editBook.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }

    /**
     * @Route("/admin/suppression_livre-{id}", name="deleteBook", methods="DELETE")
     */
    public function deleteBook(Book $book)
    {
        $this->em->remove($book);
        $this->em->flush();

        return $this->redirectToRoute('listBook');
    }

    /**
     * @Route("/admin/edition/utilisateur-{id}", name="editUser")
     */
    public function editUser(Request $request, User $user, EntityManagerInterface $em)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('usersList');
        }

        return $this->render('admin/editUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/ajout/auteur", name="addAuthor")
     */
    public function addAuthor(Request $request)
    {
        $author = new Author();
        $form = $this->createForm(AddAuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('listAuthor');
        }
        return $this->render('admin/addAuthor.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/affichage/auteur", name="listAuthor")
     */
    public function listAuthor(AuthorRepository $authorRepository)
    {
            return $this->render('admin/listAuthor.html.twig', [
                'authors' => $authorRepository->findAll()
            ]);
    }

    /**
     * @Route("/admin/edition/auteur-{id}", name="editAuthor")
     */
    public function editAuthor(Request $request, Author $author, EntityManagerInterface $em)
    {
        $form = $this->createForm(AuthorRegisterType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('listAuthor');
        }

        return $this->render("admin/editAuthor.html.twig", [
            'form' => $form->createView(),
            'author' => $author
        ]);
    }

    /**
     * @Route("/admin/suppression/author-{id}", name="deleteAuthor")
     */
    public function deleteAuthor(Author $author, EntityManagerInterface $em)
    {
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('listAuthor');
    }

    /**
     * @Route("/informations", name="info")
     */
    public function mesInfos()
    {
        return $this->render("admin/info.html.twig");
    }
}
