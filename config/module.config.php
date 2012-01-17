<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'ukala_reader' => 'Doctrine\Common\Annotations\AnnotationReader',
                'ukala_cache' => 'Doctrine\Common\Cache\ArrayCache',
                'ukala_loader' => 'Ukala\Mapping\Loader\AnnotationLoader',
                'ukala_factory' => 'Ukala\Mapping\ClassMetadataFactory\Standard',
                'object_validator' => 'Ukala\ObjectValidator'
            ),
            'ukala_loader' => array(
                'parameters' => array(
                    'reader' => 'ukala_reader'
                )
            ),
            'ukala_factory' => array(
                'parameters' => array(
                    'loader' => 'ukala_loader',
                    'cache' => 'ukala_cache'
                )
            ),
            'object_validator' => array(
                'parameters' => array(
                    'classMetadataFactory' => 'ukala_factory'
                )
            )
        )
    )
);