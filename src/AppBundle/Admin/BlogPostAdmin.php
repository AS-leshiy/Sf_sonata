<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use AppBundle\Entity\BlogPost;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BlogPostAdmin extends AbstractAdmin
{
    #public $supportsPreviewMode = true;
    
    protected function configureFormFields(FormMapper $formMapper)
    {        
        $formMapper
            ->with('Content', array('class' => 'col-md-9'))
                ->add('title', 'text')
                ->add('body', 'textarea', array(
                    'attr' => array('style'=>'height:350px')
                ))
            ->end()

            ->with('Meta data', array('class' => 'col-md-3'))
                ->add('category', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Category',
                    'choice_label' => 'name',
                ))
                ->add('category', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Category',
                    'property' => 'name',
                ))
            ->end()
                
            ->with('Properties', array('class' => 'col-md-3'))
                ->add('draft','checkbox', array(
                    'label' => 'Public',
                    'required' => false
                ))
            ->end()
                
            ->with('Image', array('class' => 'col-md-3'))
                ->add('image',null, array(
                    'required' => false
                ))
                ->add('imageFile', VichImageType::class, array(
                    'label' => false,
                    'required' => false
                ))
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('image','imageFile', array('template' => 'admin/previewImg.html.twig'))
            ->addIdentifier('title', null, array(
            'route' => array(
                'name' => 'edit')
            ))                
            ->add('category.name')
            ->add('draft')
            ->add('_action', 'actions', array(
                'actions' => array(
                'show' => array(),
                'edit' => array(),
                )
            ))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Category',
                'choice_label' => 'name',
            ))
        ;
    }
    
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Content', array('class' => 'col-md-9'))
                ->add('title', 'text')
                ->add('body', 'textarea')
             ->end()
                
            ->with('Image', array('class' => 'col-md-3'))
                ->add('imageFile', null, array('template' => 'home/postImg.html.twig'))
            ->end()
        ;
    }
    
    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post';
    }
    
     public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'admin/edit.html.twig'; 
            default:
                return parent::getTemplate($name);
        }
    }

}
