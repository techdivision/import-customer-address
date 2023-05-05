<?php

/**
 * TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessor
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Services;

use TechDivision\Import\Dbal\Actions\ActionInterface;
use TechDivision\Import\Dbal\Connection\ConnectionInterface;
use TechDivision\Import\Repositories\EavAttributeRepositoryInterface;
use TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface;
use TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface;
use TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface;
use TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface;
use TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface;

/**
 * The customer address bunch processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressBunchProcessor implements CustomerAddressBunchProcessorInterface
{

    /**
     * A PDO connection initialized with the values from the Doctrine EntityManager.
     *
     * @var \TechDivision\Import\Dbal\Connection\ConnectionInterface
     */
    protected $connection;

    /**
     * The repository to access EAV attribute option values.
     *
     * @var \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface
     */
    protected $eavAttributeOptionValueRepository;

    /**
     * The repository to access customer data.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * The repository to access customer address address data.
     *
     * @var \TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface
     */
    protected $customerAddressRepository;

    /**
     * The repository to access EAV attributes.
     *
     * @var \TechDivision\Import\Repositories\EavAttributeRepositoryInterface
     */
    protected $eavAttributeRepository;

    /**
     * The repository to access EAV attributes.
     *
     * @var \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface
     */
    protected $eavEntityTypeRepository;

    /**
     * The action for customer address CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $customerAddressAction;

    /**
     * The action for customer address varchar attribute CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $customerAddressVarcharAction;

    /**
     * The action for customer address text attribute CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $customerAddressTextAction;

    /**
     * The action for customer address int attribute CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $customerAddressIntAction;

    /**
     * The action for customer address decimal attribute CRUD methods.
     *
     * @var \\TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $customerAddressDecimalAction;

    /**
     * The action for customer address datetime attribute CRUD methods.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $customerAddressDatetimeAction;

    /**
     * The assembler to load the customer address attributes with.
     *
     * @var \TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface
     */
    protected $customerAddressAttributeAssembler;

    /**
     * Initialize the processor with the necessary assembler and repository instances.
     *
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface                                    $connection                        The connection to use
     * @param \TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface $customerAddressAttributeAssembler The customer address attribute assembler to use
     * @param \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface                $eavAttributeOptionValueRepository The EAV attribute option value repository to use
     * @param \TechDivision\Import\Repositories\EavAttributeRepositoryInterface                           $eavAttributeRepository            The EAV attribute repository to use
     * @param \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface                      $customerRepository                The customer repository to use
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface       $customerAddressRepository         The customer address repository to use
     * @param \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface                          $eavEntityTypeRepository           The EAV entity type repository to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                           $customerAddressAction             The customer address action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                           $customerAddressDatetimeAction     The customer address datetime action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                           $customerAddressDecimalAction      The customer address decimal action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                           $customerAddressIntAction          The customer address integer action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                           $customerAddressTextAction         The customer address text action to use
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface                                           $customerAddressVarcharAction      The customer address varchar action to use
     */
    public function __construct(
        ConnectionInterface $connection,
        CustomerAddressAttributeAssemblerInterface $customerAddressAttributeAssembler,
        EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository,
        EavAttributeRepositoryInterface $eavAttributeRepository,
        CustomerRepositoryInterface $customerRepository,
        CustomerAddressRepositoryInterface $customerAddressRepository,
        EavEntityTypeRepositoryInterface $eavEntityTypeRepository,
        ActionInterface $customerAddressAction,
        ActionInterface $customerAddressDatetimeAction,
        ActionInterface $customerAddressDecimalAction,
        ActionInterface $customerAddressIntAction,
        ActionInterface $customerAddressTextAction,
        ActionInterface $customerAddressVarcharAction
    ) {
        $this->setConnection($connection);
        $this->setCustomerAddressAttributeAssembler($customerAddressAttributeAssembler);
        $this->setEavAttributeOptionValueRepository($eavAttributeOptionValueRepository);
        $this->setEavAttributeRepository($eavAttributeRepository);
        $this->setCustomerRepository($customerRepository);
        $this->setCustomerAddressRepository($customerAddressRepository);
        $this->setCustomerAddressAction($customerAddressAction);
        $this->setCustomerAddressDatetimeAction($customerAddressDatetimeAction);
        $this->setCustomerAddressDecimalAction($customerAddressDecimalAction);
        $this->setCustomerAddressIntAction($customerAddressIntAction);
        $this->setCustomerAddressTextAction($customerAddressTextAction);
        $this->setCustomerAddressVarcharAction($customerAddressVarcharAction);
    }

    /**
     * Set's the passed connection.
     *
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface $connection The connection to set
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection.
     *
     * @return \TechDivision\Import\Dbal\Connection\ConnectionInterface The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling CustomerProcessor::commit().
     * Calling CustomerProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * CustomerProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by CustomerProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Set's the repository to load the customers with.
     *
     * @param \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface $customerRepository The repository instance
     *
     * @return void
     */
    public function setCustomerRepository(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Return's the repository to load the customers with.
     *
     * @return \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface The repository instance
     */
    public function getCustomerRepository()
    {
        return $this->customerRepository;
    }

    /**
     * Set's the repository to load the customer addresses with.
     *
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface $customerAddressRepository The repository instance
     *
     * @return void
     */
    public function setCustomerAddressRepository(CustomerAddressRepositoryInterface $customerAddressRepository)
    {
        $this->customerAddressRepository = $customerAddressRepository;
    }

    /**
     * Return's the repository to load the customer addresses with.
     *
     * @return \TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface The repository instance
     */
    public function getCustomerAddressRepository()
    {
        return $this->customerAddressRepository;
    }

    /**
     * Set's the action with the customer address CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $customerAddressAction The action with the customer CRUD methods
     *
     * @return void
     */
    public function setCustomerAddressAction(ActionInterface $customerAddressAction)
    {
        $this->customerAddressAction = $customerAddressAction;
    }

    /**
     * Return's the action with the customer address CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressAction()
    {
        return $this->customerAddressAction;
    }

    /**
     * Set's the action with the customer address varchar attribute CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $customerAddressVarcharAction The action with the customer varchar attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerAddressVarcharAction(ActionInterface $customerAddressVarcharAction)
    {
        $this->customerAddressVarcharAction = $customerAddressVarcharAction;
    }

    /**
     * Return's the action with the customer address varchar attribute CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressVarcharAction()
    {
        return $this->customerAddressVarcharAction;
    }

    /**
     * Set's the action with the customer address text attribute CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $customerAddressTextAction The action with the customer text attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerAddressTextAction(ActionInterface $customerAddressTextAction)
    {
        $this->customerAddressTextAction = $customerAddressTextAction;
    }

    /**
     * Return's the action with the customer address text attribute CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressTextAction()
    {
        return $this->customerAddressTextAction;
    }

    /**
     * Set's the action with the customer address int attribute CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $customerAddressIntAction The action with the customer int attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerAddressIntAction(ActionInterface $customerAddressIntAction)
    {
        $this->customerAddressIntAction = $customerAddressIntAction;
    }

    /**
     * Return's the action with the customer address int attribute CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressIntAction()
    {
        return $this->customerAddressIntAction;
    }

    /**
     * Set's the action with the customer address decimal attribute CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $customerAddressDecimalAction The action with the customer decimal attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerAddressDecimalAction(ActionInterface $customerAddressDecimalAction)
    {
        $this->customerAddressDecimalAction = $customerAddressDecimalAction;
    }

    /**
     * Return's the action with the customer address decimal attribute CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressDecimalAction()
    {
        return $this->customerAddressDecimalAction;
    }

    /**
     * Set's the action with the customer address datetime attribute CRUD methods.
     *
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $customerAddressDatetimeAction The action with the customer datetime attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerAddressDatetimeAction(ActionInterface $customerAddressDatetimeAction)
    {
        $this->customerAddressDatetimeAction = $customerAddressDatetimeAction;
    }

    /**
     * Return's the action with the customer address datetime attribute CRUD methods.
     *
     * @return \TechDivision\Import\Dbal\Actions\ActionInterface The action instance
     */
    public function getCustomerAddressDatetimeAction()
    {
        return $this->customerAddressDatetimeAction;
    }

    /**
     * Set's the repository to access EAV attribute option values.
     *
     * @param \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository The repository to access EAV attribute option values
     *
     * @return void
     */
    public function setEavAttributeOptionValueRepository(EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository)
    {
        $this->eavAttributeOptionValueRepository = $eavAttributeOptionValueRepository;
    }

    /**
     * Return's the repository to access EAV attribute option values.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface The repository instance
     */
    public function getEavAttributeOptionValueRepository()
    {
        return $this->eavAttributeOptionValueRepository;
    }

    /**
     * Set's the repository to access EAV attributes.
     *
     * @param \TechDivision\Import\Repositories\EavAttributeRepositoryInterface $eavAttributeRepository The repository to access EAV attributes
     *
     * @return void
     */
    public function setEavAttributeRepository(EavAttributeRepositoryInterface $eavAttributeRepository)
    {
        $this->eavAttributeRepository = $eavAttributeRepository;
    }

    /**
     * Return's the repository to access EAV attributes.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeRepositoryInterface The repository instance
     */
    public function getEavAttributeRepository()
    {
        return $this->eavAttributeRepository;
    }

    /**
     * Set's the repository to access EAV entity types.
     *
     * @param \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface $eavEntityTypeRepository The repository to access EAV entity types
     *
     * @return void
     */
    public function setEavEntityTypeRepository(EavEntityTypeRepositoryInterface $eavEntityTypeRepository)
    {
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
    }

    /**
     * Return's the repository to access EAV entity types.
     *
     * @return \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface The repository instance
     */
    public function getEavEntityTypeRepository()
    {
        return $this->eavAttributeRepository;
    }

    /**
     * Set's the assembler to load the customer address attributes with.
     *
     * @param \TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface $customerAddressAttributeAssembler The assembler instance
     *
     * @return void
     */
    public function setCustomerAddressAttributeAssembler(CustomerAddressAttributeAssemblerInterface $customerAddressAttributeAssembler)
    {
        $this->customerAddressAttributeAssembler = $customerAddressAttributeAssembler;
    }

    /**
     * Return's the assembler to load the customer address attributes with.
     *
     * @return \TechDivision\Import\Customer\Address\Assemblers\CustomerAddressAttributeAssemblerInterface The assembler instance
     */
    public function getCustomerAddressAttributeAssembler()
    {
        return $this->customerAddressAttributeAssembler;
    }

    /**
     * Return's an array with the available EAV attributes for the passed is user defined flag.
     *
     * @param integer $isUserDefined The flag itself
     *
     * @return array The array with the EAV attributes matching the passed flag
     */
    public function getEavAttributeByIsUserDefined($isUserDefined = 1)
    {
        return $this->getEavAttributeRepository()->findAllByIsUserDefined($isUserDefined);
    }

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAddressAttributesByEntityId($entityId)
    {
        return $this->getCustomerAddressAttributeAssembler()->getCustomerAddressAttributesByEntityId($entityId);
    }

    /**
     * Load's and return's the EAV attribute option value with the passed entity type ID, code, store ID and value.
     *
     * @param string  $entityTypeId  The entity type ID of the EAV attribute to load the option value for
     * @param string  $attributeCode The code of the EAV attribute option to load
     * @param integer $storeId       The store ID of the attribute option to load
     * @param string  $value         The value of the attribute option to load
     *
     * @return array The EAV attribute option value
     */
    public function loadAttributeOptionValueByEntityTypeIdAndAttributeCodeAndStoreIdAndValue($entityTypeId, $attributeCode, $storeId, $value)
    {
        return $this->getEavAttributeOptionValueRepository()->findOneByEntityTypeIdAndAttributeCodeAndStoreIdAndValue($entityTypeId, $attributeCode, $storeId, $value);
    }

    /**
     * Return's an EAV entity type with the passed entity type code.
     *
     * @param string $entityTypeCode The code of the entity type to return
     *
     * @return array The entity type with the passed entity type code
     */
    public function loadEavEntityTypeByEntityTypeCode($entityTypeCode)
    {
        return $this->getEavEntityTypeRepository()->findOneByEntityTypeCode($entityTypeCode);
    }

    /**
     * Return's the customer with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerAddress($id)
    {
        return $this->getCustomerAddressRepository()->load($id);
    }


    /**
     * Return's the customer with the passed increment ID.
     *
     * @param string|integer $incrementId The increment ID of the customer to return
     * @param string|integer $customerId  The entity_id of the customer
     *
     * @return array|null The customer
     */
    public function loadCustomerAddressByIncrementId($incrementId, $customerId)
    {
        return $this->getCustomerAddressRepository()->loadByIncrementIdAndCustomerEntityId($incrementId, $customerId);
    }

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerByEmailAndWebsiteId($email, $websiteId)
    {
        return $this->getCustomerRepository()->findOneByEmailAndWebsiteId($email, $websiteId);
    }

    /**
     * @return mixed
     */
    public function loadDirectoryCountryRegions()
    {
        return $this->getCustomerAddressRepository()->findDirectoryCountryRegions();
    }

    /**
     * Persist's the passed customer address data and return's the ID.
     *
     * @param array       $customerAddress The customer data to persist
     * @param string|null $name            The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistCustomerAddress($customerAddress, $name = null)
    {
        return $this->getCustomerAddressAction()->persist($customerAddress, $name);
    }

    /**
     * Persist's the passed customer address varchar attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressVarcharAttribute($attribute, $name = null)
    {
        $this->getCustomerAddressVarcharAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer address integer attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressIntAttribute($attribute, $name = null)
    {
        $this->getCustomerAddressIntAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer address decimal attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressDecimalAttribute($attribute, $name = null)
    {
        $this->getCustomerAddressDecimalAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer address datetime attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressDatetimeAttribute($attribute, $name = null)
    {
        $this->getCustomerAddressDatetimeAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer address text attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerAddressTextAttribute($attribute, $name = null)
    {
        $this->getCustomerAddressTextAction()->persist($attribute, $name);
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddress($row, $name = null)
    {
        $this->getCustomerAddressAction()->delete($row, $name);
    }

    /**
     * Delete's the customer address datetime attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressDatetimeAttribute($row, $name = null)
    {
        $this->getCustomerAddressDatetimeAction()->delete($row, $name);
    }

    /**
     * Delete's the customer address decimal attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressDecimalAttribute($row, $name = null)
    {
        $this->getCustomerAddressDecimalAction()->delete($row, $name);
    }

    /**
     * Delete's the customer address integer attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressIntAttribute($row, $name = null)
    {
        $this->getCustomerAddressIntAction()->delete($row, $name);
    }

    /**
     * Delete's the customer address text attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressTextAttribute($row, $name = null)
    {
        $this->getCustomerAddressTextAction()->delete($row, $name);
    }

    /**
     * Delete's the customer address varchar attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerAddressVarcharAttribute($row, $name = null)
    {
        $this->getCustomerAddressVarcharAction()->delete($row, $name);
    }

    /**
     * Clean-Up the repositories to free memory.
     *
     * @return void
     */
    public function cleanUp()
    {
        // flush the cache
    }
}
