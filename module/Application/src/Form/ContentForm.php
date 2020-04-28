<?php


namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Laminas\Validator\Hostname;

/**
 * Class ContentForm
 *
 * @package Auth\Form
 */
class ContentForm extends Form
{
    /**
     * ContentForm constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->add([
            'type' => Element\Text::class,
            'name' => 'title',
            'options' => [
                'label' => 'Title',
            ],
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '150',
                'required' => true
            ],
        ]);
        $this->add([
            'type' => Element\Textarea::class,
            'name' => 'text',
            'options' => [
                'label' => 'Content',
            ],
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'required' => true
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
            'name'     => 'title',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 150
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'text',
            'required' => true,
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255
                    ],
                ],
            ],
        ]);
    }
}
