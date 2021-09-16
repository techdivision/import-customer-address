<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\CustomerAddressDecimalRepository
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
 * Repository implementation to load customer address decimal attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressDecimalRepository extends AbstractRepository implements CustomerAddressDecimalRepositoryInterface
{

    /**
     * The prepared statement to load the existing customer address decimal attributes with the passed entity/store ID.
     *
     * @var \PDOStatement
     */
    protected $customerAddressDecimalsStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->customerAddressDecimalsStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_ADDRESS_DECIMALS));
    }

    /**
     * Load's and return's the decimal attributes for the passed entity ID.
     *
     * @param integer $entityId The entity ID of the attributes
     *
     * @return array The decimal attributes
     */
    public function findAllByEntityId($entityId)
    {

        // prepare the params
        $params = array(ParamNames::ENTITY_ID => $entityId);

        // load and return the customer decimal attributes with the passed entity ID
        $this->customerAddressDecimalsStmt->execute($params);
        return $this->customerAddressDecimalsStmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
