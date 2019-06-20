<?php

return [
    'name'                    => 'Migrations',
    'migrations_namespace'    => 'App\Migrations',
    'table_name'              => 'migration_versions',
    'migrations_directory'    => 'src/Migrations',
    'check_database_platform' => true,
    'column_name'             => 'version',
    'column_length'           => 128,
];
