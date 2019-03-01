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

use TechDivision\Import\Customer\Address\Repositories\CustomerAddressRepositoryInterface;
use TechDivision\Import\Customer\Observers\AbstractCustomerImportObserver;
use TechDivision\Import\Customer\Actions\CustomerActionInterface;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;
use TechDivision\Import\Customer\Utils\ColumnKeys;
use TechDivision\Import\Customer\Utils\MemberNames as OriginalMemberNames;
use TechDivision\Import\Utils\EntityStatus;

/**
 * Abstract class to set shipping and billing address.
 *
 * @copyright  Copyright (c) 2019 TechDivision GmbH (http://www.techdivision.com)
 * @author     TechDivision Team Allstars <allstars@techdivision.com>
 * @link       http://www.techdivision.com/
 */
abstract class AbstractDefaultAddressImportObserver extends AbstractCustomerImportObserver
{
    /**
     * Constants to define default types.
     */
    const TYPE_DEFAULT_SHIPPING = OriginalMemberNames::DEFAULT_SHIPPING;
    const TYPE_DEFAULT_BILLING = OriginalMemberNames::DEFAULT_BILLING;

    /**
     * @var CustomerBunchProcessorInterface
     */
    protected $customerBunchProcessor;

    /**
     * @var CustomerAddressRepositoryInterface
     */
    protected $customerAddressRepository;

    /**
     * @var CustomerActionInterface
     */
    protected $customerAction;

    /**
     * DefaultShippingObserver constructor.
     *
     * @param CustomerBunchProcessorInterface $customerBunchProcessor
     * @param CustomerAddressRepositoryInterface $customerAddressRepository
     * @param CustomerActionInterface $customerAction
     */
    public function __construct(
        CustomerBunchProcessorInterface $customerBunchProcessor,
        CustomerAddressRepositoryInterface $customerAddressRepository,
        CustomerActionInterface $customerAction
    ) {
        $this->customerBunchProcessor = $customerBunchProcessor;
        $this->customerAddressRepository = $customerAddressRepository;
        $this->customerAction = $customerAction;
    }

    /**
     * Save default address by type.
     *
     * @param string $type
     */
    protected function saveDefaultAddressByType($type)
    {
        $defaultShipping = $this->getValue('_address_' . $type . '_');

        if ($defaultShipping) {
            // load email and website code
            $email = $this->getValue('_' . ColumnKeys::EMAIL);
            $websiteCode = $this->getValue(ColumnKeys::WEBSITE);
            $websiteId = $this->getSubject()->getStoreWebsiteIdByCode($websiteCode);

            $customer = $this->customerBunchProcessor->loadCustomerByEmailAndWebsiteId($email, $websiteId);
            $addressId = $this->getSubject()->getLastEntityId();

            if (isset($addressId)) {
                $customer = $this->prepareCustomerArray($type, $customer, $addressId);
                $this->customerAction->persist($customer);
            }
        }
    }

    /**
     * Prepare customer array.
     *
     * @param string $type
     * @param array $customer
     * @param int $addressId
     *
     * @return mixed
     */
    protected function prepareCustomerArray($type, $customer, $addressId)
    {
        unset($customer[OriginalMemberNames::CREATED_AT]);
        $customer[$type] = $addressId;
        $customer[EntityStatus::MEMBER_NAME] = EntityStatus::STATUS_UPDATE;

        return $customer;
    }
}
