<?php

return [
    'encoding'           => 'UTF-8',
    'finalize'           => true,
    'preload'            => false,
    'cachePath'          => storage_path('app/purifier'),
    'cacheFileMode'      => 0755,
    'settings'           => [
        'default' => [
            'HTML.Doctype'             => 'XHTML 1.0 Transitional',
            'HTML.Allowed'             => 'p,b,a[href],i,em,strong,ul,ol,li',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty'   => true,
        ],
        'test'    => [
            'Attr.EnableID' => 'true',
        ],
        'youtube' => [
            'HTML.SafeIframe'      => 'true',
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www.youtube(?:-nocookie)?.com/embed/|player.vimeo.com/video/)%',
        ],
    ],

    // Optional, you can add your own settings here
    'custom_definition' => [
        'id'      => 'html5-definitions',
        'rev'     => 1,
        'debug'   => false,
        'elements' => [
            // Allow iFrame elements
            ['iframe', 'Block', 'Inline', 'Replace', 'Common', [
                'align'        => 'Enum#left,right,center',
                'height'       => 'Text',
                'width'        => 'Text',
                'frameborder'  => 'Text',
                'src'          => 'Text',
                'allowfullscreen' => 'Bool',
            ]],
        ],
        'attributes' => [
            // Allow data-* attributes
            ['div', 'data-*'],
            ['span', 'data-*'],
        ],
    ],

    // Optional, you can add your own custom attributes here
    'custom_elements' => [
        'u' => 'Inline',  // Define a new element <u> for underline
    ],

    // Additional settings can be added here
];
