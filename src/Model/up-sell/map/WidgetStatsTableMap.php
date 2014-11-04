<?php

namespace src\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'widget_stats' table.
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
class WidgetStatsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'up-sell.map.WidgetStatsTableMap';

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
        $this->setName('widget_stats');
        $this->setPhpName('WidgetStats');
        $this->setClassname('src\\Model\\WidgetStats');
        $this->setPackage('up-sell');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('shop_domain', 'ShopDomain', 'VARCHAR', true, 255, null);
        $this->addForeignKey('up_sell_id', 'UpSellId', 'INTEGER', 'up_sell', 'id', true, null, null);
        $this->addForeignKey('variant_id', 'VariantId', 'INTEGER', 'product', 'shoplo_product_id', false, null, null);
        $this->addColumn('placement', 'Placement', 'CHAR', true, null, 'product');
        $this->getColumn('placement', false)->setValueSet(array (
  0 => 'product',
  1 => 'cart',
));
        $this->addColumn('user_key', 'UserKey', 'VARCHAR', false, 255, null);
        $this->addColumn('status', 'Status', 'CHAR', true, null, 'new');
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'new',
  1 => 'calculated',
));
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UpSell', 'src\\Model\\UpSell', RelationMap::MANY_TO_ONE, array('up_sell_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Product', 'src\\Model\\Product', RelationMap::MANY_TO_ONE, array('variant_id' => 'shoplo_product_id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

} // WidgetStatsTableMap
