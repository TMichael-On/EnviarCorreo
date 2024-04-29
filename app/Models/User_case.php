<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_case extends Model{
    protected $table = "user_case";
    protected $primaryKey = 'IDUC';
    // protected $fillable = [];

    public $timestamps = false;
}