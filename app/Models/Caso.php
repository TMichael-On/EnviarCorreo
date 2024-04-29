<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caso extends Model{
    protected $table = "tbl_case";
    protected $primaryKey = 'IDCase';
    // protected $fillable = [];

    public $timestamps = false;
}