<?php
namespace OC\STBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrickController extends Controller

{

	public function indexAction()
	{
		return $this->render('OCSTBundle:Trick:index.html.twig');
	}

	public function contactAction(Request $request)
	{
		$session = $request->getSession()->getFlashBag()->add('info',"la page de contact n'est pas encore disponible veuillez ressayer plus tard !");
		return $this->redirectToRoute('ocst_homepage');
	}

	public function addAction(Request $request)
	{
		if($request->isMethod('POST'))
		{
			return $this->redirecToRoute('ocst_trick_view', array('id' => 1));
		}

		return $this->render('OCSTBundle:Trick:add.html.twig');

	}

}