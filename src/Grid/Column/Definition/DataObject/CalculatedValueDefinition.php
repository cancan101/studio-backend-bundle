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

namespace Pimcore\Bundle\StudioBackendBundle\Grid\Column\Definition\DataObject;

use Override;
use Pimcore\Bundle\StudioBackendBundle\Grid\Column\FieldDefinitionAwareColumnDefinitionInterface;
use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\Data\CalculatedValue;

/**
 * @internal
 */
final readonly class CalculatedValueDefinition extends AbstractDefinition implements
    FieldDefinitionAwareColumnDefinitionInterface
{
    public function getType(): string
    {
        return 'data-object.calculatedValue';
    }

    public function getFrontendType(): string
    {
        return 'calculatedValue';
    }

    #[Override]
    public function isSortable(): bool
    {
        return false;
    }

    #[Override]
    public function isFilterable(): bool
    {
        return false;
    }

    public function isFilterableForFieldDefinition(Data $fieldDefinition): bool
    {
        return $this->isSafeForFiltering($fieldDefinition);
    }

    public function isSortableForFieldDefinition(Data $fieldDefinition): bool
    {
        return $this->isSafeForFiltering($fieldDefinition);
    }

    /**
     * Calculated value snapshots are only trustworthy for querying when the field is declared
     * safe for filtering; the declaration requires a pimcore version whose CalculatedValue
     * definition carries the flag, hence the method_exists guard.
     */
    private function isSafeForFiltering(Data $fieldDefinition): bool
    {
        return $fieldDefinition instanceof CalculatedValue
            && method_exists($fieldDefinition, 'getSafeForFiltering')
            && $fieldDefinition->getSafeForFiltering();
    }
}
