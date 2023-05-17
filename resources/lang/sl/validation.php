<?php

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

return [
    'accepted'             => ':attribute mora biti sprejet.',
    'active_url'           => ':attribute ni pravilen.',
    'after'                => ':attribute mora biti za datumom :date.',
    'after_or_equal'       => ':attribute mora biti za ali enak :date.',
    'alpha'                => ':attribute lahko vsebuje samo črke.',
    'alpha_dash'           => ':attribute lahko vsebuje samo črke, številke in črtice.',
    'alpha_num'            => ':attribute lahko vsebuje samo črke in številke.',
    'array'                => ':attribute mora biti polje.',
    'attached'             => 'Ta :attribute je že priložena.',
    'before'               => ':attribute mora biti pred datumom :date.',
    'before_or_equal'      => ':attribute mora biti pred ali enak :date.',
    'between'              => [
        'array'   => ':attribute mora imeti med :min in :max elementov.',
        'file'    => ':attribute mora biti med :min in :max kilobajti.',
        'numeric' => ':attribute mora biti med :min in :max.',
        'string'  => ':attribute mora biti med :min in :max znaki.',
    ],
    'boolean'              => ':attribute polje mora biti 1 ali 0',
    'confirmed'            => ':attribute potrditev se ne ujema.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => ':attribute ni veljaven datum.',
    'date_equals'          => ':attribute mora biti enak :date.',
    'date_format'          => ':attribute se ne ujema z obliko :format.',
    'different'            => ':attribute in :other mora biti drugačen.',
    'digits'               => ':attribute mora imeti :digits cifer.',
    'digits_between'       => ':attribute mora biti med :min in :max ciframi.',
    'dimensions'           => ':attribute ima napačne dimenzije slike.',
    'distinct'             => ':attribute je duplikat.',
    'email'                => ':attribute mora biti veljaven e-poštni naslov.',
    'ends_with'            => ':attribute se mora končati z eno od naslednjih vrednosti: :values.',
    'exists'               => 'izbran :attribute je neveljaven.',
    'file'                 => ':attribute mora biti datoteka.',
    'filled'               => ':attribute mora biti izpolnjen.',
    'gt'                   => [
        'array'   => ':attribute mora imeti več kot :value elementov.',
        'file'    => ':attribute mora biti večji od :value kilobajtov.',
        'numeric' => ':attribute mora biti večji od :value.',
        'string'  => ':attribute mora imeti več kot :value znakov.',
    ],
    'gte'                  => [
        'array'   => ':attribute mora imeti število elementov enako ali večje od :value.',
        'file'    => ':attribute mora biti večji ali enak :value kilobajtov.',
        'numeric' => ':attribute mora biti večji ali enak :value.',
        'string'  => ':attribute mora imeti število znakov večje ali enako :value.',
    ],
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'izbran :attribute je neveljaven.',
    'in_array'             => ':attribute ne obstaja v :other.',
    'integer'              => ':attribute mora biti število.',
    'ip'                   => ':attribute mora biti veljaven IP naslov.',
    'ipv4'                 => ':attribute mora biti veljaven IPv4 naslov.',
    'ipv6'                 => ':attribute mora biti veljaven IPv6 naslov.',
    'json'                 => ':attribute mora biti veljaven JSON tekst.',
    'lt'                   => [
        'array'   => ':attribute mora imeti manj kot :value elementov.',
        'file'    => ':attribute mora biti manjši od :value kilobajtov.',
        'numeric' => ':attribute mora biti manjši od :value.',
        'string'  => ':attribute mora imeti manj kot :value znakov.',
    ],
    'lte'                  => [
        'array'   => ':attribute mora imeti število elementov manjše ali enako :value.',
        'file'    => ':attribute mora biti manjši ali enak od :value kilobajtov.',
        'numeric' => ':attribute mora biti manjši ali enak :value.',
        'string'  => ':attribute mora imeti število znakov manjše ali enako :value.',
    ],
    'max'                  => [
        'array'   => ':attribute ne smejo imeti več kot :max elementov.',
        'file'    => ':attribute ne sme biti večje :max kilobajtov.',
        'numeric' => ':attribute ne sme biti večje od :max.',
        'string'  => ':attribute ne sme biti večje :max znakov.',
    ],
    'mimes'                => ':attribute mora biti datoteka tipa: :values.',
    'mimetypes'            => ':attribute mora biti datoteka tipa: :values.',
    'min'                  => [
        'array'   => ':attribute mora imeti vsaj :min elementov.',
        'file'    => ':attribute mora imeti vsaj :min kilobajtov.',
        'numeric' => ':attribute mora biti vsaj dolžine :min.',
        'string'  => ':attribute mora imeti vsaj :min znakov.',
    ],
    'multiple_of'          => ':attribute mora biti večkratnik od :value',
    'not_in'               => 'Izbran :attribute je neveljaven.',
    'not_regex'            => 'Format :attribute je neveljaven.',
    'numeric'              => ':attribute mora biti število.',
    'password'             => 'Greslo ni pravilno.',
    'present'              => 'Polje :attribute mora biti prisotno.',
    'prohibited'           => 'Polje :attribute je prepovedano.',
    'prohibited_if'        => 'Polje :attribute je prepovedano, ko je :other :value.',
    'prohibited_unless'    => 'Polje :attribute je prepovedano, razen če je :other v :values.',
    'regex'                => 'Format polja :attribute je neveljaven.',
    'relatable'            => 'Ta :attribute morda ni povezan s tem virom.',
    'required'             => 'Polje :attribute je obvezno.',
    'required_if'          => 'Polje :attribute je obvezno, če je :other enak :value.',
    'required_unless'      => 'Polje :attribute je obvezno, razen če je :other v :values.',
    'required_with'        => 'Polje :attribute je obvezno, če je :values prisoten.',
    'required_with_all'    => 'Polje :attribute je obvezno, če so :values prisoten.',
    'required_without'     => 'Polje :attribute je obvezno, če :values ni prisoten.',
    'required_without_all' => 'Polje :attribute je obvezno, če :values niso prisotni.',
    'same'                 => 'Polje :attribute in :other se morata ujemati.',
    'size'                 => [
        'array'   => ':attribute mora vsebovati :size elementov.',
        'file'    => ':attribute mora biti :size kilobajtov.',
        'numeric' => ':attribute mora biti :size.',
        'string'  => ':attribute mora biti :size znakov.',
    ],
    'starts_with'          => ':attribute se mora začeti z eno od naslednjih vrednosti: :values',
    'string'               => ':attribute mora biti tekst.',
    'timezone'             => ':attribute mora biti časovna cona.',
    'unique'               => ':attribute je že zaseden.',
    'uploaded'             => 'Nalaganje :attribute ni uspelo.',
    'url'                  => ':attribute format je neveljaven.',
    'uuid'                 => ':attribute mora biti veljaven UUID.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'Prilagojeno sporočilo',
        ],
    ],
    'attributes'           => [],
];
