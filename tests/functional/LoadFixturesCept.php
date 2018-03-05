<?php

/**
 *
 * Copyright 2018 ELASTIC Consultants Inc.
 *
 */

use Codeception\Exception\ModuleException;
use Codeception\Module\CakeFixture\Test\FunctionalTester;

$I = new FunctionalTester($scenario);

$I->wantTo('load fixtures');

$I->useFixtures(['core.authors', 'core.posts']);
$I->loadFixtures('Authors');
$I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);

$I->loadFixtures();
$I->seeInDatabase('posts', ['author_id' => 1, 'title' => 'First Post']);

// useFixtures use only once
$I->expectException(ModuleException::class, function () use ($I) {
    $I->useFixtures('core.tags');
});
