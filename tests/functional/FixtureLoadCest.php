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
class FixtureLoadCest
{

    public $autoFixtures = false;

    public $fixtures = [
        'core.Authors',
        'core.Posts',
    ];

    /**
     * @param FunctionalTester $I
     */
    public function tryLoadFixtures(FunctionalTester $I)
    {
        $I->wantTo('loading the Authors fixture');
        $I->loadFixtures('Authors');
        $I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);

        $I->loadFixtures();
        $I->seeInDatabase('posts', ['author_id' => 1, 'title' => 'First Post']);
    }
}
