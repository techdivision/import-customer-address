<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface
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

use TechDivision\Import\Dbal\Repositories\RepositoryInterface;

/**
 * Interface for a repository implementation to load customer address data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
interface CustomerAddressRepositoryInterface extends RepositoryInterface
{

    /**
     * Return's the available customer addresses.
     *
     * @return array The available customer addresses
     */
    public function findAll();

    /**
     * Return's the customer address with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer address to return
     *
     * @return array|null The customer
     */
    public function load($id);

    /**
     * Return's the customer address with the passed Icrement ID.
     *
     * @param string|integer $incrementId The increment ID of the customer address to return
     * @param string|integer $customerId  The entity_id of the customer
     *
     * @return array|null The customer
     */
    public function loadByIncrementIdAndCustomerEntityId($incrementId, $customerId);

    /**
     * Return's all country regions from directory
     *
     * @return array
     */
    public function findDirectoryCountryRegions();
}
