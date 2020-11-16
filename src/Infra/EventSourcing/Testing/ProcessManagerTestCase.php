<?php declare(strict_types=1);

namespace Infra\EventSourcing\Testing;

use Infra\Testing\ScenarioTestRunner;
use Infra\Testing\TestScenario;
use PHPUnit\Framework\TestCase;

/**
 * @copyright Marijn Huizendveld 2020. All rights reserved.
 */
abstract class ProcessManagerTestCase extends TestCase implements ScenarioTestRunner {

    /** @var \Infra\EventSourcing\Testing\ProcessManagerScenario */
    protected $scenario;

    protected function setUp () {
        parent::setUp();
        $this->scenario = new ProcessManagerScenario(
        // TODO inject required services
        );
    }

    protected function assertPreConditions () {
        parent::assertPreConditions();
        assertThat($this->scenario, isInstanceOf(TestScenario::class));
    }

    function scenario (): TestScenario {
        return $this->scenario;
    }
}
