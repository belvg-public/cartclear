<?php
/**
 * @author: A.A.Treitjak
 * @copyright: 2012 - 2013 BelVG.com
 */

class Belvg_Cartclear_Model_Sales_Quote
{
    /**
     * @var
     */
    private $_connection = NULL;
    /**
     * The minimum number of queries.
     */
    private $_limit = 1000;

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    /**
     * Run cleanup.
     */
    public function run()
    {
        //clear customer
        $this->clearCustomer();

        //clear guests
        $this->clearGuest();
    }

    /**
     * Clear the users.
     */
    public function clearCustomer()
    {
        $sql = sprintf('DELETE FROM %s WHERE NOT ISNULL(customer_id) AND updated_at < DATE_SUB(Now(), INTERVAL %s DAY) LIMIT %s',
            $this->getQuoteTableName(),
            $this->getSqlСondition('customer'),
            $this->getLimit()
        );

        $this->getConnection()->query($sql);
    }

    /**
     * Return the clean condition.
     *
     * @param string $type
     *
     * @return int
     */
    protected function getSqlСondition($type = 'customer')
    {
        return intval(Mage::helper('belvg_cartclear')->getConfigValue($type));
    }

    /**
     * Clear the guests.
     */
    public function clearGuest()
    {
        $sql = sprintf('DELETE FROM %s WHERE ISNULL(customer_id) AND updated_at < DATE_SUB(Now(), INTERVAL %s DAY) LIMIT %s',
            $this->getQuoteTableName(),
            $this->getSqlСondition('anonymous'),
            $this->getLimit()
        );

        $this->getConnection()->query($sql);
    }

    /**
     * Return name table of quote.
     *
     * @return string
     */
    protected function getQuoteTableName()
    {
        $table = Mage::getSingleton('core/resource')->getTableName('sales/quote');

        return $this->getConnection()->quoteIdentifier($table, TRUE);
    }

    /**
     * Return database connection.
     *
     * @return mixed
     */
    protected function getConnection()
    {
        if (is_null($this->_connection)) {
            $this->_connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        }

        return $this->_connection;
    }
}