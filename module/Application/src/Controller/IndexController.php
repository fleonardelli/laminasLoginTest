<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\ErrorMessage;
use Application\Entity\InfoMessage;
use Application\Form\ContentForm;
use Application\Service\Content;
use Application\Service\MessageBag;
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
    /** @var MessageBag */
    protected $messageBag;

    /**
     * IndexController constructor.
     *
     * @param Content               $contentService
     * @param AuthenticationService $authenticationService
     * @param MessageBag            $messageBag
     */
    public function __construct(
        Content $contentService,
        AuthenticationService $authenticationService,
        MessageBag $messageBag
    ) {
        $this->contentService = $contentService;
        $this->authenticationService = $authenticationService;
        $this->messageBag = $messageBag;
    }

    /**
     * @return \Laminas\Http\Response|ViewModel
     */
    public function indexAction()
    {
        $user = $this->authenticationService->getIdentity();
        $form = new ContentForm();

        if ($this->getRequest()->isPost()) {

            $form->setData($this->params()->fromPost());

            if($form->isValid()) {
                $data = $form->getData();
                $contentId = $this->contentService->create($data['title'], $data['text'], $user);
                $this->messageBag->addMessage(
                    "Content created successfully with id: {$contentId}",
                    InfoMessage::TYPE
                );

            } else {
                foreach ($form->getMessages() as $errorKey => $errorMessage) {
                    $message = sprintf('%s: %s', $errorKey, current($errorMessage));
                    $this->messageBag->addMessage($message, ErrorMessage::TYPE);
                }
            }
        }

        return new ViewModel([
            'form' => $form,
            'username' => $user->getUsername() ?? '',
            'messages' => $this->messageBag->getMessages(),
        ]);
    }
}
