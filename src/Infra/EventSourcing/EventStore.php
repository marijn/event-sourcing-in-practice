<?php declare(strict_types=1);

namespace Infra\EventSourcing;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
interface EventStore {

    function commit (Events $events): void;

    function identifiedByEventSource (EventStreamId $eventStreamId): Events;
}
