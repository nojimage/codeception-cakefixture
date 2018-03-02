<?php
/**
 * Test suite bootstrap
 */
// fixes class conflict on PHPUnit >= 5.7
if (class_exists('\PHPUnit\Runner\Version') && version_compare(\PHPUnit\Runner\Version::id(), '5.7', '>=') &&
    !function_exists('loadPHPUnitAliases')) {
    function loadPHPUnitAliases() {
        // nothing to do
    }
}
if (!class_exists('\PHPUnit_Framework_MockObject_Generator') && class_exists('\PHPUnit\Framework\MockObject\Generator')) {
    class_alias('\PHPUnit\Framework\MockObject\Generator', '\PHPUnit_Framework_MockObject_Generator');
}

/*
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);
if (file_exists($root . '/config/bootstrap.php')) {
    require $root . '/config/bootstrap.php';
} else {
    require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';
}
