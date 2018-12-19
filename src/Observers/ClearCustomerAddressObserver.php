<?php

/**
 * TechDivision\Import\Customer\Address\Observers\ClearCustomerAddressObserver
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Observers;

use TechDivision\Import\Customer\Address\Utils\ColumnKeys;
use TechDivision\Import\Customer\Address\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;

/**
 * Observer that removes the customer address with the identifier found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class ClearCustomerAddressObserver extends AbstractCustomerAddressImportObserver
{

    /**
     * The customer address bunch processor instance.
     *
     * @var \TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface
     */
    protected $customerAddressBunchProcessor;

    /**
     * Initialize the observer with the passed customer bunch processor instance.
     *
     * @param \TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface $customerAddressBunchProcessor The customer address bunch processor instance
     */
    public function __construct(CustomerAddressBunchProcessorInterface $customerAddressBunchProcessor)
    {
        $this->customerAddressBunchProcessor = $customerAddressBunchProcessor;
    }

    /**
     * Return's the customer address bunch processor instance.
     *
     * @return \TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface The customer address bunch processor instance
     */
    protected function getCustomerAddressBunchProcessor()
    {
        return $this->customerAddressBunchProcessor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // load the entity ID
        ;

        // query whether or not, we've found a new entity ID => means we've found a new customer address
        if ($this->isLastEntityId($entityId = $this->getValue(ColumnKeys::ENTITY_ID))) {
            return;
        }

        // delete the customer address with the passed entity ID
        $this->deleteCustomerAddress(array(MemberNames::ENTITY_ID => $entityId));

        // flush the cache to remove the deleted customer address (which has previously been cached)
        $this->getCustomerAddressBunchProcessor()->cleanUp();
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteCustomerAddress($row, $name = null)
    {
        $this->getCustomerAddressBunchProcessor()->deleteCustomerAddress($row, $name);
    }
}
