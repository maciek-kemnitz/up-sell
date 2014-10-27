<?php

namespace src\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'up_sell_stats' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.up-sell.map
 */
class UpSellStatsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'up-sell.map.UpSellStatsTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('up_sell_stats');
        $this->setPhpName('UpSellStats');
        $this->setClassname('src\\Model\\UpSellStats');
        $this->setPackage('up-sell');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('shop_domain', 'ShopDomain', 'VARCHAR', true, 255, null);
        $this->addColumn('full_value', 'FullValue', 'DOUBLE', true, null, null);
        $this->addColumn('up_sell_value', 'UpSellValue', 'DOUBLE', false, null, null);
        $this->addColumn('placement', 'Placement', 'CHAR', true, null, 'product');
        $this->getColumn('placement', false)->setValueSet(array (
  0 => 'product',
  1 => 'cart',
));
        $this->addColumn('order_id', 'OrderId', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // UpSellStatsTableMap
