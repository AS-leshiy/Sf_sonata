<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;

/**
 * @Route("/")
 */

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:BlogPost')->findAll();
        return $this->render('home/home.html.twig', ['posts' => $posts]);
    }
    
    /**
     * @Route("/posts/{slug}/show", name="home_article")
     * @ParamConverter("post", class="AppBundle:BlogPost", options={"id" = "slug"})
     * @Method("GET")
     */
    public function showAction(BlogPost $post)
    {
        if($post->getDraft()){
            return $this->render('home/post_show.html.twig', ['post' => $post]);
        } else {
            return $this->redirectToRoute('homepage');
        }
    }
    
    /**
     * @Route("/addnew", name="add_post")
     * @Method({"GET", "POST"})
     */
    public function addnewAction(Request $request, \Swift_Mailer $mailer){
        $post = new BlogPost();
        $form = $this->createForm(BlogPostType::class, $post);
        $form->handleRequest($request);
        
        $message = (new \Swift_Message('Notification'))
            ->setFrom('admin@gmail.com')
            ->setTo('dominant.corp@gmail.com')
            ->setBody(
                // app/Resources/views/Emails/registration.html.twig
                $this->renderView('Emails/new_post_mail.html.twig'), 'text/html'
                )
        ;
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            
            $this->addFlash('success', 'post.created_successfully');

            $mailer->send($message);
            
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('home/add.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
