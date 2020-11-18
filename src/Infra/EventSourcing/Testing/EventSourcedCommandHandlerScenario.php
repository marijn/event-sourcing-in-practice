<?php declare(strict_types=1);

namespace Infra\EventSourcing\Testing;

use Infra\Clock\ClockForTesting;
use Infra\Clock\PointInTime;
use Infra\EventSourcing\Command;
use Infra\EventSourcing\CommandHandler;
use Infra\EventSourcing\DomainEvent;
use Infra\EventSourcing\Events;
use Infra\EventSourcing\InMemoryEventStore;
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
        $clock = new ClockForTesting($this->timeAssumption);
        $eventStore = new TestingEventStore(new InMemoryEventStore());
        $commandHandler = $subjectUnderTest($eventStore, $clock);

        if ( ! $commandHandler instanceof CommandHandler)
        {
            throw new AssertionFailedError(
                'You made an error in the setup. The factory provided to the `assert` method did not return a `CommandHandler` instance. Possibly you experience runtime issues like classes that cannot be loaded.'
            );
        }

        if ( ! method_exists($commandHandler, 'handle'))
        {
            throw new AssertionFailedError(
                'You made an error in the setup. The subject under test does not implement a `handle` method.'
            );
        }

        $eventStore->commit(new Events(... $this->preConditions));
        $eventStore->trackNewEvents();

        $commandHandler->handle($this->action);

        $expectedEvents = $this->outcomes;
        $actualEvents = iterator_to_array($eventStore->newEvents());

        assertThat($actualEvents, equalTo($expectedEvents));
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
