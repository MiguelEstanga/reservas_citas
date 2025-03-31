<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser una cadena de caracteres.',
    'max' => [
        'string' => 'El campo :attribute no debe ser mayor que :max caracteres.',
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
    ],
    'integer' => 'El campo :attribute debe ser un número entero.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
    ],
    'date_format' => 'El campo :attribute no coincide con el formato :format.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'in' => 'El campo :attribute seleccionado no es válido.',
    'attributes' => [
        'nombre' => 'nombre',
        'ubicacion' => 'dirección',
        'capacidad' => 'capacidad',
        'hora_inicio' => 'hora de inicio',
        'hora_fin' => 'hora de fin',
        'day' => 'día de la reunión'
    ],
];