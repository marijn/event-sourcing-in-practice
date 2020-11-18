<?php declare(strict_types=1);

namespace Infra\EventSourcing\Testing;

use Infra\EventSourcing\Events;
use Infra\EventSourcing\EventStore;
use Infra\EventSourcing\EventStreamId;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class TestingEventStore implements EventStore {

    private $eventStore;
    private $newEvents;
    private $enabled = false;

    function commit (Events $events): void {
        $this->eventStore->commit($events);

        if ($this->enabled)
        {
            $this->newEvents = $this->newEvents->merge($events);
        }
    }

    function identifiedByEventSource (EventStreamId $eventStreamId): Events {
        $this->eventStore->identifiedByEventSource($eventStreamId);
    }

    function trackNewEvents (): void { $this->enabled = true; }

    function newEvents (): Events { return $this->newEvents; }

    function __construct (EventStore $eventStore) {
        $this->eventStore = $eventStore;
        $this->newEvents = Events::empty();
    }
}
