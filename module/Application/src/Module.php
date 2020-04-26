<?php

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\MvcEvent;
use Auth\Controller\AuthController;
use Auth\Service\Auth;
use Laminas\Mvc\Controller\AbstractActionController;

/**
 * Class Module
 *
 * @package Application
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event): void
    {
        // Get event manager.
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        // Register the event listener method.
        $sharedEventManager->attach(AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
    }

    /**
     * @param MvcEvent $event
     *
     * @return mixed
     */
    public function onDispatch(MvcEvent $event)
    {
        $controller = $event->getTarget();
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        $actionName = $event->getRouteMatch()->getParam('action', null);

        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));

        $authManager = $event->getApplication()->getServiceManager()->get(Auth::class);

        if (AuthController::class != $controllerName &&
            !$authManager->filterAccess($controllerName, $actionName)
        ) {

            return $controller->redirect()->toRoute('login');
        }
    }
}
