<?php
use App\Models;
use Phinx\Migration\AbstractMigration;

class FillItemsPerBoxForDifferentPlants extends AbstractMigration
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
      $t = __DIR__.'/../../product_list.csv';
      $products = Models\Products::get();
      $file = fopen($t,"r");
      
      while(! feof($file))
      { 
        $t = fgetcsv($file);
        Models\Products::where('id',$t[0])->update([
            'only_sell_cases' => $t[2]
          ]);
        
      }
      
      fclose($file);
    }
}
