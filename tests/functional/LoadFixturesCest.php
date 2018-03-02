<?php
/**
 *
 * Copyright 2017 ELASTIC Consultants Inc.
 *
 */

namespace Codeception\Module\CakeFixture\Test;

/**
 * Test for CakeFixture::loadFixtures()
 */
class LoadFixturesCest
{

    public $autoFixtures = false;

    public $fixtures = [
        'core.tags',
    ];

    /**
     * @param FunctionalTester $I
     */
    public function tryLoadFixtures(FunctionalTester $I)
    {
        $I->loadFixtures('Tags');
        $I->seeInDatabase('tags', ['name' => 'tag1', 'description' => 'A big description']);

        $I->useFixtures(['core.authors', 'core.posts']);
        $I->loadFixtures('Authors');
        $I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);

        $I->loadFixtures();
        $I->seeInDatabase('posts', ['author_id' => 1, 'title' => 'First Post']);
    }
}
