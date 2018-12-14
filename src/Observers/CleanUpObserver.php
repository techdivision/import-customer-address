<?php

/**
 * TechDivision\Import\Customer\Address\Observers\CleanUpObserver
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
 * @link      https://github.com/techdivision/import-product
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Observers;

use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;
use TechDivision\Import\Customer\Address\Utils\ColumnKeys;

/**
 * An observer implementation that handles the process to import customer address bunches.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product
 * @link      http://www.techdivision.com
 */
class CleanUpObserver extends AbstractCustomerAddressImportObserver
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

        // load email and website code
        $email = $this->getValue(ColumnKeys::EMAIL);
        $website = $this->getValue(ColumnKeys::WEBSITE);

        // add the customer identifier => entity ID mapping
        $this->addCustomerIdentifierEntityIdMapping($email, $website);

        // clean-up the repositories etc. to free memory
        $this->getCustomerAddressBunchProcessor()->cleanUp();

        // temporary persist the last customer identifier
        $this->setLastIdentifier(array($email, $website));
    }

    /**
     * Add the passed mail address/website code => entity ID mapping.
     *
     * @param string $email       The mail address of the customer
     * @param string $websiteCode The website code the customer is bound to
     *
     * @return void
     */
    public function addCustomerIdentifierEntityIdMapping($email, $website)
    {
        $this->getSubject()->addCustomerIdentifierEntityIdMapping($email, $website);
    }

    /**
     * Sets the customer identifier of the last imported customer.
     *
     * @param array $identifier The unique customer identifier
     *
     * @return void
     */
    protected function setLastIdentifier(array $identifier)
    {
        $this->getSubject()->setLastIdentifier($identifier);
    }
}
