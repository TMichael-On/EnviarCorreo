<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mensajes de validación
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
    | la clase de validación. Algunas de estas reglas tienen múltiples versiones tales
    | como las reglas de tamaño. Siéntete libre de modificar cada uno de estos mensajes aquí.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha después de :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha después o igual a :date.',
    'alpha'                => 'El campo :attribute sólo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute sólo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num'            => 'El campo :attribute sólo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha antes de :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha antes o igual a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file'    => 'El archivo :attribute debe tener entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe tener entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe tener entre :min y :max elementos.',
    ],
    'required'             => 'El campo :attribute es obligatorio.',
    'unique'               => 'Ya existe un usuario con el mismo correo',
    // Otras reglas de validación aquí...

];