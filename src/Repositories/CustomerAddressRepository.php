<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepository
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

namespace TechDivision\Import\Customer\Address\Repositories;

use TechDivision\Import\Customer\Address\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Utils\SqlStatementKeys;
use TechDivision\Import\Repositories\AbstractRepository;

/**
 * Repository implementation to load customer address data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
     * @param string|int $icrementId The increment ID of the customer address to return
     *
     * @return array|null The customer
     */
    public function loadByIncrementId($icrementId)
    {
        // if not, try to load the customer with the passed Increment ID
        $this->customerAddressIncrementIdStmt->execute(array(MemberNames::INCREMENT_ID => $icrementId));
        return $this->customerAddressIncrementIdStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
