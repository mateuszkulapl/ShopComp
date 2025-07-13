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
    'accepted' => ':attribute musi być zaakceptowane.',
    'accepted_if' => ':attribute musi być zaakceptowane, gdy :other to :value.',
    'active_url' => ':attribute musi być poprawnym adresem URL.',
    'after' => ':attribute musi być datą późniejszą niż :date.',
    'after_or_equal' => ':attribute musi być datą nie wcześniejszą niż :date.',
    'alpha' => ':attribute może zawierać tylko litery.',
    'alpha_dash' => ':attribute może zawierać tylko litery, cyfry, myślniki i podkreślenia.',
    'alpha_num' => ':attribute może zawierać tylko litery i cyfry.',
    'array' => ':attribute musi być listą.',
    'ascii' => ':attribute może zawierać tylko znaki ASCII.',
    'before' => ':attribute musi być datą wcześniejszą niż :date.',
    'before_or_equal' => ':attribute musi być datą nie późniejszą niż :date.',
    'between' => [
        'array' => ':attribute musi mieć od :min do :max elementów.',
        'file' => ':attribute musi mieć od :min do :max kilobajtów.',
        'numeric' => ':attribute musi być między :min a :max.',
        'string' => ':attribute musi mieć od :min do :max znaków.',
    ],
    'boolean' => ':attribute musi być zaznaczone lub nie.',
    'can' => ':attribute zawiera niedozwoloną wartość.',
    'confirmed' => 'Potwierdzenie :attribute nie pasuje.',
    'contains' => 'Brakuje wymaganej wartości w :attribute.',
    'current_password' => 'Podane hasło jest nieprawidłowe.',
    'date' => ':attribute musi być poprawną datą.',
    'date_equals' => ':attribute musi być datą równą :date.',
    'date_format' => ':attribute musi być w formacie :format.',
    'decimal' => ':attribute musi mieć :decimal miejsc po przecinku.',
    'declined' => ':attribute musi być odrzucone.',
    'declined_if' => ':attribute musi być odrzucone, gdy :other to :value.',
    'different' => ':attribute i :other muszą się różnić.',
    'digits' => ':attribute musi mieć :digits cyfr.',
    'digits_between' => ':attribute musi mieć od :min do :max cyfr.',
    'dimensions' => ':attribute ma nieprawidłowe wymiary obrazka.',
    'distinct' => ':attribute zawiera powtarzające się wartości.',
    'doesnt_end_with' => ':attribute nie może kończyć się na: :values.',
    'doesnt_start_with' => ':attribute nie może zaczynać się od: :values.',
    'email' => ':attribute musi być poprawnym adresem e-mail.',
    'ends_with' => ':attribute musi kończyć się jednym z: :values.',
    'enum' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'exists' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'extensions' => ':attribute musi mieć jedno z rozszerzeń: :values.',
    'file' => ':attribute musi być plikiem.',
    'filled' => ':attribute musi mieć wartość.',
    'gt' => [
        'array' => ':attribute musi mieć więcej niż :value elementów.',
        'file' => ':attribute musi mieć więcej niż :value kilobajtów.',
        'numeric' => ':attribute musi być większe niż :value.',
        'string' => ':attribute musi mieć więcej niż :value znaków.',
    ],
    'gte' => [
        'array' => ':attribute musi mieć co najmniej :value elementów.',
        'file' => ':attribute musi mieć co najmniej :value kilobajtów.',
        'numeric' => ':attribute musi być większe lub równe :value.',
        'string' => ':attribute musi mieć co najmniej :value znaków.',
    ],
    'hex_color' => ':attribute musi być poprawnym kolorem w formacie szesnastkowym.',
    'image' => ':attribute musi być obrazkiem.',
    'in' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'in_array' => ':attribute musi istnieć w :other.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => ':attribute musi być poprawnym adresem IP.',
    'ipv4' => ':attribute musi być poprawnym adresem IPv4.',
    'ipv6' => ':attribute musi być poprawnym adresem IPv6.',
    'json' => ':attribute musi być poprawnym ciągiem JSON.',
    'list' => ':attribute musi być listą.',
    'lowercase' => ':attribute musi być zapisane małymi literami.',
    'lt' => [
        'array' => ':attribute musi mieć mniej niż :value elementów.',
        'file' => ':attribute musi mieć mniej niż :value kilobajtów.',
        'numeric' => ':attribute musi być mniejsze niż :value.',
        'string' => ':attribute musi mieć mniej niż :value znaków.',
    ],
    'lte' => [
        'array' => ':attribute nie może mieć więcej niż :value elementów.',
        'file' => ':attribute musi mieć maksymalnie :value kilobajtów.',
        'numeric' => ':attribute musi być mniejsze lub równe :value.',
        'string' => ':attribute musi mieć maksymalnie :value znaków.',
    ],
    'mac_address' => ':attribute musi być poprawnym adresem MAC.',
    'max' => [
        'array' => ':attribute nie może mieć więcej niż :max elementów.',
        'file' => ':attribute nie może być większe niż :max kilobajtów.',
        'numeric' => ':attribute nie może być większe niż :max.',
        'string' => ':attribute nie może mieć więcej niż :max znaków.',
    ],
    'max_digits' => ':attribute nie może mieć więcej niż :max cyfr.',
    'mimes' => ':attribute musi być plikiem typu: :values.',
    'mimetypes' => ':attribute musi być plikiem typu: :values.',
    'min' => [
        'array' => ':attribute musi mieć przynajmniej :min elementów.',
        'file' => ':attribute musi mieć przynajmniej :min kilobajtów.',
        'numeric' => ':attribute musi być przynajmniej :min.',
        'string' => ':attribute musi mieć przynajmniej :min znaków.',
    ],
    'min_digits' => ':attribute musi mieć przynajmniej :min cyfr.',
    'missing' => ':attribute powinno być puste.',
    'missing_if' => ':attribute powinno być puste, jeśli :other to :value.',
    'missing_unless' => ':attribute powinno być puste, chyba że :other to :value.',
    'missing_with' => ':attribute powinno być puste, jeśli jest :values.',
    'missing_with_all' => ':attribute powinno być puste, jeśli są: :values.',
    'multiple_of' => ':attribute musi być wielokrotnością :value.',
    'not_in' => 'Wybrana wartość :attribute jest nieprawidłowa.',
    'not_regex' => ':attribute ma nieprawidłowy format.',
    'numeric' => ':attribute musi być liczbą.',
    'password' => [
        'letters' => ':attribute musi zawierać przynajmniej jedną literę.',
        'mixed' => ':attribute musi mieć małą i wielką literę.',
        'numbers' => ':attribute musi zawierać przynajmniej jedną cyfrę.',
        'symbols' => ':attribute musi zawierać przynajmniej jeden znak specjalny.',
        'uncompromised' => 'To :attribute pojawiło się w wycieku danych. Wybierz inne.',
    ],
    'present' => ':attribute musi być podane.',
    'present_if' => ':attribute musi być podane, gdy :other to :value.',
    'present_unless' => ':attribute musi być podane, chyba że :other to :value.',
    'present_with' => ':attribute musi być podane, jeśli jest :values.',
    'present_with_all' => ':attribute musi być podane, jeśli są: :values.',
    'prohibited' => ':attribute jest zabronione.',
    'prohibited_if' => ':attribute jest zabronione, jeśli :other to :value.',
    'prohibited_if_accepted' => ':attribute jest zabronione, jeśli :other jest zaakceptowane.',
    'prohibited_if_declined' => ':attribute jest zabronione, jeśli :other jest odrzucone.',
    'prohibited_unless' => ':attribute jest zabronione, chyba że :other jest jednym z: :values.',
    'prohibits' => ':attribute uniemożliwia podanie :other.',
    'regex' => ':attribute ma nieprawidłowy format.',
    'required' => ':attribute jest wymagane.',
    'required_array_keys' => ':attribute musi zawierać: :values.',
    'required_if' => ':attribute jest wymagane, jeśli :other to :value.',
    'required_if_accepted' => ':attribute jest wymagane, jeśli :other jest zaakceptowane.',
    'required_if_declined' => ':attribute jest wymagane, jeśli :other jest odrzucone.',
    'required_unless' => ':attribute jest wymagane, chyba że :other jest jednym z: :values.',
    'required_with' => ':attribute jest wymagane, jeśli jest :values.',
    'required_with_all' => ':attribute jest wymagane, jeśli są: :values.',
    'required_without' => ':attribute jest wymagane, jeśli nie ma :values.',
    'required_without_all' => ':attribute jest wymagane, jeśli nie ma żadnego z: :values.',
    'same' => ':attribute musi być takie samo jak :other.',
    'size' => [
        'array' => ':attribute musi mieć :size elementów.',
        'file' => ':attribute musi mieć :size kilobajtów.',
        'numeric' => ':attribute musi być równe :size.',
        'string' => ':attribute musi mieć :size znaków.',
    ],
    'starts_with' => ':attribute musi zaczynać się od jednego z: :values.',
    'string' => ':attribute musi być tekstem.',
    'timezone' => ':attribute musi być poprawną strefą czasową.',
    'unique' => 'To :attribute jest już zajęte.',
    'uploaded' => 'Nie udało się przesłać :attribute.',
    'uppercase' => ':attribute musi być zapisane wielkimi literami.',
    'url' => ':attribute musi być poprawnym adresem URL.',
    'ulid' => ':attribute musi być poprawnym ULID.',
    'uuid' => ':attribute musi być poprawnym UUID.',

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
            'rule-name' => 'custom-message',
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
