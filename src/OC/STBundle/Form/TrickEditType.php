<?php

namespace OC\STBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use OC\STBundle\Form\ImageType;
use OC\STBundle\Form\VideoType;
use OC\STBundle\Form\CategoryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use OC\STBundle\Form\TrickType;

class TrickEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('image')
                 ->add('image', ImageType::class, array('required' => false))
                 ;
                 
    }
   
    public function getParent()
    {
        return TrickType::class;
    }


}
