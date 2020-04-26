<?php


namespace Auth\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Form\View\Helper\Captcha\Dumb;
use Laminas\Validator\Hostname;

/**
 * Class LoginForm
 *
 * @package Auth\Form
 */
class LoginForm extends Form
{
    /**
     * LoginForm constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->add([
            'type' => Element\Email::class,
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'class' => 'form-control'
            ],
        ]);
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-lg btn-primary btn-block text-uppercase mt-3',
            ],
        ]);

        $this->addInputFilter();
    }

    /**
     *
     */
    public function addInputFilter(): void
    {
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => Hostname::ALLOW_DNS,
                        'useMxCheck' => false,
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 12
                    ],
                ],
            ],
        ]);
    }
}
