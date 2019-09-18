<?php

/**
 * TechDivision\Import\Customer\Address\Repositories\SqlStatements
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

use TechDivision\Import\Customer\Address\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::CUSTOMER_ADDRESS =>
            'SELECT *
               FROM ${table:customer_address_entity}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_ADDRESSES =>
            'SELECT *
               FROM ${table:customer_address_entity}',
        SqlStatementKeys::CUSTOMER_ADDRESS_DATETIMES =>
            'SELECT *
               FROM ${table:customer_address_entity_datetime}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_ADDRESS_DECIMALS =>
            'SELECT *
               FROM ${table:customer_address_entity_decimal}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_ADDRESS_INTS =>
            'SELECT *
               FROM ${table:customer_address_entity_int}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_ADDRESS_TEXTS =>
            'SELECT *
               FROM ${table:customer_address_entity_text}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_ADDRESS_VARCHARS =>
            'SELECT *
               FROM ${table:customer_address_entity_varchar}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_ADDRESS_VARCHAR_BY_ATTRIBUTE_CODE_AND_ENTITY_TYPE_ID_AND_VALUE =>
            'SELECT t1.*
               FROM ${table:customer_address_entity_varchar} t1,
                    ${table:eav_attribute} t2
              WHERE t2.attribute_code = :attribute_code
                AND t2.entity_type_id = :entity_type_id
                AND t1.attribute_id = t2.attribute_id
                AND t1.value = :value',
        SqlStatementKeys::CREATE_CUSTOMER_ADDRESS =>
            'INSERT
               INTO ${table:customer_address_entity}
                    (increment_id,
                     parent_id,
                     created_at,
                     updated_at,
                     is_active,
                     city,
                     company,
                     country_id,
                     fax,
                     firstname,
                     lastname,
                     middlename,
                     postcode,
                     prefix,
                     region,
                     region_id,
                     street,
                     suffix,
                     telephone,
                     vat_id,
                     vat_is_valid,
                     vat_request_date,
                     vat_request_id,
                     vat_request_success)
             VALUES (:increment_id,
                     :parent_id,
                     :created_at,
                     :updated_at,
                     :is_active,
                     :city,
                     :company,
                     :country_id,
                     :fax,
                     :firstname,
                     :lastname,
                     :middlename,
                     :postcode,
                     :prefix,
                     :region,
                     :region_id,
                     :street,
                     :suffix,
                     :telephone,
                     :vat_id,
                     :vat_is_valid,
                     :vat_request_date,
                     :vat_request_id,
                     :vat_request_success)',
        SqlStatementKeys::UPDATE_CUSTOMER_ADDRESS =>
             'UPDATE ${table:customer_address_entity}
                 SET increment_id = :increment_id,
                     parent_id = :parent_id,
                     created_at = :created_at,
                     updated_at = :updated_at,
                     is_active = :is_active,
                     city = :city,
                     company = :company,
                     country_id = :country_id,
                     fax = :fax,
                     firstname = :firstname,
                     lastname = :lastname,
                     middlename = :middlename,
                     postcode = :postcode,
                     prefix = :prefix,
                     region = :region,
                     region_id = :region_id,
                     street = :street,
                     suffix = :suffix,
                     telephone = :telephone,
                     vat_id = :vat_id,
                     vat_is_valid = :vat_is_valid,
                     vat_request_date = :vat_request_date,
                     vat_request_id = :vat_request_id,
                     vat_request_success = :vat_request_success
               WHERE entity_id = :entity_id',
        SqlStatementKeys::DELETE_CUSTOMER_ADDRESS =>
             'DELETE
                FROM ${table:customer_address_entity}
               WHERE entity_id = :entity_id',
        SqlStatementKeys::CREATE_CUSTOMER_ADDRESS_DATETIME =>
            'INSERT
               INTO ${table:customer_address_entity_datetime}
                    (entity_id,
                     attribute_id,
                     value)
            VALUES (:entity_id,
                    :attribute_id,
                    :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_ADDRESS_DATETIME =>
            'UPDATE ${table:customer_address_entity_datetime}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_ADDRESS_DATETIME =>
            'DELETE
               FROM ${table:customer_address_entity_datetime}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_ADDRESS_DECIMAL =>
            'INSERT
               INTO ${table:customer_address_entity_decimal}
                    (entity_id,
                     attribute_id,
                     value)
            VALUES (:entity_id,
                    :attribute_id,
                    :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_ADDRESS_DECIMAL =>
            'UPDATE ${table:customer_address_entity_decimal}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_ADDRESS_DECIMAL =>
            'DELETE
               FROM ${table:customer_address_entity_decimal}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_ADDRESS_INT =>
            'INSERT
               INTO ${table:customer_address_entity_int}
                    (entity_id,
                     attribute_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_ADDRESS_INT =>
            'UPDATE ${table:customer_address_entity_int}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_ADDRESS_INT =>
            'DELETE
               FROM ${table:customer_address_entity_int}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_ADDRESS_VARCHAR =>
            'INSERT
               INTO ${table:customer_address_entity_varchar}
                    (entity_id,
                     attribute_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_ADDRESS_VARCHAR =>
            'UPDATE ${table:customer_address_entity_varchar}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_ADDRESS_VARCHAR =>
            'DELETE
               FROM ${table:customer_address_entity_varchar}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_ADDRESS_TEXT =>
            'INSERT
               INTO ${table:customer_address_entity_text}
                    (entity_id,
                     attribute_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_ADDRESS_TEXT =>
            'UPDATE ${table:customer_address_entity_text}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_ADDRESS_TEXT =>
            'DELETE
               FROM ${table:customer_address_entity_text}
              WHERE value_id = :value_id',
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
