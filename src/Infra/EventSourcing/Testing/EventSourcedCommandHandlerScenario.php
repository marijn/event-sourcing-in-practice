<?php declare(strict_types=1);

namespace Infra\EventSourcing\Testing;

use Infra\Clock\PointInTime;
use Infra\EventSourcing\Command;
use Infra\EventSourcing\DomainEvent;
use Infra\Testing\ScenarioVisualization\VisualScenario;
use Infra\Testing\ScenarioVisualization\StepDescription;
use Infra\Testing\TestScenario;
use PHPUnit\Framework\AssertionFailedError;

/**
 * @copyright Marijn Huizendveld 2018. All rights reserved.
 */
final class EventSourcedCommandHandlerScenario implements TestScenario {

    private $given;
    private $when;
    private $then;

    private $outcomes;
    private $action;
    private $preConditions;
    private $timeAssumption;

    function __construct () {
        $this->given = StepDescription::forHotspot('No preconditions', 'This scenario is completely autonomous');
        $this->when = StepDescription::forHotspot('No command', 'This scenario is likely incomplete');
        $this->then = StepDescription::forHotspot('No outcome specified', 'If this is desired change your test to use `thenNothing` to signal explicitly that nothing should happen.');
        $this->timeAssumption = PointInTime::epoch();
    }

    function given (DomainEvent ...$events): EventSourcedCommandHandlerScenario {
        $this->given = StepDescription::forEvents(... $events);
        $this->preConditions = $events;

        return $this;
    }

    function when(Command $command): EventSourcedCommandHandlerScenario {
        $this->when = StepDescription::forCommand($command);;
        $this->action = $command;

        return $this;
    }

    function then (DomainEvent $event): EventSourcedCommandHandlerScenario {
        $this->then = StepDescription::forEvent($event);
        $this->outcomes = [$event];

        return $this;
    }

    function thenNothing(): EventSourcedCommandHandlerScenario {
        $this->then = StepDescription::forHotspot('Nothing', 'No changes should be recorded');

        return $this;
    }

    function assumingItIsNow(PointInTime $time): EventSourcedCommandHandlerScenario {
        $this->timeAssumption = $time;

        return $this;
    }

    /**
     * @param callable $subjectUnderTest
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    function assert (callable $subjectUnderTest): void {
        throw new AssertionFailedError(
            'Not yet implemented'
        );
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
