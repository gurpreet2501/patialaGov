<?php

use Phinx\Migration\AbstractMigration;
use App\Models;
class FillPlantIdFieldInShippedItemsTable extends AbstractMigration
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
        $data = Models\ShippedItems::with('orders')->get();
        foreach ($data as $key => $value) {
            $value->plant_id = $value->orders->plant_id;
            $value->save();
        }
     
    }
}
