<?php

namespace Joesama\Profile\Tests\Unit;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Joesama\Profile\Events\ProfileSaved;
use Joesama\Profile\Services\UserProfile;

class ProfileSavingTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__.'/../../database/migrations'),
        ]);

        $this->artisan('migrate', ['--database' => 'testing']);
    }
    
    /**
    * Define environment setup.
    *
    * @param  \Illuminate\Foundation\Application  $app
    * @return void
    */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('profile', [
           'user' => [
                'model' => env('PROFILE_USER', 'Joesama\Profile\Data\Model\User'),
                'uuid' => env('PROFILE_UUID', 'guid'),
           ],
           'verification' => env('VERIFY_PROFILE', true),
           'model' => [
                'default' => 'Joesama\Profile\Data\Model\Profile',
                'organization' => 'Joesama\Profile\Data\Model\ProfileWithOrganization'
            ],
            'has' => [
                'organization' => env('ORG_PROFILE', true),
            ],
            'allow' => [
                'import' => env('IMPORT_PROFILE', true),
                'registeration' => env('REGISTER_PROFILE', true),
            ],
        ]);

        $app['config']->set('database.default', 'testing');
    }

    /**
     * A basic unit test example.
     * @test
     * @testdox Called user profile with empty parameters
     * and validate if ProfileSaved event triggered.
     *
     * @return void
     */
    public function getUserProfileWithEmptyParameter()
    {
        Event::fake();

        $params = [
            "name" => null,
            "email" => null,
            "position" => null,
            "department" => null,
            "unit" => null,
            "role" => null,
            "uuid" => null
        ];
        
        $profile = new UserProfile();

        $verification = $profile->verify($params);

        $errors = $profile->validationErrors();

        $detail = $profile->profile($params);

        Event::assertDispatched(ProfileSaved::class);

        $this->assertFalse($verification);

        $this->assertInstanceOf(MessageBag::class, $errors);

        $this->assertInstanceOf(Model::class, $detail);
    }
}
