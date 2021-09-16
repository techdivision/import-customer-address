<?php

/**
 * TechDivision\Import\Customer\Address\Assemblers\CustomerAttributeAssembler
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Assemblers;

use TechDivision\Import\Customer\Address\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Repositories\CustomerAddressDatetimeRepositoryInterface;
use TechDivision\Import\Customer\Address\Repositories\CustomerAddressDecimalRepositoryInterface;
use TechDivision\Import\Customer\Address\Repositories\CustomerAddressIntRepositoryInterface;
use TechDivision\Import\Customer\Address\Repositories\CustomerAddressTextRepositoryInterface;
use TechDivision\Import\Customer\Address\Repositories\CustomerAddressVarcharRepositoryInterface;

/**
 * Assembler implementation that provides functionality to assemble customer address attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
class CustomerAddressAttributeAssembler implements CustomerAddressAttributeAssemblerInterface
{

    /**
     * The customer address datetime repository instance.
     *
     * @var \TechDivision\Import\Customer\Address\Repositories\CustomerAddressDatetimeRepositoryInterface
     */
    protected $customerAddressDatetimeRepository;

    /**
     * The customer address decimal repository instance.
     *
     * @var \TechDivision\Import\Customer\Address\Repositories\CustomerAddressDecimalRepositoryInterface
     */
    protected $customerAddressDecimalRepository;

    /**
     * The customer address integer repository instance.
     *
     * @var \TechDivision\Import\Customer\Address\Repositories\CustomerAddressIntRepositoryInterface
     */
    protected $customerAddressIntRepository;

    /**
     * The customer address text repository instance.
     *
     * @var \TechDivision\Import\Customer\Address\Repositories\CustomerAddressTextRepositoryInterface
     */
    protected $customerAddressTextRepository;

    /**
     * The customer address varchar repository instance.
     *
     * @var \TechDivision\Import\Customer\Address\Repositories\CustomerAddressVarcharRepositoryInterface
     */
    protected $customerAddressVarcharRepository;

    /**
     * Initializes the assembler with the necessary repositories.
     *
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressDatetimeRepositoryInterface $customerAddressDatetimeRepository The customer address datetime repository instance
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressDecimalRepositoryInterface  $customerAddressDecimalRepository  The customer address decimal repository instance
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressIntRepositoryInterface      $customerAddressIntRepository      The customer address integer repository instance
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressTextRepositoryInterface     $customerAddressTextRepository     The customer address text repository instance
     * @param \TechDivision\Import\Customer\Address\Repositories\CustomerAddressVarcharRepositoryInterface  $customerAddressVarcharRepository  The customer address varchar repository instance
     */
    public function __construct(
        CustomerAddressDatetimeRepositoryInterface $customerAddressDatetimeRepository,
        CustomerAddressDecimalRepositoryInterface $customerAddressDecimalRepository,
        CustomerAddressIntRepositoryInterface $customerAddressIntRepository,
        CustomerAddressTextRepositoryInterface $customerAddressTextRepository,
        CustomerAddressVarcharRepositoryInterface $customerAddressVarcharRepository
    ) {
        $this->customerAddressDatetimeRepository = $customerAddressDatetimeRepository;
        $this->customerAddressDecimalRepository = $customerAddressDecimalRepository;
        $this->customerAddressIntRepository = $customerAddressIntRepository;
        $this->customerAddressTextRepository = $customerAddressTextRepository;
        $this->customerAddressVarcharRepository = $customerAddressVarcharRepository;
    }

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAddressAttributesByEntityId($entityId)
    {

        // initialize the array for the attributes
        $attributes = array();

        // load the datetime attributes
        foreach ($this->customerAddressDatetimeRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the decimal attributes
        foreach ($this->customerAddressDecimalRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the integer attributes
        foreach ($this->customerAddressIntRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the text attributes
        foreach ($this->customerAddressTextRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the varchar attributes
        foreach ($this->customerAddressVarcharRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // return the array with the attributes
        return $attributes;
    }
}
