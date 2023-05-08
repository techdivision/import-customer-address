<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Repositories;

use TechDivision\Import\Customer\Address\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Collection\Repositories\AbstractRepository;

/**
 * Repository implementation to load customer address data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressRepository extends AbstractRepository implements CustomerAddressRepositoryInterface
{

    /**
     * The prepared statement to load a customer address with the passed entity ID.
     *
     * @var \PDOStatement
     */
    protected $customerAddressStmt;

    /**
     * The prepared statement to load the existing customer addresses.
     *
     * @var \PDOStatement
     */
    protected $customerAddressesStmt;

    /**
     * The prepared statement to load a customer address with the passed increment ID.
     *
     * @var \PDOStatement
     */
    protected $customerAddressIncrementIdStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->customerAddressStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_ADDRESS));
        $this->customerAddressesStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_ADDRESSES));
        $this->customerAddressIncrementIdStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_ADDRESS_INCREMENT_ID));
    }

    /**
     * Return's the available customer addresses.
     *
     * @return array The available customer addresses
     */
    public function findAll()
    {
        // load and return the available customers
        $this->customerAddressesStmt->execute();
        return $this->customerAddressesStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Return's the customer address with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer address to return
     *
     * @return array|null The customer
     */
    public function load($id)
    {

        // if not, try to load the customer with the passed entity ID
        $this->customerAddressStmt->execute(array(MemberNames::ENTITY_ID => $id));
        return $this->customerAddressStmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return's the customer address with the passed increment ID.
     *
     * @param string|integer $incrementId The increment ID of the customer address to return
     * @param string|integer $customerId  The entity_id of the customer
     *
     * @return array|null The customer
     */
    public function loadByIncrementIdAndCustomerEntityId($incrementId, $customerId)
    {
        // if not, try to load the customer with the passed Increment ID
        $this->customerAddressIncrementIdStmt->execute(
            array(
                MemberNames::INCREMENT_ID => $incrementId,
                MemberNames::PARENT_ID => $customerId
            )
        );
        return $this->customerAddressIncrementIdStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
