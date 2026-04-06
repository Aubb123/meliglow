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
    'accepted'        => 'Le champ :attribute doit être accepté.',
    'active_url'      => "Le champ :attribute n'est pas une URL valide.",
    'after'           => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal'  => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'alpha'           => 'Le champ :attribute doit contenir uniquement des lettres.',
    'alpha_dash'      => 'Le champ :attribute doit contenir uniquement des lettres, des chiffres et des tirets.',
    'alpha_num'       => 'Le champ :attribute doit contenir uniquement des chiffres et des lettres.',
    'array'           => 'Le champ :attribute doit être un tableau.',
    'before'          => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date antérieure ou égale au :date.',
    'between'         => [
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'file'    => 'La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir entre :min et :max caractères.',
        'array'   => 'Le tableau :attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean'        => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'      => 'Le champ de confirmation :attribute ne correspond pas.',
    'date'           => "Le champ :attribute n'est pas une date valide.",
    'date_equals'    => 'Le champ :attribute doit être une date égale à :date.',
    'date_format'    => 'Le champ :attribute ne correspond pas au format :format.',
    'different'      => 'Les champs :attribute et :other doivent être différents.',
    'digits'         => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'dimensions'     => "La taille de l'image :attribute n'est pas conforme.",
    'distinct'       => 'Le champ :attribute a une valeur en double.',
    'email'          => 'Le champ :attribute doit être une adresse email valide.',
    'ends_with'      => 'Le champ :attribute doit se terminer par une des valeurs suivantes : :values',
    'exists'         => 'Le champ :attribute sélectionné est invalide.',
    'file'           => 'Le champ :attribute doit être un fichier.',
    'filled'         => 'Le champ :attribute doit avoir une valeur.',
    'gt'             => [
        'numeric' => 'La valeur de :attribute doit être supérieure à :value.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir plus de :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir plus de :value éléments.',
    ],
    'gte' => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :value.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure ou égale à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au moins :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir au moins :value éléments.',
    ],
    'image'    => 'Le champ :attribute doit être une image.',
    'in'       => 'Le champ :attribute est invalide.',
    'in_array' => "Le champ :attribute n'existe pas dans :other.",
    'integer'  => 'Le champ :attribute doit être un entier.',
    'ip'       => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4'     => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6'     => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json'     => 'Le champ :attribute doit être un document JSON valide.',
    'lt'       => [
        'numeric' => 'La valeur de :attribute doit être inférieure à :value.',
        'file'    => 'La taille du fichier de :attribute doit être inférieure à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir moins de :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir moins de :value éléments.',
    ],
    'lte' => [
        'numeric' => 'La valeur de :attribute doit être inférieure ou égale à :value.',
        'file'    => 'La taille du fichier de :attribute doit être inférieure ou égale à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au plus :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir au plus :value éléments.',
    ],
    'max' => [
        'numeric' => 'La valeur de :attribute ne peut être supérieure à :max.',
        'file'    => 'La taille du fichier de :attribute ne peut pas dépasser :max kilo-octets.',
        'string'  => 'Le texte de :attribute ne peut contenir plus de :max caractères.',
        'array'   => 'Le tableau :attribute ne peut contenir plus de :max éléments.',
    ],
    'mimes'     => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'min'       => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :min.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure à :min kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le tableau :attribute doit contenir au moins :min éléments.',
    ],
    'not_in'               => "Le champ :attribute sélectionné n'est pas valide.",
    'not_regex'            => "Le format du champ :attribute n'est pas valide.",
    'numeric'              => 'Le champ :attribute doit contenir un nombre.',
    'password'             => 'Le mot de passe est incorrect',
    'current_password'     => 'Le mot de passe est incorrect',
    'present'              => 'Le champ :attribute doit être présent.',
    'regex'                => 'Le format du champ :attribute est invalide, le champ :attribute doit contenir au moins 8 caractères, 1 lettre ou chiffre, un symbole spécial',
    'required'             => 'Le champ :attribute est obligatoire.',
    'required_if'          => 'Le champ :attribute est obligatoire quand la valeur de :other est :value.',
    'required_unless'      => 'Le champ :attribute est obligatoire sauf si :other est :values.',
    'required_with'        => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_with_all'    => 'Le champ :attribute est obligatoire quand :values sont présents.',
    'required_without'     => "Le champ :attribute est obligatoire quand :values n'est pas présent.",
    'required_without_all' => "Le champ :attribute est requis quand aucun de :values n'est présent.",
    'same'                 => 'Les champs :attribute et :other doivent être identiques.',
    'size'                 => [
        'numeric' => 'La valeur de :attribute doit être :size.',
        'file'    => 'La taille du fichier de :attribute doit être de :size kilo-octets.',
        'string'  => 'Le texte de :attribute doit contenir :size caractères.',
        'array'   => 'Le tableau :attribute doit contenir :size éléments.',
    ],
    'starts_with' => 'Le champ :attribute doit commencer avec une des valeurs suivantes : :values',
    'string'      => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone'    => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique'      => 'La valeur du champ :attribute est déjà utilisée.',
    'uploaded'    => "Le fichier du champ :attribute n'a pu être téléversé.",
    'url'         => "Le format de l'URL de :attribute n'est pas valide.",
    'uuid'        => 'Le champ :attribute doit être un UUID valide',
    
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

    'attributes' => [
        'firstname'             => 'prénom',
        'lastname'              => 'nom',
        'fullname'              => 'nom complet',
        'name'                  => 'nom',
        'email'                 => 'adresse email',
        'password'              => 'mot de passe',
        'confirm_password'      => 'confirmation du mot de passe',
        'current_password'      => 'mot de passe actuel',
        'phone1'                => 'numéro',
        'phone2'                => 'numéro',
        'sexe'                  => 'sexe',
        'year'                  => 'année',
        'time_read'             => 'temps de lecture',
        'pathImg'               => 'image', 
        'categorie_token'       => 'catégorie', 
        'categorieToken'        => 'catégorie', 
        'duration'              => 'durée', 
        'pathVdo'               => 'vidéo', 
        'tags_token'             => 'balise (tag)', 
        'percent_off'           => 'réduction', 
        'percent_by_order'      => 'bénéfice',
        'password_confirmation' => 'confirmez votre mot de passe',
        'role_token'            => 'role',
        'etat'                  => 'état',
        'name'                  => 'nom',
        'username'              => "nom d'utilisateur",
        'email'                 => 'adresse email',
        'first_name'            => 'prénom',
        'last_name'             => 'nom',
        'password'              => 'mot de passe',
        'confirm_password'      => 'confirmation du mot de passe',
        'city'                  => 'ville',
        'country'               => 'pays',
        'address'               => 'adresse',
        'phone'                 => 'téléphone',
        'mobile'                => 'portable',
        'age'                   => 'âge',
        'gender'                => 'genre',
        'day'                   => 'jour',
        'month'                 => 'mois',
        'hour'                  => 'heure',
        'minute'                => 'minute',
        'second'                => 'seconde',
        'title'                 => 'titre',
        'content'               => 'contenu',
        'description'           => 'description',
        'excerpt'               => 'extrait',
        'date'                  => 'date',
        'time'                  => 'heure',
        'available'             => 'disponible',
        'size'                  => 'taille',
        'sign_agree_check'      => 'termes et conditions', 
        'path'                  => 'image', 
        'path.*'                => 'image', 
        'minimum_price'         => 'prix minimum', 
        'maximum_price'         => 'prix maximum', 
        'visibility'            => 'visibilité', 
        'path_video'            => 'vidéo', 
        'subscriber_email'      => 'email', 
        'products'              => 'produits', 
        'product'               => 'produit', 
        'quantity'              => 'quantité', 
        'products.*'            => 'produit',
        'label'                 => 'libellé',
        'pack_id'               => 'pack',
        'older_price'           => 'ancien prix',
        'price'                 => 'prix',
        'stock_quantity'        => 'stock',
        'packk'                 => 'pack',
        'promo'                 => 'promotion',
        'price_delivery'        => 'cout du transport',
        'delivery'              => 'livraison',
        'shop'                  => 'boutique',
        'payment_method'        => 'méthode de paiement',
        'number_payment'        => 'numéro de paiement',
        'tel_one'               => 'téléphone',
        'tel_two'               => 'téléphone',
        'datetime'              => 'date & heure',
        'nbr'                   => 'nombre',
        'timeRead'              => 'temps de lecture',
        'percentOff'            => 'pourcentage de réduction',
        'user_token'            => 'token de l\'utilisateur',
        'author'                => 'auteur',
        'start'                 => 'début',
        'end'                   => 'fin',
        'searchField'           => 'recherché',
        'amount'                => 'montant',
        'min_person'            => 'minimum personne',
        'max_person'            => 'maximum personne',

        'purchase_price'        => 'prix d\'achat',
        'sale_price'            => 'prix de vente',
        'supplier_token.0'      => 'fournisseur',
        'unit_price.0'          => 'prix unitaire',
        'product_token.0'       => 'produit',
        'qty.0'                 => 'quantité',
        'type_token'            => 'type',
        'gender_token'          => 'genre',
        'comment_token_'        => 'réponse',
        'birth_date'            => 'date de naissance',
        'query'                 => 'terme de recherche',
        'per_page'              => 'éléments par page',
        'payment_method_id'     => 'méthode de paiement',

        'delete_forever'        => 'supprimer définitivement',

        'country_token'        => 'pays',
        'terms'                 => 'conditions générales d\'utilisation & politique de confidentialité',
    ],
];