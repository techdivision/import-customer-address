<?php

/**
 * TechDivision\Import\Product\Services\CustomerAddressBunchProcessorInterface
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

namespace TechDivision\Import\Customer\Address\Services;

use TechDivision\Import\Services\EavAwareProcessorInterface;

/**
 * Interface for a customer address bunch processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
interface CustomerAddressBunchProcessorInterface extends CustomerAddressProcessorInterface, EavAwareProcessorInterface
{

    /**
     * Return's the repository to load the customer addresses with.
     *
     * @return \TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface The repository instance
     */
    public function getCustomerAddressRepository();

    /**
     * Return's the action with the customer address CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressAction();

    /**
     * Return's the action with the customer address varchar attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressVarcharAction();

    /**
     * Return's the action with the customer address text attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressTextAction();

    /**
     * Return's the action with the customer address int attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressIntAction();

    /**
     * Return's the action with the customer address decimal attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressDecimalAction();

    /**
     * Return's the action with the customer address datetime attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressDatetimeAction();

    /**
     * Return's the assembler to load the customer address attributes with.
     *
     * @return \TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface The assembler instance
     */
    public function getCustomerAddressAttributeAssembler();

    /**
     * Return's the repository to access EAV attribute option values.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface The repository instance
     */
    public function getEavAttributeOptionValueRepository();

    /**
     * Return's the repository to access EAV attributes.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeRepositoryInterface The repository instance
     */
    public function getEavAttributeRepository();

    /**
     * Return's the repository to access EAV entity types.
     *
     * @return \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface The repository instance
     */
    public function getEavEntityTypeRepository();

    /**
     * Return's an array with the available EAV attributes for the passed is user defined flag.
     *
     * @param integer $isUserDefined The flag itself
     *
     * @return array The array with the EAV attributes matching the passed flag
     */
    public function getEavAttributeByIsUserDefined($isUserDefined = 1);

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAddressAttributesByEntityId($entityId);

    /**
     * Load's and return's the EAV attribute option value with the passed code, store ID and value.
     *
     * @param string  $attributeCode The code of the EAV attribute option to load
     * @param integer $storeId       The store ID of the attribute option to load
     * @param string  $value         The value of the attribute option to load
     *
     * @return array The EAV attribute option value
     */
    public function loadEavAttributeOptionValueByAttributeCodeAndStoreIdAndValue($attributeCode, $storeId, $value);

    /**
     * Return's the customer with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerAddress($id);

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerByEmailAndWebsiteId($email, $websiteId);

    /**
     * Persist's the passed customer address data and return's the ID.
     *
     * @param array       $customerAddress The customer address data to persist
     * @param string|null $name            The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistCustomerAddress($customerAddress, $name = null);

    /**
     * Persist's the passed customer address varchar attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressVarcharAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer address integer attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressIntAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer address decimal attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressDecimalAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer address datetime attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressDatetimeAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer address text attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressTextAttribute($attribute, $name = null);

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddress($row, $name = null);

    /**
     * Delete's the customer address datetime attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressDatetimeAttribute($row, $name = null);

    /**
     * Delete's the customer address decimal attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressDecimalAttribute($row, $name = null);

    /**
     * Delete's the customer address integer attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressIntAttribute($row, $name = null);

    /**
     * Delete's the customer address text attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressTextAttribute($row, $name = null);

    /**
     * Delete's the customer address varchar attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressVarcharAttribute($row, $name = null);

    /**
     * Clean-Up the repositories to free memory.
     *
     * @return void
     */
    public function cleanUp();
}
