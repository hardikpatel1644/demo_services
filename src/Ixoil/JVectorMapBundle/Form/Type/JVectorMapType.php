<?php

namespace Ixoil\JVectorMapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Ixoil\JVectorMapBundle\Form\DataTransformer\RegionTransformer;

/**
 * Description of JVectorMapType
 *
 * @author OXIND
 */
class JVectorMapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regions', 'hidden')
            ->add('codes', 'hidden')
            ->addViewTransformer(new RegionTransformer());
    }
    
    /**
     * 
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['height'] = $options['height'];
        $view->vars['map'] = $options['map'];
        $view->vars['backgroundColor'] = $options['backgroundColor'];
        $view->vars['zoomButtons'] = $options['zoomButtons'];
        $view->vars['regionsSelectable'] = $options['regionsSelectable'];
        $view->vars['zoomOnScroll'] = $options['zoomOnScroll'];
        $view->vars['regionStyleInitial'] = $options['regionStyleInitial'];
        $view->vars['regionStyleHover'] = $options['regionStyleHover'];
        $view->vars['regionStyleSelected'] = $options['regionStyleSelected'];
        $view->vars['regionStyleSelectedHover'] = $options['regionStyleSelectedHover'];
        $view->vars['regionNamesInputId'] = $options['regionNamesInputId'];
        $view->vars['regionCodeInputId'] = $options['regionCodeInputId'];
    }
    
    /**
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'height' => '400px',
            'regionNamesInputId' => '',
            'regionCodeInputId' => '',
            'map'=>'fr_merc_en',
            
            'backgroundColor' => '#FFFFFF',
            'regionsSelectable' => 'true',
            'zoomButtons' => 'false',
            'zoomOnScroll' => 'false',
            'regionStyleInitial' => '{"fill": "#65BD77","fill-opacity": 1,"stroke": "none","stroke-width": 0,"stroke-opacity": 1}',
            'regionStyleHover'=> '{"fill-opacity": 0.8}',
            'regionStyleSelected'=> '{"fill": "#4CC0C1" }',
            'regionStyleSelectedHover' => '{}',
            
            'error_bubbling' => false
        ));
    }
    
    /**
     * 
     * @return string
     */
    public function getName()
    {
        return 'jvectormap';
    }

    /**
     * 
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }
}
