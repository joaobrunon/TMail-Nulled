<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El :attribute debe ser aceptado',
    'active_url' => 'El :attribute no es una URL valida',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute sólo puede contener letras.',
    'alpha_dash' => 'El :attribute sólo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute sólo puede contener letras y números.',
    'array' => 'El :attribute debe ser un array.',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El :attribute debe estar entre  :min y :max caracteres.',
        'array' => 'El :attribute debe estar entre  :min y :max items.',
    ],
    'boolean' => 'El :attribute el campo debe ser verdadero o falso.',
    'confirmed' => 'El :attribute la confirmación no coincide.',
    'date' => 'El :attribute no es una fecha valida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el formato  :format.',
    'different' => 'El :attribute y :other deben ser diferentes.',
    'digits' => 'El :attribute debe tener :digits digitos.',
    'digits_between' => 'El :attribute debe estar entre :min y :max digitos.',
    'dimensions' => 'El :attribute tiene dimensiones de imagenes invalidas.',
    'distinct' => 'El :attribute tiene un valor duplicado.',
    'email' => 'El :attribute debe ser una direccion de email valida.',
    'exists' => 'El :attribute seleccionado es invalido.',
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El :attribute El campo debe tener un valor.',
    'gt' => [
        'numeric' => 'El :attribute debe ser mayor que :value.',
        'file' => 'El :attribute  debe ser mayor que :value kilobytes.',
        'string' => 'El :attribute debe ser mayor que :value characteres.',
        'array' => 'El :attribute  debe ser mayor que :value items.',
    ],
    'gte' => [
        'numeric' => 'El :attribute  debe ser mayor o igual que :value.',
        'file' => 'El :attribute debe ser mayor o igual que  :value kilobytes.',
        'string' => 'El :attribute debe ser mayor o igual que  :value characteres.',
        'array' => 'El :attribute debe tener :value items o más.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado es invalido.',
    'in_array' => 'El :attribute campo no existe en  :otros.',
    'integer' => 'El :attribute debe ser un número entero.',
    'ip' => 'El :attribute debe tener una direccion IP valida.',
    'ipv4' => 'El :attribute debe tener una direccion IPv4 valida',
    'ipv6' => 'El :attribute debe tener una direccion IPv6 valida.',
    'json' => 'El :attribute debe tener una cadena JSON.',
    'lt' => [
        'numeric' => 'El :attribute debe ser menor que :value.',
        'file' => 'El :attribute debe ser menor que :value kilobytes.',
        'string' => 'El :attribute debe ser menor que :value characteres.',
        'array' => 'El :attribute debe ser menor que :value items.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser menor o igual que  :value.',
        'file' => 'El :attribute debe ser menor o igual que  :value kilobytes.',
        'string' => 'El :attribute debe ser menor o igual que  :value characteres.',
        'array' => 'El :attribute debe ser menor o igual que  :value items.',
    ],
    'max' => [
        'numeric' => 'El :attribute no podrá tener más de  :max.',
        'file' => 'El :attribute no podrá tener más de :max kilobytes.',
        'string' => 'El :attribute no podrá tener más de  :max characteres.',
        'array' => 'El :attribute no podrá tener más de :max items.',
    ],
    'mimes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El :attribute debe tener al menos :min.',
        'file' => 'El :attribute debe tener al menos :min kilobytes.',
        'string' => 'El :attribute debe tener al menos :min characteres.',
        'array' => 'El :attribute debe tener al menos :min items.',
    ],
    'not_in' => 'El :attribute seleccionado es invalido.',
    'not_regex' => 'El formato :attribute es invalido.',
    'numeric' => 'El :attribute debe ser un numero.',
    'present' => 'El :attribute campo debe estar presente.',
    'regex' => 'El formato :attribute es invalido.',
    'required' => 'El :attribute campo requerido.',
    'required_if' => 'El :attribute campo requerido cuando :other es :value.',
    'required_unless' => 'El :attribute campo requerido a menos que :other este en :values.',
    'required_with' => 'El :attribute campo requerido cuando :values esta presente.',
    'required_with_all' => 'El :attribute campo requerido cuando :values esta presente.',
    'required_without' => 'El :attribute campo es requerido cuando :values no esta presente.',
    'required_without_all' => 'El :attribute es obligatorio cuando ninguno de los campos de :values esta presente.',
    'same' => 'El :attribute y :other debe coincidir.',
    'size' => [
        'numeric' => 'El :attribute debe tener :size.',
        'file' => 'El :attribute debe tener :size kilobytes.',
        'string' => 'El :attribute debe tener :size caracteres.',
        'array' => 'El :attribute debe contener :size items.',
    ],
    'starts_with' => 'El :attribute  debe comenzar con una de las siguientes opciones: :values',
    'string' => 'El :attribute debe ser una cadena.',
    'timezone' => 'El :attribute debe tener una zona valida.',
    'unique' => 'El :attribute ya ha sido tomada.',
    'uploaded' => 'El :attribute fallo al cargar.',
    'url' => 'El formato :attribute es invalido.',
    'uuid' => 'El :attribute debe tener un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'Mensaje personalizado',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
