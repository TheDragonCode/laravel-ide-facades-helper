<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Filename & Format
      |--------------------------------------------------------------------------
      |
      | The default filename (without extension) and the format (php or json)
      |
      */

    'filename' => '_ide_helper',
    'format'   => 'php',

    /*
    |--------------------------------------------------------------------------
    | Model locations to include
    |--------------------------------------------------------------------------
    |
    | Define in which directories the ide-helper:models command should look
    | for models.
    |
    | To process all files, specify "*".
    |
    */

    'facade_locations' => [
        'app\Facades',
    ],
];
