<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\PropertySearch;
use App\Entity\User;
use App\Form\PropertySearchType;
use App\Form\UserRegisterType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LivreController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(BookRepository $bookRepository)
    {
       return $this->render('livre/index.html.twig', [
            'books' => $bookRepository->findLastBook()
             ]);
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $auth){
        $error = $auth->getLastAuthenticationError();
        $lastUsername = $auth->getLastUsername();

        return $this->render('livre/login.html.twig', compact('error', 'lastUsername'));
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout(){}

    /**
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder){
        
        $user = new User();

        $form = $this->createForm(UserRegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('livre/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/livre/{id}", name="infoBook")
     */
    public function infoBook(Book $book)
    {
        return $this->render('livre/infoLivre.html.twig', compact('book'));
    }

    /**
     * @Route("/recherche/livre", name="searchBook")
     */
    public function searchBook(Request $request, BookRepository $bookRepository)
    {
        $item = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $item);

        $form->handleRequest($request);

        $books = [];

        if ($form->isSubmitted() && $form->isValid()) {

            $title = $form->getData()->getTitle();
            
            $books = $bookRepository->findBookByTitle($title);
            
        }
        return $this->render('livre/searchBook.html.twig', [
            'form' => $form->createView(),
            'books' => $books
        ]);
    }
}
