<?php
use App\Models;
use Phinx\Migration\AbstractMigration;

class CanAcceptDometicOrderEntriesInPlantConfigurationTable extends AbstractMigration
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
          $data = Models\Users::select('id','username','capability')->where('role','plant_manager')->get();
        
        if(empty($data))
            return;

         $record = [];
          foreach ($data as $key => $value) {
            $record['plant_id'] = $value->id;
            $record['key'] = 'can_accept_domestic_order';

            $record['value'] = (($value->username == 'khanna') || ($value->username == 'jalandhar') || ($value->username == 'nawanshahr')) ? 0 : 1;

            Models\PlantsConfiguration::create($record);

        }
    }
}
