<?php

declare(strict_types=1);

it('returns a successful response for the home page', function () {
    $this->get('/')->assertOk();
});

it('returns a successful response for the health check endpoint', function () {
    $this->get('/up')->assertOk();
});
