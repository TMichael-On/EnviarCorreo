<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{
    protected $table = "tbl_user";
    protected $primaryKey = 'IDUser';

    protected $fillable = [
        'nombres',
        'apellidos' ,
        'correo' ,
        'contra' ,
        'telefono' ,
        'urlGmail' ,
        'codWhatsapp' ,
    ];

    protected $hidden = [
        'contra',
        'codWhatsapp',
    ];
    
    public $timestamps = false;
}