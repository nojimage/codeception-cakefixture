<?php
/**
 *
 * Copyright 2017 ELASTIC Consultants Inc.
 *
 */

namespace Codeception\Module\CakeFixture\Test;

use Codeception\Exception\ModuleException;

/**
 * Test for CakeFixture::loadFixtures()
 */
class LoadFixturesCest
{

    public $autoFixtures = false;

    public $fixtures = [
        'core.authors',
        'core.posts'
    ];

    /**
     * @param FunctionalTester $I
     */
    public function tryLoadFixtures(FunctionalTester $I)
    {
        $I->loadFixtures('Authors');
        $I->seeInDatabase('authors', ['id' => 1, 'name' => 'mariano']);

        $I->loadFixtures();
        $I->seeInDatabase('posts', ['author_id' => 1, 'title' => 'First Post']);

        // useFixtures use only once
        $I->expectException(ModuleException::class, function () use ($I) {
            $I->useFixtures('core.tags');
        });
    }
}
