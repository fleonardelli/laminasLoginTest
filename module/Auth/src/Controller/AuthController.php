<?php

declare(strict_types=1);

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Service\User;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class AuthController
 *
 * @package Auth\Controller
 */
class AuthController extends AbstractActionController
{
    /** @var User */
    protected $userService;

    /**
     * AuthController constructor.
     *
     * @param User $userService
     */
    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \Laminas\Http\Response
     */
    public function loginAction()
    {
        $form = new LoginForm();

        if ($this->getRequest()->isPost()) {

            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $data = $form->getData();

                try {
                     $user = $this->userService->getUserByUserPass($data['email'], $data['password']);

                     return $this->redirect()->toRoute('admin', ['action'=> 'index']);
                } catch(\Exception $e) {
                    $this->flashMessenger()->addMessage($e->getMessage(), 'error');
                }

            } else {
                foreach ($form->getMessages() as $errorKey => $errorMessage) {
                    $message = sprintf('%s: %s', $errorKey, current($errorMessage));
                    $this->flashMessenger()->addMessage($message, 'error');
                }
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
}
