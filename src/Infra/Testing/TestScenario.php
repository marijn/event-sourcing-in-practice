<?php declare(strict_types=1);

namespace Infra\Testing;

use Infra\Testing\ScenarioVisualization\VisualScenario;

/**
 * @copyright Marijn Huizendveld 2018. All rights reserved.
 */
interface TestScenario {

    /**
     * @param callable $subjectUnderTest
     *
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    function assert (callable $subjectUnderTest): void;

    function visualScenario(): VisualScenario;
}
