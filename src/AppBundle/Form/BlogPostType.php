<?php

namespace AppBundle\Form;

use AppBundle\Entity\BlogPost;
use AppBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BlogPostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr'=>['autofocus' => true],
                'required' => true,
                'label' => 'Title',
            ])
            ->add('category', 'entity', array(
                'class' => Category::class,
                'choice_label' => 'name',
            ))
            ->add('body', null, [
                'attr' => ['rows' => 20],
                'required' => true,
                'label' => 'Text',
            ])
            ->add('imageFile', VichImageType::class, array(
                'label' => false,
                'required' => false,
                'allow_delete' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BlogPost::class,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_blogpost';
    }
    
}
