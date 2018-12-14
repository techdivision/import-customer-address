<?php

/**
 * TechDivision\Import\Customer\Address\Observers\CustomerAddressObserver
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
 * Observer that create's the customer itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressObserver extends AbstractCustomerAddressImportObserver
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
     * @return void
     */
    protected function process()
    {

        // load email and website code
        $email = $this->getValue(ColumnKeys::EMAIL);
        $website = $this->getValue(ColumnKeys::WEBSITE);

        // query whether or not, we've found a new SKU => means we've found a new customer
        if ($this->hasBeenProcessed(array($email, $website))) {
            return;
        }

        // prepare the static entity values
        $customer = $this->initializeCustomer($this->prepareAttributes());

        // insert the entity and set the entity ID
        $this->setLastEntityId($this->persistCustomer($customer));
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // initialize the customer values
        $websiteId = $this->getValue(ColumnKeys::WEBSITE_ID);
        $email = $this->getValue(ColumnKeys::EMAIL);
        $groupId = $this->getValue(ColumnKeys::GROUP_ID);
        $storeId = $this->getValue(ColumnKeys::STORE_ID);
        $disableAutoGroupChange = $this->getValue(ColumnKeys::DISABLE_AUTO_GROUP_CHANGE);
        $prefix = $this->getValue(ColumnKeys::PREFIX);
        $firstname = $this->getValue(ColumnKeys::FIRSTNAME);
        $middlename = $this->getValue(ColumnKeys::MIDDLENAME);
        $lastname = $this->getValue(ColumnKeys::LASTNAME);
        $suffix = $this->getValue(ColumnKeys::SUFFIX);
        $passwordHash = $this->getValue(ColumnKeys::PASSWORD_HASH);
        $rpToken = $this->getValue(ColumnKeys::RP_TOKEN);
        $defaultShipping = $this->getValue(ColumnKeys::ADDRESS_DEFAULT_SHIPPING);
        $defaultBilling = $this->getValue(ColumnKeys::ADDRESS_DEFAULT_BILLING);
        $taxvat = $this->getValue(ColumnKeys::TAXVAT);
        $confirmation = $this->getValue(ColumnKeys::CONFIRMATION);

        // load the customer's addtional attributes
        $createdIn = $this->getValue(ColumnKeys::CREATED_IN);
        $incrementId = null;
        $isActive = 1;
        $failuresNum = 0;
        $firstFailure = null;
        $lockExpires = null;

        // prepare the date format for the created at/updated at dates
        $dob = $this->getValue(ColumnKeys::DOB, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $createdAt = $this->getValue(ColumnKeys::CREATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $updatedAt = $this->getValue(ColumnKeys::UPDATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $rpTokenCreatedAt = $this->getValue(ColumnKeys::RP_TOKEN_CREATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));

        // return the prepared customer
        return $this->initializeEntity(
            array(
                MemberNames::WEBSITE_ID                => $websiteId,
                MemberNames::EMAIL                     => $email,
                MemberNames::GROUP_ID                  => $groupId,
                MemberNames::INCREMENT_ID              => $incrementId,
                MemberNames::STORE_ID                  => $storeId,
                MemberNames::CREATED_AT                => $createdAt,
                MemberNames::UPDATED_AT                => $updatedAt,
                MemberNames::IS_ACTIVE                 => $isActive,
                MemberNames::DISABLE_AUTO_GROUP_CHANGE => $disableAutoGroupChange,
                MemberNames::CREATED_IN                => $createdIn,
                MemberNames::PREFIX                    => $prefix,
                MemberNames::FIRSTNAME                 => $firstname,
                MemberNames::MIDDLENAME                => $middlename,
                MemberNames::LASTNAME                  => $lastname,
                MemberNames::SUFFIX                    => $suffix,
                MemberNames::DOB                       => $dob,
                MemberNames::PASSWORD_HASH             => $passwordHash,
                MemberNames::RP_TOKEN                  => $rpToken,
                MemberNames::RP_TOKEN_CREATED_AT       => $rpTokenCreatedAt,
                MemberNames::DEFAULT_BILLING           => $defaultBilling,
                MemberNames::DEFAULT_SHIPPING          => $defaultShipping,
                MemberNames::TAXVAT                    => $taxvat,
                MemberNames::CONFIRMATION              => $confirmation,
                MemberNames::FAILURES_NUM              => $failuresNum,
                MemberNames::FIRST_FAILURE             => $firstFailure,
                MemberNames::LOCK_EXPIRES              => $lockExpires
            )
        );
    }

    /**
     * Initialize the customer with the passed attributes and returns an instance.
     *
     * @param array $attr The customer attributes
     *
     * @return array The initialized customer
     */
    protected function initializeCustomer(array $attr)
    {

        // load the customer with the passed SKU and merge it with the attributes
        if ($entity = $this->loadCustomerByEmailAndWebsiteId($attr[MemberNames::EMAIL], $attr[MemberNames::WEBSITE_ID])) {
            return $this->mergeEntity($entity, $attr);
        }

        // otherwise simply return the attributes
        return $attr;
    }

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    protected function loadCustomerByEmailAndWebsiteId($email, $websiteId)
    {
        return $this->getCustomerAddressBunchProcessor()->loadCustomerByEmailAndWebsiteId($email, $websiteId);
    }

    /**
     * Persist's the passed customer data and return's the ID.
     *
     * @param array $customer The customer data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistCustomer($customer)
    {
        return $this->getCustomerAddressBunchProcessor()->persistCustomer($customer);
    }

    /**
     * Return's the attribute set of the product that has to be created.
     *
     * @return array The attribute set
     */
    protected function getAttributeSet()
    {
        return $this->getSubject()->getAttributeSet();
    }

    /**
     * Set's the ID of the customer that has been created recently.
     *
     * @param string $lastEntityId The entity ID
     *
     * @return void
     */
    protected function setLastEntityId($lastEntityId)
    {
        $this->getSubject()->setLastEntityId($lastEntityId);
    }
}
