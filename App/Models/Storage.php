<?php 
namespace App\Models;
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Storage extends Eloquent{
	protected $table = 'storage';
	protected $fillable = ['invoice_no',
	'potato_type',
	'bags',
	'chamber',
	'level',
	'lot',
	'storage',
	'day',
	'month',
	'year',
	'date',
	'brand',
	'logo',
	'owner',
	'location',
	'replacement',
	'ration',
	'seed',
	'goli',
	'cut',
	];
    
}