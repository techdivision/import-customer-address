<?php

/**
 * TechDivision\Import\Customer\Address\Utils\SqlStatements
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
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Utils\SqlStatementKeys
{

    /**
     * The SQL statement to load the customer with the passed entity ID.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS = 'customer_address';

    /**
     * The SQL statement to load the available customers.
     *
     * @var string
     */
    const CUSTOMER_ADDRESSES = 'customer_addresses';

    /**
     * The SQL statement to load the customer datetime attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_DATETIMES = 'customer_address_datetimes';

    /**
     * The SQL statement to load the customer decimal attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_DECIMALS = 'customer_address_decimals';

    /**
     * The SQL statement to load the customer integer attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_INTS = 'customer_address_ints';

    /**
     * The SQL statement to load the customer text attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_TEXTS = 'customer_address_texts';

    /**
     * The SQL statement to load the customer varchar attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_VARCHARS = 'customer_address_varchars';

    /**
     * The SQL statement to load a customer varchar attribute by the passed attribute code,
     * entity type and the passed value.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_VARCHAR_BY_ATTRIBUTE_CODE_AND_ENTITY_TYPE_ID_AND_VALUE = 'customer_address_varchar.by.attribute_code.and.entity_type_id.and.value';

    /**
     * The SQL statement to create new customers.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS = 'create.customer_address';

    /**
     * The SQL statement to update an existing customer.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_ADDRESS = 'update.customer_address';

    /**
     * The SQL statement to delete an existing customer.
     *
     * @var string
     */
    const DELETE_CUSTOMER_ADDRESS = 'delete.customer_address';

    /**
     * The SQL statement to create a new customer datetime value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS_DATETIME = 'create.customer_address_datetime';

    /**
     * The SQL statement to update an existing customer datetime value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_ADDRESS_DATETIME = 'update.customer_address_datetime';

    /**
     * The SQL statement to delete an existing customer datetime value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_ADDRESS_DATETIME = 'delete.customer_address_datetime';

    /**
     * The SQL statement to create a new customer decimal value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS_DECIMAL = 'create.customer_address_decimal';

    /**
     * The SQL statement to create a new customer relation.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS_RELATION = 'create.customer_address_relation';

    /**
     * The SQL statement to update an existing customer decimal value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_ADDRESS_DECIMAL = 'update.customer_address_decimal';

    /**
     * The SQL statement to delete an existing customer decimal value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_ADDRESS_DECIMAL = 'delete.customer_address_decimal';

    /**
     * The SQL statement to create a new customer integer value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS_INT = 'create.customer_address_int';

    /**
     * The SQL statement to update an existing customer integer value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_ADDRESS_INT = 'update.customer_address_int';

    /**
     * The SQL statement to delete an existing customer integer value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_ADDRESS_INT = 'delete.customer_address_int';

    /**
     * The SQL statement to create a new customer varchar value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS_VARCHAR = 'create.customer_address_varchar';

    /**
     * The SQL statement to update an existing customer varchar value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_ADDRESS_VARCHAR = 'update.customer_address_varchar';

    /**
     * The SQL statement to delete an existing customer varchar value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_ADDRESS_VARCHAR = 'delete.customer_address_varchar';

    /**
     * The SQL statement to create a new customer text value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_ADDRESS_TEXT = 'create.customer_address_text';

    /**
     * The SQL statement to update an existing customer text value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_ADDRESS_TEXT = 'update.customer_address_text';

    /**
     * The SQL statement to delete an existing customer text value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_ADDRESS_TEXT = 'delete.customer_address_text';
}
