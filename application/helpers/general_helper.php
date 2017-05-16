<?php 
use App\Models;
function getTimeSlotName($id){
	$tslot = Models\TimeSlots::select('name')->where('id',$id)->first();
	return $tslot->name;
}

function getQueries(){
	return Models\Queries::where('answer','!=','')->get();
}