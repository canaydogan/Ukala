<?php

namespace UkalaTest;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use RuntimeException;
use UkalaTest\Framework\TestCase;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap
{
    protected static $serviceManager;
    protected static $config;
    protected static $bootstrap;

    public static function init()
    {
        // Load the user-defined test configuration file, if it exists; otherwise, load
        if (is_readable(__DIR__ . '/TestConfig.php')) {
            $testConfig = include __DIR__ . '/TestConfig.php';
        } else {
            $testConfig = include __DIR__ . '/TestConfig.php.dist';
        }

        $zf2ModulePaths = array();

        if (isset($testConfig['module_listener_options']['module_paths'])) {
            $modulePaths = $testConfig['module_listener_options']['module_paths'];
            foreach ($modulePaths as $modulePath) {
                if (($path = static::findParentPath($modulePath)) ) {
                    $zf2ModulePaths[] = $path;
                }
            }
        }

        $zf2ModulePaths  = implode(PATH_SEPARATOR, $zf2ModulePaths) . PATH_SEPARATOR;
        $zf2ModulePaths .= getenv('ZF2_MODULES_TEST_PATHS') ?: (defined('ZF2_MODULES_TEST_PATHS') ? ZF2_MODULES_TEST_PATHS : '');

        static::initAutoloader();

        // use ModuleManager to load this module and it's dependencies
        $baseConfig = array(
            'module_listener_options' => array(
                'module_paths' => explode(PATH_SEPARATOR, $zf2ModulePaths),
            ),
        );

        $config = ArrayUtils::merge($baseConfig, $testConfig);

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();

        /**
         * Testlerde kullanılan instance'ları manager'a ekleme.
         */
        foreach (array(
             'Zend\I18n\Filter\Alnum' => 'Zend\I18n\Filter\Alnum',
             'Ukala\Element\Property' => 'Ukala\Element\Property',
             'Ukala\Element\Method' => 'Ukala\Element\Method'
         ) as $name => $instance) {
            $serviceManager->setInvokableClass($name, $instance);
        }

        static::$serviceManager = $serviceManager;
        static::$config = $config;
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    public static function getConfig()
    {
        return static::$config;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            $loader = include $vendorPath . '/autoload.php';
        } else {
            $zf2Path = getenv('ZF2_PATH') ?: (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath . '/ZF2/library') ? $vendorPath . '/ZF2/library' : false));

            if (!$zf2Path) {
                throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
            }

            include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';

        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();


/*putenv('APPLICATION_ENV=testing');

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

TestCase::$locator = $di;*/