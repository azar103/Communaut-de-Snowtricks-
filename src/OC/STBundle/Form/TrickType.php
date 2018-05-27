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

class TrickType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
                 ->add('description', TextareaType::class)
                 ->add('image', ImageType::class)
                 ->add('singleCategory', EntityType::class, array(
                     'class' => 'OCSTBundle:Category', 
                     'choice_label' => 'name' ,
                     'multiple' => false
                 ))              
                 ->add('video', VideoType::class)
                 ->add('save', SubmitType::class)
                 ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\STBundle\Entity\Trick'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_stbundle_trick';
    }


}
