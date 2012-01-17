<?php
require_once __DIR__ . '/../autoload_register.php';

$rootPath  = realpath(dirname(__DIR__));
$testsPath = "$rootPath/tests";

if (is_readable($testsPath . '/TestConfiguration.php')) {
    require_once $testsPath . '/TestConfiguration.php';
} else {
    require_once $testsPath . '/TestConfiguration.php.dist';
}

$path = array(
    $testsPath,
    ZEND_FRAMEWORK_PATH,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

require_once 'Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array(
    'namespaces' => array(
        'UkalaTest' => $testsPath . '/UkalaTest'
    )
)));

$listenerOptions  = new Zend\Module\Listener\ListenerOptions(array(
    'module_paths' => array(
        realpath(__DIR__ . '/../..'),
        SPIFFY_DOCTRINE_PATH,
    )
));

$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);

$moduleManager = new Zend\Module\Manager(array(
    'SpiffyDoctrine',
    'SpiffyDoctrineORM',
    'Ukala'
));
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

$config = $moduleManager->getEvent()->getConfigListener()->getMergedConfig()->toArray();


$di = new \Zend\Di\Di;
$di->instanceManager()->addTypePreference('Zend\Di\Locator', $di);

$config = new \Zend\Di\Configuration($config['di']);
$config->configure($di);

\UkalaTest\Framework\TestCase::$locator = $di;