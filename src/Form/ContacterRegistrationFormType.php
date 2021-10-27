<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/**
 * Description of ContacterRegistrationFormType
 *
 * @author vielf
 */
class ContacterRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,[
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
                
            ->add('email',EmailType::class, [
                'label' => 'Votre e-mail :',
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
                
            ->add('message',TextareaType::class,[
                'label' => 'Votre message :',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '5',
                ]
                ])
            
   
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          
        ]);
    }
}