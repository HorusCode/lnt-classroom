<?php

return [
    'allow_private_folder' => true,

    // Ex: The private folder of user will be named as the user id.
    'private_folder_name'      => App\Handlers\ConfigHandler::class,

    'allow_shared_folder'      => true,

    'shared_folder_name'       => 'shares',

    /*
    |--------------------------------------------------------------------------
    | Folder Names
    |--------------------------------------------------------------------------
     */

    'folder_categories'        => [
        'file'  => [
            'folder_name'  => 'files',
            'startup_view' => 'grid',
            'max_size'     => 50000, // size in KB
            'valid_mime'   => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
            ],
        ],
        'image' => [
            'folder_name'  => 'photos',
            'startup_view' => 'list',
            'max_size'     => 50000, // size in KB
            'valid_mime'   => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'application/pdf',
                'text/plain',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload / Validation
    |--------------------------------------------------------------------------
     */

    'disk'                     => 'public',

    'rename_file'              => false,

    'alphanumeric_filename'    => false,

    'alphanumeric_directory'   => false,

    'should_validate_size'     => false,

    'should_validate_mime'     => false,

    // behavior on files with identical name
    // setting it to true cause old file replace with new one
    // setting it to false show `error-file-exist` error and stop upload
    'over_write_on_duplicate'  => false,

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
     */

    // If true, image thumbnails would be created during upload
    'should_create_thumbnails' => true,

    'thumb_folder_name'        => 'thumbs',

    // Create thumbnails automatically only for listed types.
    'raster_mimetypes'         => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    ],

    'thumb_img_width'          => 200, // px

    'thumb_img_height'         => 200, // px

    /*
    |--------------------------------------------------------------------------
    | File Extension Information
    |--------------------------------------------------------------------------
     */

    'file_type_array'          => [
        'pdf'  => 'Adobe Acrobat',
        'doc'  => 'Microsoft Word',
        'docx' => 'Microsoft Word',
        'xls'  => 'Microsoft Excel',
        'xlsx' => 'Microsoft Excel',
        'zip'  => 'Archive',
        'gif'  => 'GIF Image',
        'jpg'  => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png'  => 'PNG Image',
        'ppt'  => 'Microsoft PowerPoint',
        'pptx' => 'Microsoft PowerPoint',
    ],

    /*
    |--------------------------------------------------------------------------
    | php.ini override
    |--------------------------------------------------------------------------
    |
    | These values override your php.ini settings before uploading files
    | Set these to false to ingnore and apply your php.ini settings
    |
    | Please note that the 'upload_max_filesize' & 'post_max_size'
    | directives are not supported.
     */
    'php_ini_overrides'        => [
        'memory_limit' => '256M',
    ],
];