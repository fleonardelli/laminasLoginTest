<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\ContentForm;
use Application\Service\Content;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{
    /** @var Content */
    protected $contentService;
    /** @var AuthenticationService */
    protected $authenticationService;

    /**
     * IndexController constructor.
     *
     * @param Content               $contentService
     * @param AuthenticationService $authenticationService
     */
    public function __construct(Content $contentService, AuthenticationService $authenticationService)
    {
        $this->contentService = $contentService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return \Laminas\Http\Response|ViewModel
     */
    public function indexAction()
    {
        //TODO: Create service based solution.
        $errors = [];
        $messages = [];

        $user = $this->authenticationService->getIdentity();
        $form = new ContentForm();

        if ($this->getRequest()->isPost()) {

            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $data = $form->getData();
                $contentId = $this->contentService->create($data['title'], $data['text'], $user);
                $messages[] = "Content created successfully with id: {$contentId}";
            } else {
                foreach ($form->getMessages() as $errorKey => $errorMessage) {
                    $message = sprintf('%s: %s', $errorKey, current($errorMessage));
                    $errors[] = $message;
                }
            }
        }

        return new ViewModel([
            'form' => $form,
            'username' => $user->getUsername() ?? '',
            'errors' => $errors,
            'messages' => $messages,
        ]);
    }
}
