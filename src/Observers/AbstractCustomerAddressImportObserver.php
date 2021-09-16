<?php

/**
 * TechDivision\Import\Customer\Address\Observers\AbstractCustomerAddressImportObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Address\Observers;

use TechDivision\Import\Customer\Address\Utils\ColumnKeys;
use TechDivision\Import\Subjects\SubjectInterface;
use TechDivision\Import\Observers\AbstractObserver;

/**
 * Abstract category observer that handles the process to import customer address bunches.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer-address
 * @link      http://www.techdivision.com
 */
abstract class AbstractCustomerAddressImportObserver extends AbstractObserver implements CustomerAddressImportObserverInterface
{

    /**
     * Will be invoked by the action on the events the listener has been registered for.
     *
     * @param \TechDivision\Import\Subjects\SubjectInterface $subject The subject instance
     *
     * @return array The modified row
     * @see \TechDivision\Import\Observers\ObserverInterface::handle()
     */
    public function handle(SubjectInterface $subject)
    {

        // initialize the row
        $this->setSubject($subject);
        $this->setRow($subject->getRow());

        // process the functionality and return the row
        $this->process();

        // return the processed row
        return $this->getRow();
    }

    /**
     * Process the observer's business logic.
     *
     * @return void
     */
    abstract protected function process();

    /**
     * Return's the column names that contains the primary key.
     *
     * @return array the column names that contains the primary key
     */
    protected function getPrimaryKeyColumnName()
    {
        return array(ColumnKeys::EMAIL, ColumnKeys::WEBSITE);
    }

    /**
     * Queries whether or not the passed customer identifier and store view code has already been processed.
     *
     * @param array  $identifier    The customer identifier to check been processed
     * @param string $storeViewCode The store view code to check been processed
     *
     * @return boolean TRUE if the customer with the passed identifier and store view code has been processed, else FALSE
     */
    protected function storeViewHasBeenProcessed(array $identifier, $storeViewCode)
    {
        return $this->getSubject()->storeViewHasBeenProcessed($identifier, $storeViewCode);
    }

    /**
     * Return's TRUE if the passed entity ID is the actual one.
     *
     * @param integer $entityId The customer address entity ID to check
     *
     * @return boolean TRUE if the passed customer address entity ID is the actual one
     */
    protected function isLastEntityId($entityId)
    {
        return $this->getSubject()->getLastEntityId() === $entityId;
    }
}
