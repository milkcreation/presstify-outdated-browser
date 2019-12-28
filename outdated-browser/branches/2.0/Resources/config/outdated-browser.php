<?php

return [
    /**
     * Couleur de fond du message.
     */
    'bgColor'               => '#F25648',

    /**
     * Couleur du texte du message.
     */
    'color'                 => '#FFFFFF',

    /**
     * Limite de prise en charge des navigateurs.
     * {@internal
     *      Lower Than (<):
     *      "IE11","borderImage"
     *      "IE10", "transform" (Default property)
     *      "IE9", "boxShadow"
     *      "IE8", "borderSpacing"
     * }
     */
    'lowerThan'             => 'borderImage',

    /**
     * Chemin absolue vers le gabarit d'affichage personnalisé.
     * ex. your_path/outdatedbrowser/lang/en.html
     */
    'languagePath'          => ''
];