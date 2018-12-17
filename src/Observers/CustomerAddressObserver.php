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
 * Observer that create's the customer address itself.
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

        // prepare the static entity values
        $customerAddress = $this->initializeCustomerAddress($this->prepareAttributes());

        // insert the entity and set the entity ID
        $this->setLastEntityId($this->persistCustomerAddress($customerAddress));
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {

        // load the website ID for the given code
        $websiteId = $this->getStoreWebsiteIdByCode($this->getValue(ColumnKeys::WEBSITE));

        // load the customer ID
        $parentId = $this->loadCustomerByEmailAndWebsiteId($this->getValue(ColumnKeys::EMAIL), $websiteId);

        // initialize the customer values
        $city = $this->getValue(ColumnKeys::CITY);
        $company = $this->getValue(ColumnKeys::COMPANY);
        $countryId = $this->getValue(ColumnKeys::COUNTRY_ID);
        $fax = $this->getValue(ColumnKeys::FAX);
        $firstname = $this->getValue(ColumnKeys::FIRSTNAME);
        $lastname = $this->getValue(ColumnKeys::LASTNAME);
        $middlename = $this->getValue(ColumnKeys::MIDDLENAME);
        $postcode = $this->getValue(ColumnKeys::POSTCODE);
        $prefix = $this->getValue(ColumnKeys::PREFIX);
        $region = $this->getValue(ColumnKeys::REGION);
        $regionId = $this->getValue(ColumnKeys::REGION_ID);
        $street = $this->getValue(ColumnKeys::STREET);
        $suffix = $this->getValue(ColumnKeys::SUFFIX);
        $telephone = $this->getValue(ColumnKeys::TELEPHONE);
        $vatId = $this->getValue(ColumnKeys::VAT_ID);
        $vatIsValid = $this->getValue(ColumnKeys::VAT_IS_VALID);
        $vatRequestId = $this->getValue(ColumnKeys::VAT_REQUEST_ID);
        $vatRequestSuccess = $this->getValue(ColumnKeys::VAT_REQUEST_SUCCESS);

        // load the customer's addtional attributes
        $incrementId = null;
        $isActive = 1;

        // prepare the date format for the created at/updated at dates
        $createdAt = $this->getValue(ColumnKeys::CREATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $updatedAt = $this->getValue(ColumnKeys::UPDATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $vatRequestDate = $this->getValue(ColumnKeys::VAT_REQUEST_DATE, date('Y-m-d H:i:s'), array($this, 'formatDate'));

        // return the prepared customer
        return $this->initializeEntity(
            array(
                MemberNames::INCREMENT_ID        => $incrementId,
                MemberNames::PARENT_ID           => $parentId,
                MemberNames::CREATED_AT          => $createdAt,
                MemberNames::UPDATED_AT          => $updatedAt,
                MemberNames::IS_ACTIVE           => $isActive,
                MemberNames::CITY                => $city,
                MemberNames::COMPANY             => $company,
                MemberNames::COUNTRY_ID          => $countryId,
                MemberNames::FAX                 => $fax,
                MemberNames::FIRSTNAME           => $firstname,
                MemberNames::LASTNAME            => $lastname,
                MemberNames::MIDDLENAME          => $middlename,
                MemberNames::POSTCODE            => $postcode,
                MemberNames::PREFIX              => $prefix,
                MemberNames::REGION              => $region,
                MemberNames::REGION_ID           => $regionId,
                MemberNames::STREET              => $street,
                MemberNames::SUFFIX              => $suffix,
                MemberNames::TELEPHONE           => $telephone,
                MemberNames::VAT_ID              => $vatId,
                MemberNames::VAT_IS_VALID        => $vatIsValid,
                MemberNames::VAT_REQUEST_DATE    => $vatRequestDate,
                MemberNames::VAT_REQUEST_ID      => $vatRequestId,
                MemberNames::VAT_REQUEST_SUCCESS => $vatRequestSuccess
            )
        );
    }

    /**
     * Initialize the customer address with the passed attributes and returns an instance.
     *
     * @param array $attr The customer address attributes
     *
     * @return array The initialized customer address
     */
    protected function initializeCustomerAddress(array $attr)
    {
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
     * Persist's the passed customer address data and return's the ID.
     *
     * @param array $customerAddress The customer address data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistCustomerAddress($customerAddress)
    {
        return $this->getCustomerAddressBunchProcessor()->persistCustomerAddress($customerAddress);
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

    /**
     * Return's the store website for the passed code.
     *
     * @param string $code The code of the store website to return the ID for
     *
     * @return integer The store website ID
     * @throws \Exception Is thrown, if the store website with the requested code is not available
     */
    protected function getStoreWebsiteIdByCode($code)
    {
        return $this->getSubject()->getStoreWebsiteIdByCode($code);
    }
}
