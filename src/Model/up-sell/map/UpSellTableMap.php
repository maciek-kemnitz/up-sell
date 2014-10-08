<?php

namespace src\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'up_sell' table.
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
class UpSellTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'up-sell.map.UpSellTableMap';

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
        $this->setName('up_sell');
        $this->setPhpName('UpSell');
        $this->setClassname('src\\Model\\UpSell');
        $this->setPackage('up-sell');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('shop_domain', 'ShopDomain', 'VARCHAR', true, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('headline', 'Headline', 'LONGVARCHAR', true, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', true, null, null);
        $this->addColumn('price_from', 'PriceFrom', 'DOUBLE', false, null, null);
        $this->addColumn('price_to', 'PriceTo', 'DOUBLE', false, null, null);
        $this->addColumn('order', 'Order', 'INTEGER', true, null, null);
        $this->addColumn('use_price_range', 'UsePriceRange', 'CHAR', true, null, '1');
        $this->getColumn('use_price_range', false)->setValueSet(array (
  0 => '0',
  1 => '1',
));
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('status', 'Status', 'CHAR', true, null, 'active');
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'active',
  1 => 'disabled',
));
        $this->addColumn('discount_type', 'DiscountType', 'CHAR', true, null, 'none');
        $this->getColumn('discount_type', false)->setValueSet(array (
  0 => 'none',
  1 => 'percent',
  2 => 'amount',
));
        $this->addColumn('discount_amount', 'DiscountAmount', 'FLOAT', false, null, null);
        $this->addColumn('placement', 'Placement', 'CHAR', true, null, 'product');
        $this->getColumn('placement', false)->setValueSet(array (
  0 => 'product',
  1 => 'cart',
));
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProductInCart', 'src\\Model\\ProductInCart', RelationMap::ONE_TO_MANY, array('id' => 'up_sell_id', ), null, null, 'ProductInCarts');
        $this->addRelation('RelatedProduct', 'src\\Model\\RelatedProduct', RelationMap::ONE_TO_MANY, array('id' => 'up_sell_id', ), null, null, 'RelatedProducts');
    } // buildRelations()

} // UpSellTableMap
