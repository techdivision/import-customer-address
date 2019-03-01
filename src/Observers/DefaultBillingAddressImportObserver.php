<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @author    Vadim Justus <v.justus@techdivision.com>
 * @author    Harald Deiser <h.deiser@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Observers;

/**
 * Set default billing address
 *
 * @copyright  Copyright (c) 2019 TechDivision GmbH (http://www.techdivision.com)
 * @author     TechDivision Team Allstars <allstars@techdivision.com>
 * @link       http://www.techdivision.com/
 */
class DefaultBillingAddressImportObserver extends AbstractDefaultAddressImportObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    protected function process()
    {
        $this->saveDefaultAddressByType(parent::TYPE_DEFAULT_BILLING);
    }
}
