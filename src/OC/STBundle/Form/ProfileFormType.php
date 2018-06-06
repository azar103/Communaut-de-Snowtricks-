<?php
namespace OC\STBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ProfileFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('editer',   submitType::class)
                ;
    }/**
     * {@inheritdoc}
     */
    public function getParent() 
    {
    return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getParent(){
    {     
    return 'app_user_profile';
    }
}
    // For Symfony 2.x
   public function getName()
   {
    return $this->getBlockPrefix();
   }
}