<?php

/**
 * TechDivision\Import\Customer\Address\Observers\CustomerAddressExportObserver
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
use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;

/**
 * Prepares the artefacts for the customer address export.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressExportObserver extends AbstractCustomerAddressImportObserver
{

    /**
     * The artefact type.
     *
     * @var string
     */
    const ARTEFACT_TYPE = 'customer-import-address';

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
     * @throws \Exception
     */
    protected function process()
    {
        // load the email with the column keys of the customer-address CSV file
        $email = $this->getValue(\TechDivision\Import\Customer\Utils\ColumnKeys::EMAIL);

        $firstName = $this->getValue(ColumnKeys::ADDRESS_FIRSTNAME, '');
        $lastName = $this->getValue(ColumnKeys::ADDRESS_LASTNAME, '');
        $addressStreet = $this->getValue(ColumnKeys::ADDRESS_STREET, '');
        $addressCity = $this->getValue(ColumnKeys::ADDRESS_CITY, '');
        $countryId = $this->getValue(ColumnKeys::ADDRESS_COUNTRY_ID, '');

        if (empty($addressCity)
            && empty($addressStreet)
            && empty($firstName)
            && empty($lastName)
            && empty($countryId)
        ) {
            $this->getSystemLogger()->warning(
                sprintf(
                    'The customer address was not initialized, no address data specified for the email "%s"',
                    $email
                )
            );
            return;
        }
        // initialize the array for the links
        $artefacts = array();
        
        $artefacts[] = $this->newArtefact(
            array(
                ColumnKeys::ENTITY_ID                => $this->getValue(ColumnKeys::ENTITY_ID),
                ColumnKeys::INCREMENT_ID             => $this->getValue(ColumnKeys::ADDRESS_INCREMENT_ID),
                ColumnKeys::IS_ACTIVE                => $this->getValue(ColumnKeys::ADDRESS_IS_ACTIVE),
                ColumnKeys::EMAIL                    => $email,
                ColumnKeys::WEBSITE                  => $this->getValue(ColumnKeys::WEBSITE),
                ColumnKeys::CITY                     => $addressCity,
                ColumnKeys::COMPANY                  => $this->getValue(ColumnKeys::ADDRESS_COMPANY),
                ColumnKeys::COUNTRY_ID               => $countryId,
                ColumnKeys::FAX                      => $this->getValue(ColumnKeys::ADDRESS_FAX),
                ColumnKeys::FIRSTNAME                => $firstName,
                ColumnKeys::LASTNAME                 => $lastName,
                ColumnKeys::MIDDLENAME               => $this->getValue(ColumnKeys::ADDRESS_MIDDLENAME),
                ColumnKeys::POSTCODE                 => $this->getValue(ColumnKeys::ADDRESS_POSTCODE),
                ColumnKeys::PREFIX                   => $this->getValue(ColumnKeys::ADDRESS_PREFIX),
                ColumnKeys::REGION                   => $this->getValue(ColumnKeys::ADDRESS_REGION),
                ColumnKeys::STREET                   => $addressStreet,
                ColumnKeys::SUFFIX                   => $this->getValue(ColumnKeys::ADDRESS_SUFFIX),
                ColumnKeys::TELEPHONE                => $this->getValue(ColumnKeys::ADDRESS_TELEPHONE),
                ColumnKeys::VAT_ID                   => $this->getValue(ColumnKeys::ADDRESS_VAT_ID),
                ColumnKeys::ADDRESS_DEFAULT_BILLING  => $this->getValue(ColumnKeys::ADDRESS_DEFAULT_BILLING),
                ColumnKeys::ADDRESS_DEFAULT_SHIPPING => $this->getValue(ColumnKeys::ADDRESS_DEFAULT_SHIPPING)
            ),
            array(
                ColumnKeys::ENTITY_ID                => ColumnKeys::ENTITY_ID,
                ColumnKeys::INCREMENT_ID             => ColumnKeys::INCREMENT_ID,
                ColumnKeys::IS_ACTIVE                => ColumnKeys::ADDRESS_IS_ACTIVE,
                ColumnKeys::WEBSITE                  => ColumnKeys::WEBSITE,
                ColumnKeys::EMAIL                    => ColumnKeys::EMAIL,
                ColumnKeys::CITY                     => ColumnKeys::ADDRESS_CITY,
                ColumnKeys::COMPANY                  => ColumnKeys::ADDRESS_COMPANY,
                ColumnKeys::COUNTRY_ID               => ColumnKeys::ADDRESS_COUNTRY_ID,
                ColumnKeys::FAX                      => ColumnKeys::ADDRESS_FAX,
                ColumnKeys::FIRSTNAME                => ColumnKeys::ADDRESS_FIRSTNAME,
                ColumnKeys::LASTNAME                 => ColumnKeys::ADDRESS_LASTNAME,
                ColumnKeys::MIDDLENAME               => ColumnKeys::ADDRESS_MIDDLENAME,
                ColumnKeys::POSTCODE                 => ColumnKeys::ADDRESS_POSTCODE,
                ColumnKeys::PREFIX                   => ColumnKeys::ADDRESS_PREFIX,
                ColumnKeys::REGION                   => ColumnKeys::ADDRESS_REGION,
                ColumnKeys::STREET                   => ColumnKeys::ADDRESS_STREET,
                ColumnKeys::SUFFIX                   => ColumnKeys::ADDRESS_SUFFIX,
                ColumnKeys::TELEPHONE                => ColumnKeys::ADDRESS_TELEPHONE,
                ColumnKeys::VAT_ID                   => ColumnKeys::ADDRESS_VAT_ID,
                ColumnKeys::ADDRESS_DEFAULT_BILLING  => ColumnKeys::ADDRESS_DEFAULT_BILLING,
                ColumnKeys::ADDRESS_DEFAULT_SHIPPING => ColumnKeys::ADDRESS_DEFAULT_SHIPPING
            )
        );

        // append the links to the subject
        $this->addArtefacts($artefacts);
    }

    /**
     * Create's and return's a new empty artefact entity.
     *
     * @param array $columns             The array with the column data
     * @param array $originalColumnNames The array with a mapping from the old to the new column names
     *
     * @return array The new artefact entity
     */
    protected function newArtefact(array $columns, array $originalColumnNames)
    {
        return $this->getSubject()->newArtefact($columns, $originalColumnNames);
    }

    /**
     * Add the passed product type artefacts to the product with the
     * last entity ID.
     *
     * @param array $artefacts The product type artefacts
     *
     * @return void
     * @uses \TechDivision\Import\Product\Media\Subjects\MediaSubject::getLastEntityId()
     */
    protected function addArtefacts(array $artefacts)
    {
        $this->getSubject()->addArtefacts(CustomerAddressExportObserver::ARTEFACT_TYPE, $artefacts, false);
    }
}
