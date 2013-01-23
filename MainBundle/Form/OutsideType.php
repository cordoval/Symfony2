<?php

namespace PHRentals\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use PHRentals\MainBundle\Entity\Contact as UnitOwner;
use PHRentals\MainBundle\Entity\Unit as UnitEntity;
use PHRentals\MainBundle\Entity\Contract as ContractEntity;
use PHRentals\MainBundle\Entity\ContractUnit;

class OutsideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'hidden')
            ->add('prefixName', 'choice', array('label' => 'Prefix', 'required' => false, 'choices' => UnitOwner::getPrefixList()))
            ->add('firstName', null, array('label' => 'First Name'))
            ->add('lastName', null, array('label' => 'Last Name'))
            ->add('age')
            ->add('nationality')
            ->add('web', null, array('label' => 'Website'))
            ->add('email', 'email', array('required' => false))
            ->add('email2', 'email', array('required' => false))
            ->add('tel')
            ->add('tel2')
            ->add('addressHome', null, array('label' => 'Home Address'))
            ->add('address', null, array('label' => 'Address in Thailand'))
            ->add('sameAsUnitAddress')

            ->add('class', 'hidden', array('data_class' => 'PHRentals\MainBundle\Entity\UnitClass', 'property_path' => FALSE))
            ->add('project', 'hidden', array('data_class' => 'PHRentals\MainBundle\Entity\Project', 'property_path' => FALSE,))
            ->add('num', null, array('label' => 'No.'))
            ->add('webTitle')
            ->add('ownership', 'choice', array('required' => false, 'choices' => array('Foreign'=>'Foreign Quota', 'Thai'=>'Thai Name', 'Company'=>'Thai Company Name')))
            ->add('description')
            ->add('livingArea', null, array('label' => 'Living Area (m²)', 'attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('landSize', null, array('label' => 'Land Size (m²)', 'attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('floor', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('unitType')
            ->add('bedrooms', 'choice', array('choices' => array('0','1','2','3','4','5','6','7','8')))
            ->add('bathrooms', 'choice', array('choices' => array('0','1','2','3','4')))
            ->add('sleeps', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('hasExtraBed')
            ->add('remarks')
            ->add('unit_tags', 'entity', array('label' => 'Unit Tags',
            		'class'         => 'PHRentals\MainBundle\Entity\UnitTag',
            		'multiple'      => true,
            		'expanded'      => true,
            		'query_builder' => function ($repository)
            		{
            			return $repository->createQueryBuilder('c')->orderBy('c.group, c.position', 'ASC');
            		},))

            ->add('addressUnit', null, array('label' => 'Property Address'))
            ->add('district')
            ->add('address_tags', 'entity', array('label' => 'Address Tags',
            		'class'         => 'PHRentals\MainBundle\Entity\AddressTag',
            		'multiple'      => true,
            		'expanded'      => true,
            		'query_builder' => function ($repository)
            		{
            			return $repository->createQueryBuilder('c')->orderBy('c.group, c.position', 'ASC');
            		},))
            ->add('distanceToBeach', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('unitsInBuilding', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('purposeSale', null, array('required' => false))
            ->add('purposeRent', null, array('required' => false))
            ->add('purposeRentHoliday', null, array('required' => false))
            ->add('agencyFee', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('agencyDepositRate', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('commNote')
            ->add('incontract', null, array('required' => false))
            //->add('availableFrom', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('availableFrom', 'genemu_jquerydate', array('attr' => array('class'=> 'short-input'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
            ->add('rentedDateFrom', 'genemu_jquerydate', array('attr' => array('class'=> 'short-input'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
            ->add('rentedDateTo', 'genemu_jquerydate', array('attr' => array('class'=> 'short-input'), 'widget' => 'single_text', 'format' => 'd/M/y', 'required' => false, 'years' => range(date('Y') - 20, date('Y') + 5)))
            ->add('rentedNote')
            ->add('inspection')
            ->add('keysAtLevel', 'choice', array('required' => false, 'choices' => ContractUnit::getkeysAtLevelList()))
            ->add('salePrice', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('negotiable', null, array('attr' => array('style' => 'top:5px;position:relative;"')))
            ->add('transferFeeBy', 'choice', array('required' => false, 'choices' => ContractUnit::getTransferFeeByList()))
            ->add('commNote')
            ->add('deposit')
            ->add('rentalDaily', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('rentalWeekly', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('rentalMonthly', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('rental3Months', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('rental6Months', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('rental1Year', 'money', array('attr' => array('class'=> 'baht-input'), 'required' => false, 'grouping' => false, 'currency' => 'THB', 'precision' => 0))
            ->add('highSeason', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('peakSeason', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('utilities')
            ->add('conditions')
            ->add('checkinTimes', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('checkoutTimes', null, array('attr' => array('class'=> 'short-input'), 'required' => false))
            ->add('isOwnerCaretaker')
            ->add('caretaker')
            ->add('caretakerPhone')
            ->add('caretakerEmail')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PHRentals\MainBundle\Entity\Outside'
        ));
    }

    public function getName()
    {
        return 'phrentals_mainbundle_outsidetype';
    }
}
