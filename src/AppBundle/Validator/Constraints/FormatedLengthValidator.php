<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FormatedLengthValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FormatedLength) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\FormatedLength');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $stringValue = (string) $value;

        $length = strlen(strip_tags(html_entity_decode(str_replace(["\n", "\t"], '', $stringValue))));

        if (null !== $constraint->max && $length > $constraint->max) {
            $this->buildViolation($constraint->min == $constraint->max ? $constraint->exactMessage : $constraint->maxMessage)
                ->setParameter('{{ value }}', $this->formatValue($stringValue))
                ->setParameter('{{ limit }}', $length . '|' . $stringValue)
                ->setInvalidValue($value)
                ->setPlural((int) $constraint->max)
                ->setCode(FormatedLength::TOO_LONG_ERROR)
                ->addViolation();

            return;
        }
    }
}
