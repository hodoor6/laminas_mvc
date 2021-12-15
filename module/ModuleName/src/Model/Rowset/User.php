<?php
namespace ModuleName\Model\Rowset;

class User extends AbstractModel implements \Laminas\InputFilter\InputFilterAwareInterface
{

    public $property1 = null;

    public $property2 = null;

    public $id = null;

    public function getProperty1()
    {
        return $this->property1;
    }

    public function setProperty1($value)
    {
        $this->property1 = $value;
        return $this;
    }

    public function getProperty2()
    {
        return $this->property2;
    }

    public function setProperty2($value)
    {
        $this->property2 = $value;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    public function exchangeArray(array $row)
    {
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
        $this->property1 = (!empty($row['property1'])) ? $row['property1'] : null;
        $this->property2 = (!empty($row['property2'])) ? $row['property2'] : null;
        $this->id = (!empty($row['id'])) ? $row['id'] : null;
    }

    public function getArrayCopy()
    {
        return[
            'id' => $this->getId(),
            'property1' => $this->getProperty1(),
            'property2' => $this->getProperty2(),
            'id' => $this->getId(),
        ];
    }

    public function getInputFilter()
    {
        return new \Laminas\InputFilter\InputFilter();
    }

    public function setInputFilter(\Laminas\InputFilter\InputFilterInterface $inputFilter)
    {
        throw new DomainException('This class does not support adding of extra input filters');
    }


}
