<?php

namespace Codeception\Module\CakeFixture\Test;

class FixtureLoadCest
{

    public $autoFixtures = false;

    public $fixtures = [
        'core.Authors',
    ];

    /**
     * @param FunctionalTester $I
     */
    public function tryLoadFixture(FunctionalTester $I)
    {
        $I->wantTo('Authors fixture loaded');
        $I->loadFixtures('Authors');
        $I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);
    }
}
