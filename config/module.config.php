<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'ukala_reader' => 'Doctrine\Common\Annotations\AnnotationReader',
            'ukala_cache' => 'Doctrine\Common\Cache\ArrayCache'
        ),
        'factories' => array(
            'ukala_loader' => function($sm) {
                $loader = new \Ukala\Mapping\Loader\AnnotationLoader(
                    $sm->get('ukala_reader')
                );
                $loader->setServiceLocator($sm);

                return $loader;
            },
            'ukala_factory' => function ($sm) {
                return new \Ukala\Mapping\ClassMetadataFactory\Standard(
                    $sm->get('ukala_loader'),
                    $sm->get('ukala_cache')
                );
            },
            'object_validator' => function ($sm) {
                return new \Ukala\ObjectValidator(
                    $sm->get('ukala_factory')
                );
            },
            'object_filter' => function ($sm) {
                return new \Ukala\ObjectFilter(
                    $sm->get('ukala_factory')
                );
            },
            'object_reader' => function ($sm) {
                return new \Ukala\Reader\ConsultingReader(
                    $sm->get('ukala_factory')
                );
            },
            'object_writer' => function ($sm) {
                return new \Ukala\Writer\ConsultingWriter(
                    $sm->get('ukala_factory')
                );
            },
        )
    )
);