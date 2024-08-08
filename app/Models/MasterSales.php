<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSales extends Model
{
    use HasFactory;
    protected $table = 'table_d';
    public $timestamps = false;
    //guarded
    protected $guarded = [];

}
