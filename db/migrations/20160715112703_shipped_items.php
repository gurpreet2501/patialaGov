<?php

use Phinx\Migration\AbstractMigration;

class ShippedItems extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
      $table = $this->table('shipped_items');
      $table->addColumn('shipment_domestic_id','biginteger')
            ->addColumn('shipment_export_id','biginteger')
            ->addColumn('qty','biginteger')
            ->addColumn('order_item_id','biginteger')
            ->addColumn('order_id','biginteger')
            ->addColumn('created_at','datetime')
            ->addColumn('updated_at','datetime')
            ->save();
    }
}
