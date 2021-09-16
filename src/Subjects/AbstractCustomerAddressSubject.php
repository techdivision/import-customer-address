<?php

/**
 * TechDivision\Import\Customer\Address\Subjects\AbstractAddressCustomerSubject
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Subjects;

use TechDivision\Import\Subjects\AbstractEavSubject;
use TechDivision\Import\Subjects\EntitySubjectInterface;
use TechDivision\Import\Customer\Address\Utils\MemberNames;
use TechDivision\Import\Customer\Address\Utils\RegistryKeys;
use TechDivision\Import\Customer\Address\Utils\ConfigurationKeys;

/**
 * The abstract customer subject implementation that provides basic customer address
 * handling business logic.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
abstract class AbstractCustomerAddressSubject extends AbstractEavSubject implements EntitySubjectInterface
{

    /**
     * The ID of the product that has been created recently.
     *
     * @var string
     */
    protected $lastEntityId;

    /**
     * The available store websites.
     *
     * @var array
     */
    protected $storeWebsites = array();

    /**
     * Set's the ID of the product that has been created recently.
     *
     * @param string $lastEntityId The entity ID
     *
     * @return void
     */
    public function setLastEntityId($lastEntityId)
    {
        $this->lastEntityId = $lastEntityId;
    }

    /**
     * Return's the ID of the product that has been created recently.
     *
     * @return string The entity Id
     */
    public function getLastEntityId()
    {
        return $this->lastEntityId;
    }

    /**
     * Queries whether or not the passed PK and store view code has already been processed.
     *
     * @param string $pk            The PK to check been processed
     * @param string $storeViewCode The store view code to check been processed
     *
     * @return boolean TRUE if the PK and store view code has been processed, else FALSE
     */
    public function storeViewHasBeenProcessed($pk, $storeViewCode)
    {
        return false;
    }

    /**
     * Intializes the previously loaded global data for exactly one bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // load the status of the actual import
        $status = $this->getRegistryProcessor()->getAttribute(RegistryKeys::STATUS);

        // load the global data we've prepared initially
        $this->storeWebsites =  $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::STORE_WEBSITES];

        // invoke the parent method
        parent::setUp($serial);
    }

    /**
     * Return's the store website for the passed code.
     *
     * @param string $code The code of the store website to return the ID for
     *
     * @return integer The store website ID
     * @throws \Exception Is thrown, if the store website with the requested code is not available
     */
    public function getStoreWebsiteIdByCode($code)
    {

        // query whether or not, the requested store website is available
        if (isset($this->storeWebsites[$code])) {
            return (integer) $this->storeWebsites[$code][MemberNames::WEBSITE_ID];
        }

        // throw an exception, if not
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Found invalid website code %s', $code)
            )
        );
    }

    /**
     * Merge the columns from the configuration with all image type columns to define which
     * columns should be cleaned-up.
     *
     * @return array The columns that has to be cleaned-up
     */
    public function getCleanUpColumns()
    {
        return $this->getConfiguration()->getParam(ConfigurationKeys::CLEAN_UP_EMPTY_COLUMNS);
    }
}
