<?php

/**
 * TechDivision\Import\Customer\Address\Observers\DefaultShippingAddressImportObserver
 *
 * PHP version 7
 *
 * @author    Vadim Justus <v.justus@techdivision.com>
 * @author    Harald Deiser <h.deiser@techdivision.com>
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Observers;

use TechDivision\Import\Customer\Address\Utils\ColumnKeys;

/**
 * Updates the default shipping address in the customer entity AFTER the address has been imported.
 *
 * @author    Vadim Justus <v.justus@techdivision.com>
 * @author    Harald Deiser <h.deiser@techdivision.com>
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class DefaultShippingAddressImportObserver extends AbstractDefaultAddressImportObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    protected function process()
    {
        $this->saveDefaultAddressByType(ColumnKeys::ADDRESS_DEFAULT_SHIPPING);
    }
}
