<?php

return [
    /**
     * Limite de prise en charge des navigateurs.
     * {@internal
     *      Lower Than (<):
     *      'Edge', 'js:Promise'
     *      'IE11', 'borderImage'
     *      'IE10', 'transform' (Default property)
     *      'IE9', 'boxShadow'
     *      'IE8', 'borderSpacing'
     * }
     */
    'lowerThan' => 'Edge',

    /**
     * Configuration de Wordpress
     */
    'wordpress' => [
        // Chargement automatique
        'autoload' => true,
    ],
];