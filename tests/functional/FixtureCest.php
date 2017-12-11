<?php
/**
 *
 * Copyright 2017 ELASTIC Consultants Inc.
 *
 */

namespace Codeception\Module\CakeFixture\Test;

/**
 * Test for CakeFixture module, auto load fixtures.
 */
class FixtureCest
{

    public $fixtures = [
        'core.Authors',
    ];

    /**
     * @param FunctionalTester $I
     */
    public function tryAutoLoadFixtures(FunctionalTester $I)
    {
        $I->wantTo('auto load the Authors fixture');
        $I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);
    }
}
