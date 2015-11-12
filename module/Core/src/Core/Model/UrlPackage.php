<?php
namespace Core\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class UrlPackage implements InputFilterAwareInterface
{
	public $id;
	public $url;
	public $hash;

	protected $inputFilter; 

    public function extract()
    {
       return [
           'id' => $this->id,
           'url' => $this->url,
           'hash' => $this->hash,
           // ...
       ];
    }

	public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }

	public function exchangeArray($data)
	{
		$this->id    = (!empty($data['id']))   ? $data['id'] : null;
		$this->url   = (!empty($data['url']))  ? $data['url'] : null;
		$this->hash  = (!empty($data['hash'])) ? $data['hash'] : null;
	}

	public function getInputFilter()
    {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'url',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StringTrim'),
                 )
             ));

             $inputFilter->add(array(
                 'name'     => 'hash',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 )
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
    }
}
 ?>