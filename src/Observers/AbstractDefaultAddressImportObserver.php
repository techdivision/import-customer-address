<?php

/**
 * TechDivision\Import\Customer\Address\Observers\AbstractDefaultAddressImportObserver
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

use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Utils\ColumnKeys;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;
use TechDivision\Import\Customer\Observers\AbstractCustomerImportObserver;
use TechDivision\Import\Observers\StateDetectorInterface;

/**
 * Abstract class that provides the functionality to update a customers default
 * shipping and billing address.
 *
 * @author    Vadim Justus <v.justus@techdivision.com>
 * @author    Harald Deiser <h.deiser@techdivision.com>
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2019 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
abstract class AbstractDefaultAddressImportObserver extends AbstractCustomerImportObserver
{

    /**
     * The customer bunch processor instance.
     *
     * @var \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface
     */
    protected $customerBunchProcessor;

    /**
     * The mapping for the default billing/shipping address column => member name.
     *
     * @var array
     */
    protected $defaultAddressMapping = array(
        ColumnKeys::ADDRESS_DEFAULT_BILLING  => MemberNames::DEFAULT_BILLING,
        ColumnKeys::ADDRESS_DEFAULT_SHIPPING => MemberNames::DEFAULT_SHIPPING
    );

    /**
     * DefaultShippingObserver constructor.
     *
     * @param \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface $customerBunchProcessor The processor instance
     * @param \TechDivision\Import\Observers\StateDetectorInterface                  $stateDetector          The state detector instance
     */
    public function __construct(
        CustomerBunchProcessorInterface $customerBunchProcessor,
        StateDetectorInterface $stateDetector = null
    ) {
        parent::__construct($stateDetector);
        $this->customerBunchProcessor = $customerBunchProcessor;
    }

    /**
     * Returns the customer bunch processor instance.
     *
     * @return \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface The processor instance
     */
    protected function getCustomerBunchProcessor()
    {
        return $this->customerBunchProcessor;
    }

    /**
     * Maps the passed customer address column name to the matching customer member name.
     *
     * @param string $columnName The column name to map
     *
     * @return string The mapped customer member name
     * @throws \Exception Is thrown if the column can't be mapped
     */
    protected function mapColumName($columnName)
    {

        // query whether or not we can match the column name
        if (isset($this->defaultAddressMapping[$columnName])) {
            return $this->defaultAddressMapping[$columnName];
        }

        // throw an exception if NOT
        throw new \Exception(sprintf('Can\'t map member name to default address column "%s"', $columnName));
    }

    /**
     * Save default address by type.
     *
     * @param string      $type          The address type to save
     * @param string|null $changeSetName The change set name to use
     * @return void
     */
    protected function saveDefaultAddressByType($type, $changeSetName = null)
    {

        // load email and website ID
        $email     = $this->getValue(ColumnKeys::EMAIL);
        $websiteId = $this->getSubject()->getStoreWebsiteIdByCode($this->getValue(ColumnKeys::WEBSITE));

        // try to load the customer with the given email + website ID
        if ($customer = $this->getCustomerBunchProcessor()->loadCustomerByEmailAndWebsiteId($email, $websiteId)) {
            // initialize an empty address ID
            $addressId = null;

            // query whether or not we've a default shipping/billing address
            if ((integer) $this->getValue($type) === 1) {
                $addressId = $this->getSubject()->getLastEntityId();
            } else {
                // Don't update address when not marked as default
                // Prevent resetting default address
                return;
            }

            $customerMerged = $this->mergeEntity(
                $customer,
                array(
                    $this->mapColumName($type) => $addressId,
                    MemberNames::UPDATED_AT    => $this->formatDate(date($this->getSourceDateFormat()))
                ),
                $changeSetName
            );

            // finally update the customer if relation has changed
            if ($this->hasChanges($customerMerged)) {
                $this->getCustomerBunchProcessor()->persistCustomer($customerMerged);
            }
        }
    }
}
