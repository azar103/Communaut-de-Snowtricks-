<?php
namespace OC\STBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\STBundle\Entity\Category;

class LoadCategory implements FixtureInterface
{
     public function load(ObjectManager $manager)
     {

     	$names = array('Grabs','Rotations','Flip','Slides','Old School');

     	foreach ($names as $name) {
     		$category = new Category();
     		$category->setName($name);
     		$manager->persist($category);
     	}

     	$manager->flush();

     }
}