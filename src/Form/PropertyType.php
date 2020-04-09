<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('price')
            ->add('adresse')
            ->add('city')
            ->add('rooms')
            ->add('bedrooms')
            ->add('sold')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoice()
            ])
            ->add('adresse_code')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
    public function getChoice()
    {
        $choice = Property::HEAT;
        $output = [];
        foreach($choice as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
