<?php
namespace OC\STBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OC\STBundle\Entity\Category;
use OC\STBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends Controller
{
    /**
     *@Security("has_role('ROLE_ADMIN')")
     */
   public function addCategoryAction(Request $request)
   {
   	   $category = new Category();
       $form = $this->createForm(CategoryType::class, $category);
       if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
       {
       	   $em = $this->getDoctrine()->getManager();
       	   $em->persist($category);
       	   $em->flush();
       	   return $this->redirectToRoute('ocst_homepage');
       }
   	   return $this->render('OCSTBundle:Category:add.html.twig', array(
   	   'form'=>$form->createView()
       ));
   }

   public function viewCategoryAction(Request $request)
   {
       $em = $this->getDoctrine()->getManager();
       $listCategories = $em->getRepository('OCSTBundle:Category')->findAll();
       return $this->render('OCSTBundle:Category:categories.html.twig',array('listCategories'=>$listCategories));
   }

   public function editCategoryAction(Request $request, $id)
   {
      $em =  $this->getDoctrine()->getManager();

      $category = $em->getRepository('OCSTBundle:Category')->find($id);
      $form = $this->createForm(CategoryType::class,$category);
      if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
      {
          $em->flush();
          return $this->redirectToRoute('ocst_category_view');
      }

      return $this->render('OCSTBundle:Category:edit.html.twig', array('form' => $form->createView(),
         'category'=>$category ));
   }

  public function deleteCategoryAction(Request $request, $id)
  {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository('OCSTBundle:Category')->find($id);
      $em->remove($category);
      $em->flush();
      return $this->redirectToRoute('ocst_category_view');
  }
}