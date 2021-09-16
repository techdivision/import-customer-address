<?php

/**
 * TechDivision\Import\Customer\Address\Utils\DependencyInjectionKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Utils;

/**
 * A utility class for the DI service keys.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class DependencyInjectionKeys extends \TechDivision\Import\Utils\DependencyInjectionKeys
{

    /**
     * The key for the customer bunch processor.
     *
     * @var string
     */
    const PROCESSOR_CUSTOMER_BUNCH = 'import_customer.processor.customer.bunch';
}
