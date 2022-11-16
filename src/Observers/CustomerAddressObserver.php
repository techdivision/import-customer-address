<?php

/**
 * TechDivision\Import\Customer\Address\Observers\CustomerAddressObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Observers;

use TechDivision\Import\Customer\Address\Utils\ColumnKeys;
use TechDivision\Import\Customer\Address\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;
use TechDivision\Import\Customer\Address\Utils\CoreConfigDataKeys;
use TechDivision\Import\Observers\CleanUpEmptyColumnsTrait;
use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Utils\ConfigurationKeys;
use TechDivision\Import\Utils\RegistryKeys;

/**
 * Observer that create's the customer address itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressObserver extends AbstractCustomerAddressImportObserver
{

    use CleanUpEmptyColumnsTrait;

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
     * @param \TechDivision\Import\Observers\StateDetectorInterface                                 $stateDetector                 The state detector instance
     */
    public function __construct(
        CustomerAddressBunchProcessorInterface $customerAddressBunchProcessor,
        StateDetectorInterface $stateDetector = null
    ) {
        parent::__construct($stateDetector);
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

        if (!empty($customerAddress)) {
            if ($this->hasChanges($customerAddress)) {
                // insert the entity and set the entity ID
                $this->setLastEntityId($this->persistCustomerAddress($customerAddress));
            } else {
                $this->setLastEntityId($customerAddress[MemberNames::ENTITY_ID]);
            }
        }
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     * @throws \Exception
     */
    protected function prepareAttributes()
    {

        // load the website ID for the given code
        $websiteId = $this->getStoreWebsiteIdByCode($this->getValue(ColumnKeys::WEBSITE));

        // load the customer
        $customer = $this->loadCustomerByEmailAndWebsiteId($this->getValue(ColumnKeys::EMAIL), $websiteId);

        if (!$customer) {
            $message =  sprintf(
                'the imported address has no customer with email %s',
                $this->getValue(ColumnKeys::EMAIL)
            );
            $this->mergeStatus(
                array(
                    RegistryKeys::NO_STRICT_VALIDATIONS => array(
                        basename($this->getFilename()) => array(
                            $this->getLineNumber() => array(
                                ColumnKeys::EMAIL => $message
                            )
                        )
                    )
                )
            );
            return [];
        }
        
        // initialize the customer values
        $entityId = $this->getValue(ColumnKeys::ENTITY_ID);
        $city = $this->getValue(ColumnKeys::CITY, '');
        $company = $this->getValue(ColumnKeys::COMPANY);
        $countryId = $this->getValue(ColumnKeys::COUNTRY_ID, '');
        $fax = $this->getValue(ColumnKeys::FAX);
        $firstname = $this->getValue(ColumnKeys::FIRSTNAME, '');
        $lastname = $this->getValue(ColumnKeys::LASTNAME, '');
        $middlename = $this->getValue(ColumnKeys::MIDDLENAME);
        $postcode = $this->getValue(ColumnKeys::POSTCODE);
        $prefix = $this->getValue(ColumnKeys::PREFIX);
        $region = $this->getValue(ColumnKeys::REGION);
        $regionId = $this->getValue(ColumnKeys::REGION_ID);
        $street = $this->getValue(ColumnKeys::STREET, '');
        $suffix = $this->getValue(ColumnKeys::SUFFIX);
        $telephone = $this->checkCustomerPhoneConfig($this->getValue(ColumnKeys::TELEPHONE, ''));
        $vatId = $this->getValue(ColumnKeys::VAT_ID);
        $vatIsValid = $this->getValue(ColumnKeys::VAT_IS_VALID);
        $vatRequestId = $this->getValue(ColumnKeys::VAT_REQUEST_ID);
        $vatRequestSuccess = $this->getValue(ColumnKeys::VAT_REQUEST_SUCCESS);

        // load the customer's addtional attributes
        $incrementId = $this->getValue(ColumnKeys::INCREMENT_ID);
        $isActive = $this->getValue(ColumnKeys::IS_ACTIVE);

        // prepare the date format for the created at/updated at dates
        $createdAt = $this->getValue(ColumnKeys::CREATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $updatedAt = $this->getValue(ColumnKeys::UPDATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $vatRequestDate = $this->getValue(ColumnKeys::VAT_REQUEST_DATE, null, array($this, 'formatDate'));

        // return the prepared customer
        return $this->initializeEntity(
            array(
                MemberNames::ENTITY_ID           => $entityId,
                MemberNames::INCREMENT_ID        => $incrementId,
                MemberNames::PARENT_ID           => $customer[MemberNames::ENTITY_ID],
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
        if (empty($attr)) {
            return [];
        }

        // try to load the customer address with the given entity ID
        if ($entity = $this->loadCustomerAddress($attr[MemberNames::ENTITY_ID])) {
            // clear row elements that are not allowed to be updated
            $attr = $this->clearRowData($attr);

            return $this->mergeEntity($entity, $attr);
        }

        // remove the entity ID
        // if nothing found with entity_id then remove to try with incement id or create new one
        unset($attr[MemberNames::ENTITY_ID]);

        // try to load the customer address with the given increment ID and the customer id
        if (!empty($attr[MemberNames::INCREMENT_ID]) && $entity = $this->loadCustomerAddressByIncrementId($attr[MemberNames::INCREMENT_ID], $attr[MemberNames::PARENT_ID])) {
            // clear row elements that are not allowed to be updated
            $attr = $this->clearRowData($attr, true);

            return $this->mergeEntity($entity, $attr);
        } else {
            // cleanup __EMPTY__VALUE__ entries, don't remove array elements
            $attr = $this->clearRowData($attr, false);
        }

        // New Customer address always active
        if ($attr[MemberNames::IS_ACTIVE] == null) {
            $attr[MemberNames::IS_ACTIVE] = 1;
        }

        // simply return the attributes
        return $attr;
    }

    /**
     * Return's the customer with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer to return
     *
     * @return array|null The customer
     */
    protected function loadCustomerAddress($id)
    {
        return $this->getCustomerAddressBunchProcessor()->loadCustomerAddress($id);
    }

    /**
     * Return's the customer with the passed increment ID.
     *
     * @param string|integer $incrementId The increment ID of the customer to return
     * @param string|integer $customerId  The entity_id of the customer
     *
     * @return array|null The customer
     */
    protected function loadCustomerAddressByIncrementId($incrementId, $customerId)
    {
        return $this->getCustomerAddressBunchProcessor()->loadCustomerAddressByIncrementId($incrementId, $customerId);
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

    /**
     * @param string $value value of customer column
     *
     * @return string
     * @throws \Exception
     */
    public function checkCustomerPhoneConfig($value)
    {
        try {
            $telConfig = $this->getSubject()->getCoreConfigData(CoreConfigDataKeys::CUSTOMER_ADDRESS_TELEPHONE_SHOW);
        } catch (\Exception $e) {
            return $value;
        }
        if (isset($telConfig) && $telConfig !==  'req') {
            return !empty($value) ? $value : '';
        }
        return $value;
    }
}
