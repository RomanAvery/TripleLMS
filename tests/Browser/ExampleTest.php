<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

test('homepage', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSee('Test content');
    });
});
