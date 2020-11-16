<?php declare(strict_types=1);

namespace TicketBlaster\ExperimentalTicketChecking;

use Infra\EventSourcing\Testing\EventSourcedCommandHandlerTestCase;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class CheckTicketTest extends EventSourcedCommandHandlerTestCase {

    /** @test */
    function Ticket Holder presents issued Ticket that has NOT been used (): void {
        self::markTestIncomplete();
    }

    /** @test */
    function Ticket Holder presents Ticket that has NOT been issued (): void {
        self::markTestIncomplete();
    }

    /** @test */
    function Ticket Holder presents issued Ticket that has been used before (): void {
        self::markTestIncomplete();
    }
}
