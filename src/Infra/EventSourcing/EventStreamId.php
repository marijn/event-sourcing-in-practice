<?php declare(strict_types=1);

namespace Infra\EventSourcing;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class EventStreamId {

    private $id;

    private function __construct (string $id) {
        $this->id = $id;
    }

    static function fromString (string $idOfEventStream): EventStreamId {
        return new EventStreamId($idOfEventStream);
    }

    function equals (EventStreamId $other): bool {
        return $other->id === $this->id;
    }

    function __toString (): string {
        return $this->id;
    }
}
