<?php

/**
 * TechDivision\Import\Customer\Address\Observers\CustomerAddressExportObserver
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
use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;

/**
 * Prepares the artefacts for the customer address export.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     */
    protected function process()
    {

        // initialize the array for the links
        $artefacts = array();

        // load the email with the column keys of the customer-address CSV file
        $email = $this->getValue(\TechDivision\Import\Customer\Utils\ColumnKeys::EMAIL);

        $artefacts[] = $this->newArtefact(
            array(
                ColumnKeys::ENTITY_ID                => null,
                ColumnKeys::EMAIL                    => $email,
                ColumnKeys::WEBSITE                  => $this->getValue(ColumnKeys::WEBSITE),
                ColumnKeys::CITY                     => $this->getValue(ColumnKeys::ADDRESS_CITY),
                ColumnKeys::COMPANY                  => $this->getValue(ColumnKeys::ADDRESS_COMPANY),
                ColumnKeys::COUNTRY_ID               => $this->getValue(ColumnKeys::ADDRESS_COUNTRY_ID),
                ColumnKeys::FAX                      => $this->getValue(ColumnKeys::ADDRESS_FAX),
                ColumnKeys::FIRSTNAME                => $this->getValue(ColumnKeys::ADDRESS_FIRSTNAME),
                ColumnKeys::LASTNAME                 => $this->getValue(ColumnKeys::ADDRESS_LASTNAME),
                ColumnKeys::MIDDLENAME               => $this->getValue(ColumnKeys::ADDRESS_MIDDLENAME),
                ColumnKeys::POSTCODE                 => $this->getValue(ColumnKeys::ADDRESS_POSTCODE),
                ColumnKeys::PREFIX                   => $this->getValue(ColumnKeys::ADDRESS_PREFIX),
                ColumnKeys::REGION                   => $this->getValue(ColumnKeys::ADDRESS_REGION),
                ColumnKeys::STREET                   => $this->getValue(ColumnKeys::ADDRESS_STREET),
                ColumnKeys::SUFFIX                   => $this->getValue(ColumnKeys::ADDRESS_SUFFIX),
                ColumnKeys::TELEPHONE                => $this->getValue(ColumnKeys::ADDRESS_TELEPHONE),
                ColumnKeys::VAT_ID                   => $this->getValue(ColumnKeys::ADDRESS_VAT_ID),
                ColumnKeys::ADDRESS_DEFAULT_BILLING  => $this->getValue(ColumnKeys::ADDRESS_DEFAULT_BILLING),
                ColumnKeys::ADDRESS_DEFAULT_SHIPPING => $this->getValue(ColumnKeys::ADDRESS_DEFAULT_SHIPPING)
            ),
            array(
                ColumnKeys::ENTITY_ID                => null,
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
        $this->getSubject()->addArtefacts(CustomerAddressExportObserver::ARTEFACT_TYPE, $artefacts);
    }
}
