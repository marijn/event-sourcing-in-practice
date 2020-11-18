<?php declare(strict_types=1);

namespace Infra\EventSourcing\Aggregates;

use Infra\EventSourcing\Events;
use Infra\EventSourcing\EventStore;
use Infra\EventSourcing\EventStreamId;
use RuntimeException;
use Throwable;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class EventSourcedAggregateRepository {

    private $eventStore;
    private $type;

    function __construct (EventStore $eventStore, string $type) {
        $this->eventStore = $eventStore;
        $this->type = $type;
    }

    /**
     * @api
     * @throws \Infra\EventSourcing\Aggregates\SorryAggregateCouldNotBeFound
     */
    function getById (EventStreamId $id): EventSourcedAggregateRoot {
        $events = $this->eventStore->identifiedByEventSource($id);

        if (0 === $events->count())
        {
            throw new SorryAggregateCouldNotBeFound($id);
        }

        /** @var \Infra\EventSourcing\Aggregates\EventSourcedAggregateRoot $aggregate */
        $aggregate = $this->type;

        return $aggregate::reconstituteFromEvents($events);
    }

    /**
     * Add aggregates to the repository in one atomic operation.
     *
     * @api
     */
    function add (EventSourcedAggregateRoot ... $aggregates): void {
        $changes = Events::empty();

        foreach ($aggregates as $aggregate)
        {
            $changes = $changes->merge($aggregate->releaseEvents());
        }

        $this->eventStore->commit($changes);
    }
}

final class SorryAggregateCouldNotBeFound extends RuntimeException {

    private $id;

    function __construct (EventStreamId $id, Throwable $previous = null) {
        $this->id = $id;

        parent::__construct("Sorry, aggregate identified by '{$this->id}' could not be found.", $code = null, $previous);
    }

    function id (): EventStreamId { return $this->id; }
}
