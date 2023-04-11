<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class NoFutureDate extends Constraint
{
  public $message = 'A data não pode ser uma data futura!! Escolha uma data antes de "{{ value }}"';

  public function validatedBy()
  {
    return static::class . 'Validator';
  }
}
