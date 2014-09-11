<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }

    public function setUp() {
        parent::setUp();
        $this->app['router']->enableFilters();

        Artisan::call('migrate');
    }

    protected function createUser($email, $password = 'password') {
        $user = User::create(
            array(
                'email' => $email,
                'password' => Hash::make($password)
            )
        );
        return $user;
    }

}
