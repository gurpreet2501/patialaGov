<?php
use App\Models as M;
use Phinx\Migration\AbstractMigration;

class AddOnlySellCasesKeyForSelectedPlantsAndAllDepots extends AbstractMigration
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
       $depots = M\Users::where('capability','depot')->get();
       
        foreach ($depots->toArray() as $key => $value) {
            
            $entry = M\PlantsConfiguration::select('id')->where(
                    [
                        'plant_id' => $value['id'],
                        'key' => 'only_sell_cases',
                    ]
                    )->first();

            if($entry)  
                continue;

            M\PlantsConfiguration::create([
               'plant_id' =>    $value['id'],
                'key'  => 'only_sell_cases',
                'value' => 1
            ]);

        }
        

        $plants = [ 'khanna','jalandhar','nawanshahr' ];

            foreach($plants as $key => $value) {
                
                $plant = M\Users::select('id')->where('username', $value)->first();

                if(!isset($plant->id))
                    continue;
                
                $entry = M\PlantsConfiguration::select('id')->where(
                    [
                        'plant_id' => $plant->id,
                        'key' => 'only_sell_cases',
                    ]
                    )->first();

                if($entry)
                    continue;

                M\PlantsConfiguration::create([
                    'plant_id' =>   $plant->id,
                    'key'  => 'only_sell_cases',
                    'value' => 1
                ]);
                
            }

        echo "All Done";
    }
}
