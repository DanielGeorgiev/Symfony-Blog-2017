<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SoftUniBlogBundle\Entity\Article;
use SoftUniBlogBundle\Entity\User;
use SoftUniBlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @param Request $request
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @Route("/article/create", name="create_article")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form -> handleRequest($request);

        if ($form -> isValid())
        {
            $article -> setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em -> persist($article);
            $em-> flush();

            return $this->redirectToRoute("blog_index");
        }

        return $this -> render("article/create.html.twig",
            array('form' => $form->createView()));
    }
    /**
     * @Route("/article/view/{id}", name="view_article")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this -> render('article/view.html.twig',
            ['article' => $article]);
    }
}
