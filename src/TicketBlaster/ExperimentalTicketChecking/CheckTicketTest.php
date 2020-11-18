<?php declare(strict_types=1);

namespace TicketBlaster\ExperimentalTicketChecking;

use Faker\Factory;
use Infra\Clock\Clock;
use Infra\Clock\PointInTime;
use Infra\EventSourcing\CommandHandler;
use Infra\EventSourcing\Events;
use Infra\EventSourcing\EventStore;
use Infra\EventSourcing\Testing\EventSourcedCommandHandlerTestCase;
use Infra\Standards;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class CheckTicketTest extends EventSourcedCommandHandlerTestCase {

    /**
     * @test
     * @dataProvider provide showId ticketId and usedAt
     */
    function Ticket Holder presents issued Ticket that has NOT been used (
        string $showId,
        string $ticketId,
        string $usedAt
    ): void {
        $this->scenario
            ->given(
                TicketWasIssued
                    ::withShowId($showId)
                    ->andWithTicketId($ticketId)
            )
            ->assumingItIsNow(PointInTime::fromString($usedAt))
            ->when(
                new CheckTicket(
                    $showId,
                    $ticketId
                )
            )
            ->then(
                new TicketWasUsed(
                    $showId,
                    $ticketId,
                    $usedAt
                )
            )
            ->assert(function (EventStore $eventStore, Clock $clock) {
                return new CheckTicketCommandHandler($eventStore, $clock);
            });
    }

    /**
     * @test
     * @dataProvider provide showId ticketId and checkedAt
     */
    function Ticket Holder presents Ticket that has NOT been issued (
        string $showId,
        string $ticketId,
        string $checkedAt
    ): void {
        $this->scenario
            ->assumingItIsNow(PointInTime::fromString($checkedAt))
            ->when(
                new CheckTicket(
                    $showId,
                    $ticketId
                )
            )
            ->then(
                new CounterfeitTicketChecked(
                    $showId,
                    $ticketId,
                    $checkedAt
                )
            )
            ->assert(function (EventStore $eventStore, Clock $clock) {
                return new CheckTicketCommandHandler($eventStore, $clock);
            });
    }

    /**
     * @test
     * @dataProvider provide showId ticketId and usedAt
     */
    function Ticket Holder presents issued Ticket that has been used before (
        string $showId,
        string $ticketId,
        string $usedAt
    ): void {
        $this->scenario
            ->given(
                TicketWasIssued
                    ::withShowId($showId)
                    ->andWithTicketId($ticketId),
                TicketWasUsed
                    ::withShowId($showId)
                    ->andWithTicketId($ticketId)
            )
            ->assumingItIsNow(PointInTime::fromString($usedAt))
            ->when(
                new CheckTicket(
                    $showId,
                    $ticketId
                )
            )
            ->then(
                new UsedTicketWasChecked(
                    $showId,
                    $ticketId,
                    $usedAt
                )
            )
            ->assert(function (EventStore $eventStore, Clock $clock) {
                return new CheckTicketCommandHandler($eventStore, $clock);
            });
    }

    /** @test */
    function Ticket Holder presents issued Ticket that has been used 2 seconds earlier (): void {
        self::markTestIncomplete();
    }

    static function provide showId ticketId and usedAt (): array {
        $faker = Factory::create();

        return [
            'with consistent example data' => [
                'showId' => "show:{$faker->uuid}",
                'ticketId' => "ticket:{$faker->hexColor}",
                'usedAt' => $faker->dateTimeThisYear('5 seconds ago', 'UTC')->format(Standards::dateTimeFormat),
            ],
        ];
    }

    static function provide showId ticketId and checkedAt (): array {
        $faker = Factory::create();

        return [
            'with consistent example data' => [
                'showId' => "show:{$faker->uuid}",
                'ticketId' => "ticket:{$faker->hexColor}",
                'checkedAt' => $faker->dateTimeThisYear('5 seconds ago', 'UTC')->format(Standards::dateTimeFormat),
            ],
        ];
    }
}

final class CheckTicketCommandHandler implements CommandHandler {

    private $eventStore;
    private $clock;

    function __construct (EventStore $eventStore, Clock $clock) {
        $this->eventStore = $eventStore;
        $this->clock = $clock;
    }

    function handle(CheckTicket $command): void {
        $events = new Events(
            new TicketWasUsed(
                $command->showId(),
                $command->ticketId(),
                (string) $this->clock->now()
            )
        );

        $this->eventStore->commit($events);
    }
}
