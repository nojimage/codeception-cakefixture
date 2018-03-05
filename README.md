# CakeFixture - CakePHP's Fixture loader for Codeception

<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://travis-ci.org/nojimage/codeception-cakefixture" target="_blank">
        <img alt="Build Status" src="https://img.shields.io/travis/nojimage/codeception-cakefixture/master.svg?style=flat-square">
    </a>
    <a href="https://packagist.org/packages/elstc/codeception-cakefixture" target="_blank">
        <img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/elstc/codeception-cakefixture.svg?style=flat-square">
    </a>
</p>

This Codeception module can be able load [CakePHP Fixutre](https://book.cakephp.org/3.0/en/development/testing.html#fixtures) in your test case.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require --dev elstc/codeception-cakefixture
```


Then enable this module in your test suite configration file (eg: `acceptance.suite.yml`, `functional.suite.yml`, and etc...):

```
modules:
    enabled:
        - CakeFixture
```

See: [06-ModulesAndHelpers - Codeception - Documentation](http://codeception.com/docs/06-ModulesAndHelpers)


If you have not yet read the CakePHP bootstrap file with in the Codeception bootstrap, then load it:

```php
<?php
// your tests/_bootstrap.php

require_once '__YOUR_CAKEPHP_CONFIG_PATH__/bootstrap.php';

```

## Usage

### Cest

In your `Cest` test case, write `$fixutures` property:

```php
class AwesomeCest
{
    public $fixtures = [
        'app.users',
        'app.posts',
    ];

    // ...
}
```

You can use `$autoFixtures`, `$dropTables` property, and `loadFixtures()` method:

```php
class AwesomeCest
{
    public $autoFixtures = false;
    public $dropTables = false;
    public $fixtures = [
        'app.users',
        'app.posts',
    ];

    public function tryYourSenario($I)
    {
        // load fixtures manually
        $I->loadFixtures('Users', 'Posts');
        // or load all fixtures
        $I->loadFixtures();
        // ...
    }
}
```

### Cept

In your `Cept` test case, use `$I->useFixtures()` and `$I->loadFixtures()`:

```php
$I = new FunctionalTester($scenario);

// You should call `useFixtures` before `loadFixtures`
$I->useFixtures('app.users', 'app.posts');
// Then load fixtures manually
$I->loadFixtures('Users', 'Posts');
// or load all fixtures
$I->loadFixtures();
```



## Configuration options

#### `debug`

Pass to FixtureManager's debug option.

default: `false`


#### `autoFixures`

Default `$autoFixtures` property.

default: `true`

#### `dropTables`

Default `$dropTables` property.

default: `true`
