<?php

namespace DK\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScanType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('date', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('notBill')
            ->add('paid')
            ->add('paidOn', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('paidBy', 'genemu_jqueryautocomplete_text', array(
                'suggestions' => array('Char', 'Dave', 'Joint account'),
                'required' => false
            ))
            ->add('letterFor', 'genemu_jqueryautocomplete_text', array(
                'suggestions' => array('Char', 'Dave'),
                'required' => false,
                'label' => 'For'
            ))
            ->add('tags', 'genemu_jqueryselect2_entity', array(
                'class' => 'DK\CoreBundle\Entity\Tag',
                'multiple' => true
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'DK\CoreBundle\Entity\Scan'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'dk_corebundle_scan';
    }

}
