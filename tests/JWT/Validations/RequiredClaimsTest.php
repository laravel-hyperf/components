<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\JWT\Validations;

use LaravelHyperf\JWT\Exceptions\TokenInvalidException;
use LaravelHyperf\JWT\Validations\RequiredClaims;
use LaravelHyperf\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RequiredClaimsTest extends TestCase
{
    public function testValid()
    {
        $this->expectNotToPerformAssertions();

        (new RequiredClaims([]))->validate([]);
        (new RequiredClaims(['required_claims' => ['sub']]))->validate(['sub' => 'foo']);
    }

    public function testInvalid()
    {
        $this->expectException(TokenInvalidException::class);
        $this->expectExceptionMessage('Claims are missing: ["sub"]');

        (new RequiredClaims(['required_claims' => ['sub']]))->validate([]);
    }
}
