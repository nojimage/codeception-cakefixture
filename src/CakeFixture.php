<?php
/**
 *
 * Copyright 2017 ELASTIC Consultants Inc.
 *
 */

namespace Codeception\Module;

use Cake\TestSuite\Fixture\FixtureManager;
use Codeception\Module;
use Codeception\TestInterface;
use Codeception\Test\Cest;
use Exception;
use stdClass;

/**
 * CakePHP Fixture Module
 *
 * @see Cake\TestSuite\Fixture\FixtureInjector
 */
class CakeFixture extends Module
{

    /**
     * @var array
     */
    protected $config = [
        // pass to FixtureManager's debug option
        'debug' => false,
        // default $autoFixtures property
        'autoFixtures' => true,
        // default $dropTables property
        'dropTables' => true,
    ];

    /**
     * The instance of the fixture manager to use
     *
     * @var FixtureManager
     */
    protected $fixtureManager;

    /**
     * Current TestCase
     *
     * @var stdClass
     */
    protected $testCase;

    /**
     * Load FixtureManager
     *
     * @return void
     */
    // @codingStandardsIgnoreStart
    public function _initialize()// @codingStandardsIgnoreEnd
    {
        $manager = new FixtureManager();
        $manager->setDebug($this->_getConfig('debug'));

        $this->fixtureManager = $manager;
        $this->fixtureManager->shutDown();

        $this->debugSection('Fixture', 'Initialized FixtureManager, debug=' . (int)$this->_getConfig('debug'));
    }

    /**
     * Destroys the fixtures created by the fixture manager at the end of
     * the test suite run
     */
    // @codingStandardsIgnoreStart
    public function _afterSuite()// @codingStandardsIgnoreEnd
    {
        $this->testCase = null;
        $this->fixtureManager->shutDown();
        $this->debugSection('Fixture', 'FixtureManager shutDown');
    }

    /**
     * Adds fixtures to a test case when it starts.
     *
     * @param TestInterface $test The test case
     * @return void
     */
    // @codingStandardsIgnoreStart
    public function _before(TestInterface $test)// @codingStandardsIgnoreEnd
    {
        if ($this->hasFixtures($test)) {
            $this->debugSection('Fixture', 'Test class is: ' . get_class($test->getTestClass()));
            $this->testCase = $this->setRequireProperties($test->getTestClass());
            $this->fixtureManager->fixturize($this->testCase);

            $this->debugSection('Fixture', 'Load fixtures: ' . implode(', ', $this->testCase->fixtures));
            $this->fixtureManager->load($this->testCase);
        }
    }

    /**
     * Unloads fixtures from the test case.
     *
     * @param TestInterface $test The test case
     * @return void
     */
    // @codingStandardsIgnoreStart
    public function _after(TestInterface $test)// @codingStandardsIgnoreEnd
    {
        if ($this->hasFixtures($test)) {
            $this->debugSection('Fixture', 'Unload fixtures: ' . implode(', ', $test->getTestClass()->fixtures));
            $this->fixtureManager->unload($test->getTestClass());
        }

        $this->testCase = null;
    }

    /**
     * Chooses which fixtures to load for a given test
     *
     * Each parameter is a model name that corresponds to a fixture, i.e. 'Posts', 'Authors', etc.
     * Passing no parameters will cause all fixtures on the test case to load.
     *
     * @return void
     * @see Cake\TestSuite\TestCase::loadFixtures()
     * @throws Exception when no fixture manager is available.
     */
    public function loadFixtures()
    {
        $args = func_get_args();
        foreach ($args as $class) {
            $this->fixtureManager->loadSingle($class, null, $this->testCase->dropTables);
        }

        if (empty($args)) {
            $autoFixtures = $this->testCase->autoFixtures;
            $this->testCase->autoFixtures = true;
            $this->fixtureManager->load($this);
            $this->testCase->autoFixtures = $autoFixtures;
        }
    }

    /**
     * check the test class has $fixtures
     *
     * @param Cest $test a Cest object
     * @return bool
     */
    private function hasFixtures($test)
    {
        return $test instanceof Cest && property_exists($test->getTestClass(), 'fixtures');
    }

    /**
     * set required properties to a given test class
     *
     * @param stdClass $testClass Target test case
     * @return stdClass
     */
    private function setRequireProperties($testClass)
    {
        if (!property_exists($testClass, 'autoFixtures')) {
            $testClass->autoFixtures = $this->_getConfig('autoFixtures');
        }
        if (!property_exists($testClass, 'dropTables')) {
            $testClass->dropTables = $this->_getConfig('dropTables');
        }

        return $testClass;
    }
}
