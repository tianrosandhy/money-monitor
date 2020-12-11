<?php
return [
    'driver' => 'gd',
    'enable_webp' => true,
    'thumbs' => [
        'extralarge' => [
            'label' => "Extra Large",
            'type' => 'keep-ratio',
            'width' => 1500,
            'height' => 1500
        ],
        'large' => [
            'label' => "Large",
            'type' => 'keep-ratio',
            'width' => 1200,
            'height' => 1200
        ],
        'medium' => [
            'label' => "Medium",
            'type' => 'keep-ratio',
            'width' => 700,
            'height' => 700
        ],
        'small' => [
            'label' => "Small",
            'type' => 'keep-ratio',
            'width' => 400,
            'height' => 400
        ],
        'cropped' => [
            'label' => "Cropped",
            'type' => 'fit',
            'width' => 400,
            'height' => 400
        ],
        'thumb' => [
            'label' => "Thumb",
            'type' => 'fit',
            'width' => 100,
            'height' => 100
        ],
    ],
    'origin_maximum_width' => 2000, //set to null to disable
    'quality' => 80,
];