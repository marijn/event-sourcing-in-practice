<?php declare(strict_types=1);

namespace Infra\EventSourcing;

use ArrayIterator;
use Traversable;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class InMemoryEventStore implements EventStore
{
    private $events;

    public function __construct()
    {
        $this->events = new Events();
    }

    function commit(Events $events): void
    {
        $this->events = $this->events->merge($events);
    }

    function identifiedByEventSource(EventStreamId $eventStreamId): Events
    {
        return $this->events->filteredForEventStream($eventStreamId);
    }

    function getIterator (): Traversable {
        return new ArrayIterator($this->events);
    }
}
