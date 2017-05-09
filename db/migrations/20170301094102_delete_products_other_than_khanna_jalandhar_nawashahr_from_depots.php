<?php

use Phinx\Migration\AbstractMigration;
use App\Models;
class DeleteProductsOtherThanKhannaJalandharNawashahrFromDepots extends AbstractMigration
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

        $depots = Models\Users::select('id')->where('capability','depot')->get()->toArray();

        $ids = array_column($depots,'id');
        
        $depotProducts = Models\Products::select('id','unique_hash')->whereIn('plant_id', $ids)->get();

        $plants = Models\Users::select('id')->whereIn('username',['khanna','nawanshahr','jalandhar'])->get()->toArray();

        $plant_ids = array_column($plants,'id');

        $plantProducts = Models\Products::select('id','unique_hash')->whereIn('plant_id', $plant_ids)->get()->toArray();
        
        foreach ($depotProducts as $key => $prod) {
            $exists = 0;
            foreach ($plantProducts as $key => $value) {
                
                if($prod['unique_hash'] == $value['unique_hash'])
                   $exists = 1;

            } //foreach
            
            if(!$exists){
                $prod = Models\Products::find($prod->id);
                $prod->delete();
            } //if block
            
        } //foreach

    }
}
