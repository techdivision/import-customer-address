<?php

/**
 * TechDivision\Import\Customer\Address\Utils\MemberNames
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

namespace TechDivision\Import\Customer\Address\Utils;

/**
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class MemberNames extends \TechDivision\Import\Customer\Utils\MemberNames
{

    /**
     * Name for the member 'parent_id'.
     *
     * @var string
     */
    const PARENT_ID = 'parent_id';

    /**
     * Name for the member 'city'.
     *
     * @var string
     */
    const CITY = 'city';

    /**
     * Name for the member 'company'.
     *
     * @var string
     */
    const COMPANY = 'company';

    /**
     * Name for the member 'country_id'.
     *
     * @var string
     */
    const COUNTRY_ID = 'country_id';

    /**
     * Name for the member 'postcode'.
     *
     * @var string
     */
    const POSTCODE = 'postcode';

    /**
     * Name for the member 'region'.
     *
     * @var string
     */
    const REGION = 'region';

    /**
     * Name for the member 'region_id'.
     *
     * @var string
     */
    const REGION_ID = 'region_id';

    /**
     * Name for the member 'street'.
     *
     * @var string
     */
    const STREET = 'street';

    /**
     * Name for the member 'suffix'.
     *
     * @var string
     */
    const SUFFIX = 'suffix';

    /**
     * Name for the member 'street'.
     *
     * @var string
     */
    const STREET = 'street';

    /**
     * Name for the member 'telephone'.
     *
     * @var string
     */
    const TELEPHONE = 'telephone';

    /**
     * Name for the member 'vat_id'.
     *
     * @var string
     */
    const VAT_ID = 'vat_id';

    /**
     * Name for the member 'vat_is_valid'.
     *
     * @var string
     */
    const VAT_IS_VALID = 'vat_is_valid';

    /**
     * Name for the member 'vat_request_id'.
     *
     * @var string
     */
    const VAT_REQUEST_ID = 'vat_request_id';

    /**
     * Name for the member 'vat_request_date'.
     *
     * @var string
     */
    const VAT_REQUEST_DATE = 'vat_request_date';

    /**
     * Name for the member 'vat_request_success'.
     *
     * @var string
     */
    const VAT_REQUEST_SUCCESS = 'vat_request_success';
}
