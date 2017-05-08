<?php

use Phinx\Migration\AbstractMigration;

class DispatchTable extends AbstractMigration
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
        $dispatch = $this->table('dispatch', ['id' => true]);
        $dispatch->addColumn('customer_id','integer')
                 ->addColumn('product_id','integer')
                 ->addColumn('stock','integer')
                 ->addColumn('tax','float')
                 ->addColumn('discount','float')
                 ->addColumn('driver_name','string', ['limit' => 100])
                 ->addColumn('license','string', ['limit' => 200])
                 ->addColumn('contact','string', ['limit' => 50])
                 ->addColumn('dispatched_on','datetime')
                 ->addColumn('created_at','datetime')
                 ->addColumn('updated_at','datetime')
                 ->save();

    }
}
