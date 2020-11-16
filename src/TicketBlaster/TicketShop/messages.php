Warning: Invalid argument supplied for foreach() in /Users/marijn/Sites/do-it-yourself-event-sourcing-tooling-examples/src/Infra/EventSourcing/CodeGeneration/MessagesCodeGenerator.php on line 242
<?php declare(strict_types=1);
/**
 * WARNING! This file has been generated.
 *
 * Modify by changing the underlying DSL. Convention stipulates that the file has an identical filename with a .yaml extension.
 * Are you a first-timer? Ask someone to help you. Have a nice day :-)
 *
 * @see \Infra\EventSourcing\CodeGeneration\MessagesCodeGenerator
 */

namespace TicketBlaster\TicketShop {

    /**
     * @api
     * @category generated
     */
    final class TicketWasSold implements \Infra\EventSourcing\Event {

        /**
         * @param string $ticketId
         * @param string $soldAt
         *
         * @api
         */
        function __construct (
            string $ticketId,
            string $soldAt
        ) {
            $this->ticketId = $ticketId;
            $this->soldAt = $soldAt;
        }

        private const exampleValues = [
            'ticketId' => 'ticket:A43CX2',
            'soldAt' => '2017-04-12 12:12:01.999999+0000',
        ];

        static function withTicketId (string $ticketId): TicketWasSold {
            $payload = TicketWasSold::exampleValues;
            $payload['ticketId'] = $ticketId;

            return TicketWasSold::fromPayload($payload);
        }

        static function fromPayload (array $payload): TicketWasSold {
            return new TicketWasSold(
                $payload['ticketId'],
                $payload['soldAt']
            );
        }

        function andWithSoldAt (string $soldAt): TicketWasSold {
            $modified = clone $this;
            $modified->soldAt = $soldAt;

            return $modified;
        }

        private $ticketId;

        function ticketId (): string {
            return $this->ticketId;
        }

        private $soldAt;

        function soldAt (): string {
            return $this->soldAt;
        }

        function rawMessagePayload (): array {
            return [
                'ticketId' => $this->ticketId,
                'soldAt' => $this->soldAt,
            ];
        }
    }
}
