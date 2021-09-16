<?php

/**
 * TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Assemblers;

/**
 * Interface for assembler implementation that provides functionality to assemble customer attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
interface CustomerAddressAttributeAssemblerInterface
{

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAddressAttributesByEntityId($entityId);
}
