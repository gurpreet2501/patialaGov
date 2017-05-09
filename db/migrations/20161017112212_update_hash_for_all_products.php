<?php
use App\Models as M;
use Phinx\Migration\AbstractMigration;

class UpdateHashForAllProducts extends AbstractMigration
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
        $prod = M\Products::select('id','product_name')->get();
        foreach ($prod as $key => $value) {
            M\Products::where('id',$value->id)->update([
                    'unique_hash' => sha1(trim($value->product_name))
                ]);
        }    
    }
}
