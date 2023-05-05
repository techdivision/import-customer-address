<?php

/**
 * TechDivision\Import\Customer\Address\Plugins\GlobalDataPlugin
 *
 * PHP version 7
 *
 * @author    Stefan Jaroschek <s.jaroschek-ext@techdivision.com>
 * @copyright 2023 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
declare(strict_types=1);

namespace TechDivision\Import\Customer\Address\Plugins;

use TechDivision\Import\ApplicationInterface;
use TechDivision\Import\Customer\Address\Services\CustomerAddressBunchProcessorInterface;
use TechDivision\Import\Plugins\AbstractPlugin;
use TechDivision\Import\Customer\Address\Utils\RegistryKeys;

/**
 * Plugin that loads the global data.
 *
 * @author    MET  <met@techdivision.com>
 * @copyright 2023 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class GlobalDataPlugin extends AbstractPlugin
{
    /**
     * @var CustomerAddressBunchProcessorInterface
     */
    protected $customerAddressBunchProcessor;

    /**
     * @param ApplicationInterface $application
     * @param CustomerAddressBunchProcessorInterface $customerAddressBunchProcessor
     */
    public function __construct(
        ApplicationInterface $application,
        CustomerAddressBunchProcessorInterface $customerAddressBunchProcessor
    ){
        $this->customerAddressBunchProcessor = $customerAddressBunchProcessor;
        parent::__construct($application);
    }

    /**
     * Process the plugin functionality.
     *
     * @return void
     * @throws \Exception Is thrown, if the plugin can not be processed
     */
    public function process()
    {
        // initialize the array for the global data
        $globalData = array();

        // initialize the global data
        $globalData[RegistryKeys::COUNTRY_REGIONS] = $this->getCountryRegions();

        $globalData = array_merge($this->getImportProcessor()->getGlobalData(), $globalData);

        // add the status with the global data
        $this->getRegistryProcessor()->mergeAttributesRecursive(
            RegistryKeys::STATUS,
            array(RegistryKeys::GLOBAL_DATA => $globalData)
        );
    }

    /**
     * @return mixed
     */
    public function getCountryRegions()
    {
        return $this->customerAddressBunchProcessor->loadDirectoryCountryRegions();
    }
}
