<?php

namespace App\EventListener;

use App\Util\TimestampableEntityTrait;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Clock\ClockInterface;

#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::preUpdate)]
class TimestampableEntityListener
{
    public function __construct(
        private ClockInterface $clock
    ) {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        if ($this->supportsTrait($entity = $args->getObject())) {
            $entity->setCreatedAt($now = $this->clock->now());
            $entity->setUpdatedAt($now);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        if ($this->supportsTrait($entity = $args->getObject())) {
            $entity->setUpdatedAt($this->clock->now());
        }
    }

    private function supportsTrait(object $entity): bool
    {
        return in_array(TimestampableEntityTrait::class, class_uses($entity));
    }
}
