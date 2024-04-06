<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prueba_p;

class PruebaControlador extends Controller{

    public function index(){
        // $datosPrueba= app('db')->select("SELECT * FROM tabla_p");
        $datosPrueba=  Prueba_p::all();
        return response()->json($datosPrueba);   
    }

    public function guardar(Request $request){

        // DB::insert('insert into users (id, name) values (?, ?)', [1, 'Marc']);

        $datosPrueba = new Prueba_p;
        $datosPrueba->id = $request->id;    
        $datosPrueba->save(); //METODO ORM

        return response()->json($request);
    }

    public function buscarId($id) {
        $datosPrueba = new Prueba_p;
        $datosEncontrados= $datosPrueba->find($id); //METODO ORM

        return response()->json($datosEncontrados);
    }

    public function eliminar($id) {
        $datosPrueba = Prueba_p::find($id);

        if($datosPrueba){
            $datosPrueba->delete(); //METODO ORM
        }        

        return response()->json('borrar');        
    }

    public function actualizar(Request $request, $id) {
        $datosPrueba = Prueba_p::find($id); 

        if($datosPrueba){
            if($request->input('id')){
                $datosPrueba->id = $request->input('id');
            }
            $datosPrueba->save(); //METODO ORM
        }

        return response()->json($datosPrueba);
    }

}