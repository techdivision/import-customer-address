<?php

/**
 * TechDivision\Import\Customer\Address\Utils\GenderKeys
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
 * Utility class containing the available gender keys.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class GenderKeys
{

    /**
     * Key for 'Male'.
     *
     * @var integer
     */
    const GENDER_MALE = 1;

    /**
     * Key for 'Female'.
     *
     * @var integer
     */
    const GENDER_FEMALE = 2;

    /**
     * Key for 'Not Specified'.
     *
     * @var integer
     */
    const GENDER_NOT_SPECIFIED = 3;

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }
}
