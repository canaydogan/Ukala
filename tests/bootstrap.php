<?php
putenv('APPLICATION_ENV=testing');

use Zend\ServiceManager\ServiceManager,
    Zend\Mvc\Service\ServiceManagerConfiguration,
    Zend\Di\Di,
    Zend\Di\Configuration as DiConfiguration,
    Zend\Loader\AutoloaderFactory,
    UkalaTest\Framework\TestCase;

chdir(__DIR__);

$previousDir = '.';

while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());

    if ($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php":'
                . ' is DoctrineModule in a subdir of your application skeleton?'
        );
    }

    $previousDir = $dir;
    chdir($dir);
}

if (!include('vendor/autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run php composer.phar install?');
}

$rootPath  = realpath(dirname(__DIR__));
$testsPath = "$rootPath/tests";
//Add namespaces
AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array(
    'namespaces' => array(
        'UkalaTest' => $testsPath . '/UkalaTest'
    )
)));

// get application stack configuration
$configuration = require 'config/application.config.php';

// setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($configuration['service_manager']));
$serviceManager->setService('ApplicationConfiguration', $configuration);

$config = $serviceManager->get('Configuration');

$di = new Di();
$di->instanceManager()->addTypePreference('Zend\Di\LocatorInterface', $di);
$config = new DiConfiguration($config['di']);
$config->configure($di);

TestCase::$locator = $di;