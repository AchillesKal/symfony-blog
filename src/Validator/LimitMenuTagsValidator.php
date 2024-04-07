<?php

namespace App\Validator;

use App\Repository\TagRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class LimitMenuTagsValidator extends ConstraintValidator
{
    public function __construct(private TagRepository $tagRepository)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof LimitMenuTags) {
            throw new UnexpectedTypeException($constraint, LimitMenuTags::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (true === $value && $this->tagRepository->count(['isMenu' => true]) > 5) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
