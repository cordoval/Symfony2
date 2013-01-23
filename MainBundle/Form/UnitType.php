<?php

namespace PHRentals\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pRef')
            ->add('name')
            ->add('description')
            ->add('unitNumber')
            ->add('roomNumber')
            ->add('floor')
            ->add('livingArea')
            ->add('landSize')
            ->add('bedrooms')
            ->add('bathrooms')
            ->add('sleeps')
            ->add('hasExtraBed')
            ->add('keysAtLevel')
            ->add('keysAtText')
            ->add('preferenceLevel')
            ->add('acceptablePayment')
            ->add('baseRate')
            ->add('highSeason')
            ->add('peakSeason')
            ->add('baseTo6m')
            ->add('baseTo3m')
            ->add('baseTo1m')
            ->add('baseTo1w')
            ->add('baseTo1d')
            ->add('dailyNotes')
            ->add('weeklyNotes')
            ->add('monthlyNotes')
            ->add('yearlyNotes')
            ->add('checkinTimes')
            ->add('checkoutTimes')
            ->add('otherNotes')
            ->add('paymentTypes', null, array('required' => false, 'expanded' => true, 'multiple' => true))
            ->add('tags', null, array('required' => false, 'expanded' => true, 'multiple' => true))
            ->add('owner')
            ->add('unitType')
            ->add('unitSize')
            ->add('address')
        ;
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PHRentals\MainBundle\Entity\Unit'
        ));
    }

    public function getName()
    {
        return 'phrentals_mainbundle_unittype';
    }
}
