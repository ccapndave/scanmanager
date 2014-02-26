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
            ->add('type')
            ->add('date')
            ->add('sender')
            ->add('mimeType')
            ->add('filename');
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
