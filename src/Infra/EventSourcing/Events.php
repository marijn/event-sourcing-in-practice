<?php declare(strict_types=1);

namespace Infra\EventSourcing;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class Events implements Countable, JsonSerializable, IteratorAggregate
{
    private $events;

    function __construct(DomainEvent ... $events)
    {
        $this->events = $events;
    }

    static function empty(): Events
    {
        return new Events();
    }

    function merge(Events $anotherCollection): Events
    {
        $newEvents = Events::empty();
        $newEvents->events = array_merge($this->events, $anotherCollection->events);

        return $newEvents;
    }

    function add(DomainEvent $event): Events
    {
        $newEvents = clone $this;
        $newEvents->events[] = $event;

        return $newEvents;
    }

    function filteredForEventStream(EventStreamId $eventStream)
    {
        $filteredCollection = new Events();
        $filteredCollection->events = array_filter($this->events, function (DomainEvent $event) use ($eventStream) {
            return $event->EventStreamId()->equals($eventStream);
        });

        return $filteredCollection;
    }

    function count(): int
    {
        return count($this->events);
    }

    function jsonSerialize()
    {
        return $this->events;
    }

    function getIterator()
    {
        return new ArrayIterator($this->events);
    }
}
