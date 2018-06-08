<?php
namespace OC\STBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\STBundle\Entity\Trick;
use OC\STBundle\Entity\Image;
use OC\STBundle\Entity\Comment;

use OC\STBundle\Entity\Video;
use OC\STBundle\Form\TrickType;
use OC\STBundle\Form\CommentType;
use OC\STBundle\Form\TrickEditType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TrickController extends Controller

{

	public function indexAction($page)
	{
        $em = $this->getDoctrine()->getManager();
        if($page < 1)
        {
        	throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        } 
        $nbPerPage = 3;

        $listCategories = $em->getRepository('OCSTBundle:Category')->findAll();
         $listTricks = $em->getRepository('OCSTBundle:Trick')->findAll();
        $nbPages = ceil(count($listTricks)/$nbPerPage);
        if($page>$nbPages)
        {
        	 throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        } 	
        $listTricks = $em->getRepository('OCSTBundle:Trick')->getTricks($page,$nbPerPage);
		return $this->render('OCSTBundle:Trick:index.html.twig', array('listTricks' => $listTricks,'listCategories'=>
			$listCategories,'page' =>$page,'nbPages'=>$nbPages));
	}

	public function contactAction(Request $request)
	{
		$session = $request->getSession()->getFlashBag()->add('info',"la page de contact n'est pas encore disponible veuillez ressayer plus tard !");
		return $this->redirectToRoute('ocst_homepage');
	}
  /**
   *@Security("has_role('ROLE_USER')")
   */ 
	public function addAction(Request $request)
	{
		$trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
		if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($trick);
			$em->flush();
             $request->getSession()->getFlashBag()->add('info','le trick est bien ajoutée');
			return $this->redirectToRoute('ocst_homepage');
		}
        
		return $this->render('OCSTBundle:Trick:add.html.twig',array(
			 'form' => $form->createView() 
			 ) );

	}
 /**
   *@Security("has_role('ROLE_USER')")
   */ 
	public function editAction($id, Request $request)
	{
		
        $em=$this->getDoctrine()->getManager();  
		$trick = $em->getRepository('OCSTBundle:Trick')->find($id);
        $form = $this->createForm(TrickEditType::class, $trick);

        if($request->isMethod('Post') && $form->handleRequest($request)->isValid())
        	 {
        	 	
        	 	$em->flush();
                $request->getSession()->getFlashBag()->add('info','Trick modifié avec succés !');
        	 	return $this->redirectToRoute('ocst_homepage');
        	 }
		
        
	
        
		return $this->render('OCSTBundle:Trick:edit.html.twig', array(
			'form' 	=> $form->createView())
	);

	}

	public function viewAction($id, $page, Request $request)
	{
      $em = $this->getDoctrine()->getManager();
      $trick = $em->getRepository('OCSTBundle:Trick')->find($id);
      $comment = new Comment();
      $form = $this->createForm(CommentType::class, $comment); 
      if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
      {
         $comment->setTrick($trick);
         $em->persist($trick);
         $em->persist($comment);
         $em->flush();
          $request->getSession()->getflashbag()->add('info','votre commentaire est enregistré');
          return $this->redirect($this->generateUrl('ocst_trick_view', array('id' => $trick->getId(), 'page' => $page)) .'#coms');
      }  
      $nbPerPage = 10;

      $listComments = $em->getRepository('OCSTBundle:Comment')->getComments($page, $nbPerPage, $id); 
      $nbPages = ceil(count($listComments)/$nbPerPage);

      return $this->render('OCSTBundle:Trick:view.html.twig', array('trick'=>$trick, 
      	                                                             'listComments'=>$listComments,
                                                                     'form' => $form->createView(),
                                                                      'page' =>$page,
                                                                      'nbPages'=>$nbPages));
	}
 /**
   *@Security("has_role('ROLE_USER')")
   */ 
	public function deleteAction(Request $request,$id)
	{
       $em = $this->getDoctrine()->getManager();
       $trick = $em->getRepository('OCSTBundle:Trick')->find($id);
       if(null ==  $trick)
       {
       	 throw new NotFoundHttpException("L'annonce d'id".$id." n'existe pas ");
       }
       $form = $this->get('form.factory')->create();
       if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
       {
       	 $em->remove($trick);
       	 $em->flush();
       	 $request->getSession()->getFlashBag()->add('info',"Le trick est bien supprimé");
       	 return $this->redirectToRoute('ocst_homepage');
       }

       return $this->render('OCSTBundle:Trick:delete.html.twig', array('trick' => $trick,
                                                                  'form' => $form->createView()));
	}

	public function trickCategoryAction($category, $page)
	{

		$em = $this->getDoctrine()->getManager();
        if($page < 1)
        {
        	throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        } 
        $nbPerPage = 3;
 
		$listTricksByCat=$em->getRepository('OCSTBundle:Trick')->getTricksByCategory($category);
		$nbPages = ceil(count($listTricksByCat)/$nbPerPage);
		$listCategories = $em->getRepository('OCSTBundle:Category')->findAll();

		$em->flush();

		return $this->render('OCSTBundle:Trick:cat.html.twig',array('listTricksByCat'=>$listTricksByCat,'cat'=>$category,'listCategories'=>$listCategories,'page' =>$page,'nbPages'=>$nbPages));
	}

}