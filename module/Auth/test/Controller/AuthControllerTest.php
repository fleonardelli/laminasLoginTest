<?php

declare(strict_types=1);

namespace AuthTest\Controller;

use Auth\Controller\AuthController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AuthControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp() : void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    /**
     * @test
     */
    public function loginActionShouldBeAccessible(): void
    {
        $this->dispatch('/login', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('auth');
        $this->assertControllerName(AuthController::class);
        $this->assertControllerClass('AuthController');
        $this->assertMatchedRouteName('login');
    }

}
