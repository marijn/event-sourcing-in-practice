<?php declare(strict_types=1);

namespace Infra\EventSourcing\Aggregates;

use Infra\EventSourcing\DomainEvent;
use Infra\EventSourcing\Events;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
abstract class EventSourcedAggregateRoot {

    /** @var \Infra\EventSourcing\Events */
    protected $changes;

    final protected function __construct () {
        $this->changes = Events::empty();
    }

    final static function reconstituteFromEvents (Events $events): EventSourcedAggregateRoot {
        $aggregate = new static();

        foreach ($events as $event)
        {
            $aggregate->apply($event);
        }

        return $aggregate;
    }

    final protected function recordThat (DomainEvent ... $events): void {
        foreach ($events as $event)
        {
            $this->apply($event);
            $this->changes = $this->changes->add($event);
        }
    }

    final protected function apply (DomainEvent $event): void {
        $nameOfEvent = $this->nameOfEvent($event);
        $method = "apply" . $nameOfEvent;

        if (method_exists($this, $method))
        {
            $this->{$method}($event);
        }
    }

    final public function releaseEvents (): Events {
        $events = $this->changes;
        $this->changes = Events::empty();

        return $events;
    }

    final protected function nameOfEvent (DomainEvent $event): string {
        $parts = explode('\\', get_class($event));

        return end($parts);
    }
}
