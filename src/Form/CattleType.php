<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Validator\NoFutureDate;

class CattleType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('cod', IntegerType::class, [
        'label' => 'Código do animal',
        'invalid_message' => 'Preencha com um valor válido',
      ])

      ->add('milk', NumberType::class, [
        'label' => 'Litros de leite por semana',
        'invalid_message' => 'Preencha com um valor válido',
      ])

      ->add('week_portion', NumberType::class, [
        'label' => 'Ração em kg por semana',
        'invalid_message' => 'Preencha com um valor válido',
      ])

      ->add('cattle_weight', NumberType::class, [
        'label' => 'Peso do animal',
        'invalid_message' => 'Preencha com um valor válido',
      ])

      ->add('birth', BirthdayType::class, [
        'format' => 'dd MMMM yyyy',
        'placeholder' => [
          'day' => 'Selecione o dia',
          'month' => 'Selecione o mês',
          'year' => 'Selecione o ano',
        ],
        'label' => 'Data de nascimento',
        'constraints' => [
          new NoFutureDate(),
        ],
      ]);
  }

  // Configura a label para o nome do primeiro parametro do método add acima
  // public function configureOptions(OptionsResolver $resolver)
  // {
  //   $resolver->setDefaults([
  //     'data_class' => Cattle::class
  //   ]);
  // }
}
