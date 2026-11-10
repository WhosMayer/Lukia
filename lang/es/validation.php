<?php
return [
 'required'=>'El campo :attribute es obligatorio.', 'email'=>'Escribe un correo electrónico válido.',
 'unique'=>'Ya existe un registro con ese :attribute.', 'confirmed'=>'Las contraseñas no coinciden.',
 'min'=>['string'=>':attribute debe tener al menos :min caracteres.','numeric'=>':attribute debe ser al menos :min.'],
 'max'=>['string'=>':attribute no puede superar :max caracteres.'],
 'date_format'=>'El formato de :attribute no es válido.', 'exists'=>'Selecciona una categoría de tu cuenta.',
 'in'=>'Selecciona un tipo de movimiento válido.', 'regex'=>'Escribe un monto positivo sin separadores de miles y con máximo dos decimales.',
 'numeric'=>':attribute debe ser un número.', 'string'=>':attribute debe ser texto.', 'integer'=>':attribute debe ser un número entero.',
 'attributes'=>['name'=>'nombre','email'=>'correo electrónico','password'=>'contraseña','amount'=>'monto','date'=>'fecha','month'=>'mes','description'=>'descripción','category_id'=>'categoría','type'=>'tipo'],
];
