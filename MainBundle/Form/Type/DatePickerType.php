<?php

namespace PHRentals\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatePickerType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yy',
            'attr' => array(
                'autocomplete' => 'off',
                'class' => 'phrentals_date_picker',
            ),
        );
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    		$resolver->setDefaults(array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yy',
            'attr' => array(
                'autocomplete' => 'off',
                'class' => 'phrentals_date_picker',
            ),
        ));
    }

    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'date_picker';
    }
}