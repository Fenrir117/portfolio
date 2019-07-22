<?php

namespace App\Controller;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IntroTwigController extends AbstractController
{
    /**
     * @var SessionInterface 
     */
    private $session;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(SessionInterface $session, RouterInterface $router) // supprimer l'antislash devant Session interface
    {
        $this->session = $session;
        $this->router = $router;
    }
   
    /**
     * @Route("/intro/twig", name="intro_twig")
     */


    /**
     * @Route("/blog", name="blog_index")
     */

    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'posts' => $this->session->get('posts'),
        ]);
    }

    /**
     * @Route("/blog/add", name="blog_add")
    */
    public function add()
    {
        $posts = $this->session->get('posts');
        $id = uniqid();
        $posts[$id] = [
            'title' => 'Un titre aléatoire' . rand(1, 500),
            'text' => 'Un texte aléatoire' . rand(1, 500),
            'id' => $id,
            'date' => new \DateTime(),
            'price' => 56300.25
        ];

        $this->session->set('posts', $posts);
        return new RedirectResponse($this->router->generate('blog_index'));
    }
    /**
     * @Route("/blog/show/{id}" , name="blog_show")
     */
    public function show($id)
    {
        $posts = $this->session->get('posts'); // on récupère la variable de session post

        if (!$posts || !isset($posts[$id])) { // si elle nous retourne que la variable n'existe pas ou que l'id du post n'existe pas 
            throw new NotFoundHttpException('Post non trouvé'); // met le use de la classe qui gère les exceptions // quand on génère des exceptions le programme s'arrete
        }

        return $this->render( // si elle existe on retourne les infos du posts
            'blog/post.html.twig',
            [
                'id' => $id,
                'post' => $posts[$id]
            ]
        );
    }
}
