<?php declare(strict_types=1);

namespace Infra\EventSourcing\Testing;

use Infra\EventSourcing\Command;
use Infra\EventSourcing\Event;
use Infra\Testing\ScenarioVisualization\VisualScenario;
use Infra\Testing\ScenarioVisualization\StepDescription;
use Infra\Testing\TestScenario;
use PHPUnit\Framework\AssertionFailedError;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
final class ProcessManagerScenario implements TestScenario {

    private $given;

    private $when;

    private $then;

    function __construct () {
        $this->given = StepDescription::forHotspot('No preconditions', 'This scenario is completely autonomous');
        $this->when = StepDescription::forHotspot('No command', 'This scenario is likely incomplete');
        $this->then = StepDescription::forHotspot(
            'No outcome specified',
            'If this is desired change your test to use `thenNothing` to signal explicitly that nothing should happen.'
        );
    }

    function given (Event ...$events): ProcessManagerScenario {
        $this->given = StepDescription::forEvents(... $events);

        return $this;
    }

    function when (Event $event): ProcessManagerScenario {
        $this->when = StepDescription::forEvent($event);;

        return $this;
    }

    function thenEvent (Event $event): ProcessManagerScenario {
        $this->then = StepDescription::forEvent($event);

        return $this;
    }

    function thenCommand (Command $command): ProcessManagerScenario {
        $this->then = StepDescription::forCommand($command);

        return $this;
    }

    function thenNothing (): ProcessManagerScenario {
        $this->then = StepDescription::forHotspot('Nothing', 'No changes should be recorded');

        return $this;
    }

    /** @throws \PHPUnit\Framework\AssertionFailedError */
    function assert (): void {
        // TODO: Implement assert() method.
        throw new AssertionFailedError('Not yet implemented');
    }

    function visualScenario (): VisualScenario {
        return new VisualScenario(
            StepDescription::forScenario('Unknown scenario', 'You likely broke something in the visualization event listener'),
            $this->given,
            $this->when,
            $this->then
        );
    }
}
