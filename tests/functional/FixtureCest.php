<?php

namespace Codeception\Module\CakeFixture\Test;

class FixtureCest
{

    public $fixtures = [
        'core.Authors',
    ];

    /**
     * @param FunctionalTester $I
     */
    public function tryLoadFixture(FunctionalTester $I)
    {
        $I->wantTo('Authors fixture loaded');
        $I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);
    }
}
