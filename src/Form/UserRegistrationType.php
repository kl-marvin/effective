<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'Email'],
        ])
        ->add('password', PasswordType::class, [
            'label' => false,
             'required' => true,
             'attr' => ['placeholder' => 'Password'],  
        ])
        ->add('name', null, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'Last Name']
        ])
        ->add('firstName', null, [
            'label' => false,
            'required' => true,
            'attr' => ['placeholder' => 'First Name'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
