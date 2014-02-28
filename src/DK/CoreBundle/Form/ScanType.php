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
                'widget' => 'single_text'
            ))
            ->add('type')
            ->add('sender')
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
