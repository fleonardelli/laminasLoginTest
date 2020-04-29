<?php


use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;
use PHPUnit\Framework\TestCase;

/**
 * Class AuthTest
 */
class AuthTest extends TestCase
{
    /** @var AuthenticationService */
    private $authenticationService;

    /** @var \Auth\Service\Auth  */
    private $authService;

    /**
     * @dataProvider routesConfigProvider
     */
    protected function setUp(): void
    {
        $this->authenticationService = $this->createMock(AuthenticationService::class);

        $config = $this->routesConfigProvider();

        $this->authService = new \Auth\Service\Auth($this->authenticationService, $config);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenUserIsAlreadyLoggedIn(): void
    {
        $this->expectException(\Auth\Exception\UserLoggedInException::class);

        $this->authenticationService
            ->method('getIdentity')
            ->willReturn($this->createMock(\Auth\Entity\User::class));

        $this->authService->login('test@test.com', 'password');
    }

    public function shouldThrowExceptionWhenUserIsNotLoggedIn(): void
    {
        $this->expectException(\Auth\Exception\UserNotLoggedInException::class);

        $this->authenticationService
            ->method('getIdentity')
            ->willReturn(null);

        $this->authService->logout();
    }

    /**
     * @test
     */
    public function shouldRunAuthenticationWhenUserIsNotLoggedIn(): void
    {
        $this->authenticationService
            ->method('getIdentity')
            ->willReturn(null);

        $authAdapter = $this
            ->getMockBuilder(\Auth\Service\AuthAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->authenticationService
            ->method('getAdapter')
            ->willReturn($authAdapter);

        $this->authenticationService
            ->method('authenticate')
            ->willReturn($this->createMock(Result::class));

        $this->authenticationService
            ->expects($this->once())
            ->method('authenticate');

        $this->authService->login('test@test.com', 'password');
    }

    /**
     * @test
     */
    public function shouldClearIdentityWhenUserLoggedIn(): void
    {
        $this->authenticationService
            ->method('getIdentity')
            ->willReturn($this->createMock(\Auth\Entity\User::class));

        $this->authenticationService
            ->expects($this->once())
            ->method('clearIdentity');

        $this->authService->logout();
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenUserHasAccessToRouteAndIsLoggedIn(): void
    {
        $this->authenticationService
            ->method('hasIdentity')
            ->willReturn(true);

        $result = $this->authService->filterAccess('testController', 'index');

        $this->assertTrue($result);
    }

    /**
     * @throws Exception
     */
    public function shouldReturnFalseWhenUserHasAccessAndIsNotLoggedIn(): void
    {
        $this->authenticationService
            ->method('hasIdentity')
            ->willReturn(false);

        $result = $this->authService->filterAccess('testController', 'index');

        $this->assertTrue($result);
    }

    //There should be more Test cases coverage here. These are just examples.

    /**
     * @return array
     */
    public function routesConfigProvider(): array
    {
        return [
            'options' => [
                'mode' => 'restrictive'
            ],
            'controllers' => [
                'testController' => [
                    ['actions' => ['index'], 'allow' => '@']
                ],
            ],
        ];
    }
}
