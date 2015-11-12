<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            

            'core' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/core[/:action]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                     
                    'defaults' => array(
                        'controller' => 'Core\Controller\Actions',
                        'action'     => 'list',
                    ),
                 ),
            ),
            
            'dispatch' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '[/:hash]',
                    'constraints' => array(
                        'hash'     => '[a-zA-Z0-9_-]{8}',
                    ),
                    'defaults' => array(
                        'controller' => 'Core\Controller\Actions',
                        'action'     => 'get',
                    ),
                )
            )
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Core\Controller\Actions' => 'Core\Controller\ActionsController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
