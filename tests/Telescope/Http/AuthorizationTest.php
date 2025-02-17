<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Telescope\Http;

use LaravelHyperf\Auth\Access\Gate;
use LaravelHyperf\Auth\Contracts\Authenticatable;
use LaravelHyperf\Auth\Contracts\Gate as GateContract;
use LaravelHyperf\Http\Contracts\RequestContract;
use LaravelHyperf\Telescope\Telescope;
use LaravelHyperf\Tests\Telescope\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
class AuthorizationTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockGate();
        $this->loadServiceProviders();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Telescope::auth(null);
    }

    public function testCleanTelescopeInstallationDeniesAccessByDefault()
    {
        $this->post('/telescope/telescope-api/requests')
            ->assertStatus(403);
    }

    public function testCleanTelescopeInstallationDeniesAccessByDefaultForAnyAuthUser()
    {
        $this->actingAs(new Authenticated());

        $this->post('/telescope/telescope-api/requests')
            ->assertStatus(403);
    }

    public function testGuestsGetsUnauthorizedByGate()
    {
        Telescope::auth(function (RequestContract $request) {
            return $this->app->get(GateContract::class)
                ->check('viewTelescope', [$request->user()]);
        });

        $this->app->get(GateContract::class)
            ->define('viewTelescope', function ($user) {
                return false;
            });

        $this->post('/telescope/telescope-api/requests')
            ->assertStatus(403);
    }

    public function testAuthenticatedUserGetsAuthorizedByGate()
    {
        $this->actingAs(new Authenticated());

        Telescope::auth(function (RequestContract $request) {
            return $this->app->get(GateContract::class)
                ->check('viewTelescope', [$request->user()]);
        });

        $this->app->get(GateContract::class)
            ->define('viewTelescope', function (Authenticatable $user) {
                return $user->getAuthIdentifier() === 'telescope-test';
            });

        $this->post('/telescope/telescope-api/requests')
            ->assertStatus(200);
    }

    public function testGuestsCanBeAuthorized()
    {
        Telescope::auth(function (RequestContract $request) {
            return $this->app->get(GateContract::class)
                ->check('viewTelescope', [$request->user()]);
        });

        $this->app->get(GateContract::class)
            ->define('viewTelescope', function (?Authenticatable $user) {
                return true;
            });

        $this->post('/telescope/telescope-api/requests')
            ->assertStatus(200);
    }

    public function testUnauthorizedRequests()
    {
        Telescope::auth(function () {
            return false;
        });

        $this->get('/telescope/telescope-api/requests')
            ->assertStatus(403);
    }

    public function testAuthorizedRequests()
    {
        Telescope::auth(function () {
            return true;
        });

        $this->post('/telescope/telescope-api/requests')
            ->assertSuccessful();
    }

    protected function mockGate(): void
    {
        $gate = new Gate($this->app, function () {
            return new Authenticated('email@foo.bar');
        });

        $this->app->set(GateContract::class, $gate);
    }
}

class Authenticated implements Authenticatable
{
    public $email;

    public function getAuthIdentifierName(): string
    {
        return 'Telescope Test';
    }

    public function getAuthIdentifier(): string
    {
        return 'telescope-test';
    }

    public function getAuthPassword(): string
    {
        return 'secret';
    }
}
