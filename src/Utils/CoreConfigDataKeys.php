<?php

/**
 * TechDivision\Import\Customer\Address\Utils\CoreConfigDataKeys
 *
 * PHP version 7
 *
 * @copyright  Copyright (c) 2022 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link       http://www.techdivision.com/
 * @author     MET <met@techdivision.com>
 */

namespace TechDivision\Import\Customer\Address\Utils;

/**
 * Utility class containing the keys Magento uses to persist values in the "core_config_data table".
 *
 * @copyright  Copyright (c) 2022 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * @link       http://www.techdivision.com/
 * @author     MET <met@techdivision.com>
 */
class CoreConfigDataKeys extends \TechDivision\Import\Utils\CoreConfigDataKeys
{

    /**
     * Name for the column 'customer/address/telephone_show'.
     *
     * @var string
     */
    const CUSTOMER_ADDRESS_TELEPHONE_SHOW = 'customer/address/telephone_show';
}
