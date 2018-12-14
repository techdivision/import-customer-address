<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface
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

use TechDivision\Import\Repositories\RepositoryInterface;

/**
 * Interface for a repository implementation to load customer address data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
}
