<?php

/**
 * TechDivision\Import\Customer\Address\Observers\CustomerAddressAttributeObserver
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
use TechDivision\Import\Observers\AbstractAttributeObserver;
use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;

/**
 * Observer that creates/updates the customer address's attributes.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressAttributeObserver extends AbstractAttributeObserver
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
     * Intializes the existing attributes for the entity with the passed primary key.
     *
     * @param string  $pk      The primary key of the entity to load the attributes for
     * @param integer $storeId The ID of the store view to load the attributes for
     *
     * @return array The entity attributes
     */
    protected function getAttributesByPrimaryKeyAndStoreId($pk, $storeId)
    {
        $this->attributes = $this->getCustomerAddressBunchProcessor()->getCustomerAddressAttributesByEntityId($pk);
    }

    /**
     * Returns the value(s) of the primary key column(s). As the primary key column can
     * also consist of two columns, the return value can be an array also.
     *
     * @return mixed The primary key value(s)
     */
    protected function getPrimaryKeyValue()
    {

        // initialize the array for the PK values
        $pk = array();

        // prepare the array with the PK values
        foreach ($this->getPrimaryKeyColumnName() as $columName) {
            $pk[] = $this->getValue($columName);
        }

        // return the array with the PK values
        return $pk;
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array|null The prepared attributes
     */
    protected function prepareAttributes()
    {

        // laod the callbacks for the actual attribute code
        $callbacks = $this->getCallbacksByType($this->attributeCode);

        // invoke the pre-cast callbacks
        foreach ($callbacks as $callback) {
            $this->attributeValue = $callback->handle($this);
        }

        // load the ID of the product that has been created recently
        $lastEntityId = $this->getPrimaryKey();

        // cast the value based on the backend type
        $castedValue = $this->castValueByBackendType($this->backendType, $this->attributeValue);

        // prepare the attribute values
        return $this->initializeEntity(
            array(
                $this->getPrimaryKeyMemberName() => $lastEntityId,
                MemberNames::ATTRIBUTE_ID       => $this->attributeId,
                MemberNames::VALUE              => $castedValue
            )
        );
    }

    /**
     * Return's the PK to create the customer => attribute relation.
     *
     * @return integer The PK to create the relation with
     */
    protected function getPrimaryKey()
    {
        return $this->getSubject()->getLastEntityId();
    }

    /**
     * Return's the PK column name to create the customer => attribute relation.
     *
     * @return string The PK column name
     */
    protected function getPrimaryKeyMemberName()
    {
        return MemberNames::ENTITY_ID;
    }

    /**
     * Return's the column name that contains the primary key.
     *
     * @return string the column name that contains the primary key
     */
    protected function getPrimaryKeyColumnName()
    {
        return array(ColumnKeys::EMAIL, ColumnKeys::WEBSITE);
    }

    /**
     * Queries whether or not the passed PK and store view code has already been processed.
     *
     * @param string $pk            The PK to check been processed
     * @param string $storeViewCode The store view code to check been processed
     *
     * @return boolean TRUE if the PK and store view code has been processed, else FALSE
     */
    protected function storeViewHasBeenProcessed($pk, $storeViewCode)
    {
        return $this->getSubject()->storeViewHasBeenProcessed($pk, $storeViewCode);
    }

    /**
     * Persist's the passed varchar attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistVarcharAttribute($attribute)
    {
        $this->getCustomerAddressBunchProcessor()->persistCustomerAddressVarcharAttribute($attribute);
    }

    /**
     * Persist's the passed integer attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistIntAttribute($attribute)
    {
        $this->getCustomerAddressBunchProcessor()->persistCustomerAddressIntAttribute($attribute);
    }

    /**
     * Persist's the passed decimal attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistDecimalAttribute($attribute)
    {
        $this->getCustomerAddressBunchProcessor()->persistCustomerAddressDecimalAttribute($attribute);
    }

    /**
     * Persist's the passed datetime attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistDatetimeAttribute($attribute)
    {
        $this->getCustomerAddressBunchProcessor()->persistCustomerAddressDatetimeAttribute($attribute);
    }

    /**
     * Persist's the passed text attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistTextAttribute($attribute)
    {
        $this->getCustomerAddressBunchProcessor()->persistCustomerAddressTextAttribute($attribute);
    }

    /**
     * Delete's the datetime attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteDatetimeAttribute(array $row, $name = null)
    {
        $this->getCustomerAddressBunchProcessor()->deleteCustomerAddressDatetimeAttribute($row, $name);
    }

    /**
     * Delete's the decimal attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteDecimalAttribute(array $row, $name = null)
    {
        $this->getCustomerAddressBunchProcessor()->deleteCustomerAddressDecimalAttribute($row, $name);
    }

    /**
     * Delete's the integer attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteIntAttribute(array $row, $name = null)
    {
        $this->getCustomerAddressBunchProcessor()->deleteCustomerAddressIntAttribute($row, $name);
    }

    /**
     * Delete's the text attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteTextAttribute(array $row, $name = null)
    {
        $this->getCustomerAddressBunchProcessor()->deleteCustomerAddressTextAttribute($row, $name);
    }

    /**
     * Delete's the varchar attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteVarcharAttribute(array $row, $name = null)
    {
        $this->getCustomerAddressBunchProcessor()->deleteCustomerAddressVarcharAttribute($row, $name);
    }
}
