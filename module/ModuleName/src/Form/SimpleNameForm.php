<?php
namespace ModuleName\Form;

use \Laminas\Form\Element;

class SimpleNameForm extends \Laminas\Form\Form implements \Laminas\InputFilter\InputFilterProviderInterface
{

    public const ELEMENT_PROPERTY1 = 'property1';

    public const ELEMENT_PROPERTY2 = 'property2';

    public function __construct($name = 'SimpleName_form', array $params = [])
    {
        parent::__construct($name, $params);
        $this->setAttribute('class', 'styledForm');
        
        $this->add([
            'name' => self::ELEMENT_PROPERTY1,
            'type' => 'text',
            'options' => [
                'label' => 'property1'
            ],
            'attributes' => [
                'required' => true
            ]
        ]);
        
        $this->add([
            'name' => self::ELEMENT_PROPERTY2,
            'type' => 'text',
            'options' => [
                'label' => 'property2'
            ],
            'attributes' => [
                'required' => true
            ]
        ]);
        
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }


}
