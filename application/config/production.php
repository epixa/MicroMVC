<?php
/**
 * Production configuration values
 * 
 * MicroMVC
 */
return array(
    'controller' => array(
        'debug' => array(
            'renderExceptions' => true
        )
    ),
    'resources' => array(
        'database'
    ),
    'database' => array(
        'dsnParams' => array(
            'host' => 'localhost',
            'dbname' => 'microdb'
        ),
        'username' => 'dbuser',
        'password' => 'dbpass'
    )
);