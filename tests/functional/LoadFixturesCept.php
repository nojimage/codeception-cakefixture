<?php

/**
 *
 * Copyright 2018 ELASTIC Consultants Inc.
 *
 */
use Codeception\Module\CakeFixture\Test\FunctionalTester;

$I = new FunctionalTester($scenario);

$I->wantTo('load fixtures');

$I->useFixtures('core.tags');
$I->loadFixtures('Tags');
$I->seeInDatabase('tags', ['name' => 'tag1', 'description' => 'A big description']);

$I->useFixtures(['core.authors', 'core.posts']);
$I->loadFixtures('Authors');
$I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);

$I->loadFixtures();
$I->seeInDatabase('posts', ['author_id' => 1, 'title' => 'First Post']);
