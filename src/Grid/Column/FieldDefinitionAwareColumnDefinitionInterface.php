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

namespace Pimcore\Bundle\StudioBackendBundle\Grid\Column;

use Pimcore\Model\DataObject\ClassDefinition\Data;

/**
 * Column definitions whose filterability or sortability depends on the concrete field
 * definition (e.g. calculated values, which are only filterable when the field is declared
 * safe for filtering) implement this in addition to ColumnDefinitionInterface.
 */
interface FieldDefinitionAwareColumnDefinitionInterface
{
    public function isFilterableForFieldDefinition(Data $fieldDefinition): bool;

    public function isSortableForFieldDefinition(Data $fieldDefinition): bool;
}
