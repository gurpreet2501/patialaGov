<?php

use Phinx\Migration\AbstractMigration;
use App\Models;
class UpdateOnlySellCasesOptionForDepots extends AbstractMigration
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
      
      $plants = Models\Users::where('role','plant_manager')
                    ->where('username','khanna')
                    ->orWhere('username','jalandhar')
                    ->orWhere('username','nawanshahr')
                    ->get();  
 
      foreach ($plants as  $plant) {

        $products = Models\Products::where('plant_id', $plant->id)->get();
        
        foreach ($products as $product) {
         if(empty(trim($product->unique_hash)))
           continue;
        
          Models\Products::where('unique_hash', $product->unique_hash)->where('plant_id','!=',$product->plant_id)->update(['only_sell_cases' => $product->only_sell_cases]);
        
        }

      }             

    }
}
