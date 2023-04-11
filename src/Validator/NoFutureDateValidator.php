<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoFutureDateValidator extends ConstraintValidator
{
  public function validate($value, Constraint $constraint)
  {
    if ($value > new \DateTime()) {
      $this->context->buildViolation($constraint->message)
        ->setParameter('{{ value }}', $value->format('d/m/Y'))
        ->addViolation();
    }
  }
}
