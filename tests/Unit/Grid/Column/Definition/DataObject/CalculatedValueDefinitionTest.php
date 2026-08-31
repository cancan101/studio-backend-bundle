<?php
declare(strict_types=1);

/**
 * This source file is available under the terms of the
 * Pimcore Open Core License (POCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (https://www.pimcore.com)
 *  @license    Pimcore Open Core License (POCL)
 */

namespace Pimcore\Bundle\StudioBackendBundle\Tests\Unit\Grid\Column\Definition\DataObject;

use Codeception\Test\Unit;
use Pimcore\Bundle\StudioBackendBundle\Grid\Column\Definition\DataObject\CalculatedValueDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Data\CalculatedValue;
use Pimcore\Model\DataObject\ClassDefinition\Data\Input;

/**
 * @internal
 */
final class CalculatedValueDefinitionTest extends Unit
{
    private CalculatedValueDefinition $definition;

    protected function setUp(): void
    {
        $this->definition = new CalculatedValueDefinition();
    }

    public function testGetType(): void
    {
        $this->assertSame('data-object.calculatedValue', $this->definition->getType());
    }

    public function testGetFrontendType(): void
    {
        $this->assertSame('calculatedValue', $this->definition->getFrontendType());
    }

    public function testIsNotSortableByDefault(): void
    {
        $this->assertFalse($this->definition->isSortable());
    }

    public function testIsNotFilterableByDefault(): void
    {
        $this->assertFalse($this->definition->isFilterable());
    }

    public function testFieldDeclaredSafeForFilteringIsFilterableAndSortable(): void
    {
        $fieldDefinition = $this->createCalculatedValue(safeForFiltering: true);

        $this->assertTrue($this->definition->isFilterableForFieldDefinition($fieldDefinition));
        $this->assertTrue($this->definition->isSortableForFieldDefinition($fieldDefinition));
    }

    public function testFieldNotDeclaredSafeForFilteringStaysNonFilterable(): void
    {
        $fieldDefinition = $this->createCalculatedValue(safeForFiltering: false);

        $this->assertFalse($this->definition->isFilterableForFieldDefinition($fieldDefinition));
        $this->assertFalse($this->definition->isSortableForFieldDefinition($fieldDefinition));
    }

    public function testCalculatedValueWithoutTheFlagStaysNonFilterable(): void
    {
        $this->assertFalse($this->definition->isFilterableForFieldDefinition(new CalculatedValue()));
        $this->assertFalse($this->definition->isSortableForFieldDefinition(new CalculatedValue()));
    }

    public function testOtherFieldDefinitionsStayNonFilterable(): void
    {
        $this->assertFalse($this->definition->isFilterableForFieldDefinition(new Input()));
        $this->assertFalse($this->definition->isSortableForFieldDefinition(new Input()));
    }

    private function createCalculatedValue(bool $safeForFiltering): CalculatedValue
    {
        // Subclass carrying the safe-for-filtering declaration so the test does not depend on a
        // pimcore version that already ships the flag on CalculatedValue.
        return new class($safeForFiltering) extends CalculatedValue {
            public function __construct(private readonly bool $safe)
            {
            }

            public function getSafeForFiltering(): bool
            {
                return $this->safe;
            }
        };
    }
}
