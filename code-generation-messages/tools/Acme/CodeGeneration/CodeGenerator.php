<?php declare(strict_types=1);

namespace Acme\CodeGeneration;

/**
 * @copyright Marijn Huizendveld 2018. All rights reserved.
 */
final class CodeGenerator {

    function generate(array $dsl): string {
        $namespaces = [];

        foreach ($dsl as $module => $moduleSpecification)
        {
            $namespaces[] = <<<PHP
namespace {$module} {
{$this->generateEvents($moduleSpecification['events'])}
}
PHP;
        }

        $code = implode(PHP_EOL, $namespaces);

        return <<<PHP
<?php declare(strict_types=1);

/**
 * WARNING! This file has been generated.
 *
 * Modify by changing the underlying DSL. Convention stipulates that the file has an identical filename with a .yaml extension.
 * Are you a first-timer? Ask someone to help you. Have a nice day :-)
 *
 * @see \Acme\CodeGeneration\CodeGenerator
 */

{$code}

PHP;
    }

    private function generateMessageConstructor (array $messageSpecification): string {
        $constructorParametersCode = $this->generateConstructorParametersList($messageSpecification);
        $constructorAttributesCode = $this->generateConstructorAttributeAssignment($messageSpecification);

        return <<<PHP
function __construct(
    {$constructorParametersCode}
) {
    {$constructorAttributesCode}
}
PHP;
    }

    private function generateMessageAttributes (array $messageSpecification): string {
        $eventAttributes = [];

        foreach ($messageSpecification['attributes'] as $attribute => $attributeSpecification)
        {
            $typeConstraint = $this->typeConstraintOfAttribute($attributeSpecification);
            $eventAttributes[] = <<<PHP
private \${$attribute};
function {$attribute}(): {$typeConstraint} { return \$this->{$attribute}; }
PHP;
        }

        $eventAttributesCode = implode(PHP_EOL, $eventAttributes);

        return $eventAttributesCode;
    }

    private function generateEvent (string $eventClassName, array $eventSpecification): string {
        $docBlocks = [];

        if (array_key_exists('doc', $eventSpecification))
        {
            $docBlocks[] = $eventSpecification['doc'];
            $docBlocks[] = '';
        }

        $docBlocks[] = '@category generated';
        $docBlock = implode(PHP_EOL.' * ', $docBlocks);

        return <<<PHP
/**
 * {$docBlock}
 */
final class {$eventClassName} implements \Acme\Infra\EventSourcing\Event {
{$this->generateMessageConstructor($eventSpecification)}
{$this->generateMessageAttributes($eventSpecification)}
}
PHP;
    }

    private function generateEvents (array $eventSpecifications): string {
        $events = [];

        foreach ($eventSpecifications as $event => $eventSpecification)
        {
            $events[] = $this->generateEvent($event, $eventSpecification);
        }

        return implode(PHP_EOL, $events);
    }

    private function typeConstraintOfAttribute (array $attributeSpecification = null): string {
        return is_array($attributeSpecification) && array_key_exists('constrainType', $attributeSpecification)
            ? $attributeSpecification['constrainType']
            : "string";
    }

    private function generateConstructorParametersList (array $messageSpecification): string {
        $constructorParameters = [];

        foreach ($messageSpecification['attributes'] as $attribute => $attributeSpecification)
        {
            $typeConstraint = $this->typeConstraintOfAttribute($attributeSpecification);
            $constructorParameters[] = <<<PHP
{$typeConstraint} \${$attribute},
PHP;
        }

        return rtrim(implode(PHP_EOL, $constructorParameters), ',');
    }

    private function generateConstructorAttributeAssignment (array $messageSpecification): string {
        $constructorAttributes = [];

        foreach ($messageSpecification['attributes'] as $attribute1 => $attributeSpecification)
        {
            $constructorAttributes[] = <<<PHP
\$this->{$attribute1} = \${$attribute1};
PHP;
        }

        $constructorAttributesCode = implode(PHP_EOL, $constructorAttributes);

        return $constructorAttributesCode;
    }
}
