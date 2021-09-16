<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\CustomerAddressDatetimeRepository
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

use TechDivision\Import\Customer\Address\Utils\ParamNames;
use TechDivision\Import\Customer\Address\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Collection\Repositories\AbstractRepository;

/**
 * Repository implementation to load customer address datetime attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressDatetimeRepository extends AbstractRepository implements CustomerAddressDatetimeRepositoryInterface
{

    /**
     * The prepared statement to load the existing customer address datetime attributes with the passed entity/store ID.
     *
     * @var \PDOStatement
     */
    protected $customerAddressDatetimesStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->customerAddressDatetimesStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_ADDRESS_DATETIMES));
    }

    /**
     * Load's and return's the datetime attributes for the passed entity ID.
     *
     * @param integer $entityId The entity ID of the attributes
     *
     * @return array The datetime attributes
     */
    public function findAllByEntityId($entityId)
    {

        // prepare the params
        $params = array(ParamNames::ENTITY_ID => $entityId);

        // load and return the customer datetime attributes with the passed entity ID
        $this->customerAddressDatetimesStmt->execute($params);
        return $this->customerAddressDatetimesStmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
