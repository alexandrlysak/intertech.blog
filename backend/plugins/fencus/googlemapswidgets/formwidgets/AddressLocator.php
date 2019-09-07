<?php namespace Fencus\GoogleMapsWidgets\formwidgets;

use Backend\Classes\FormWidgetBase;
use ApplicationException;
use Lang;

class AddressLocator extends FormWidgetBase
{

	protected $defaultAlias = 'address-locator';
	
    public function widgetDetails()
    {
        return [
            'name'        => 'Address Locator',
            'description' => 'Address Locator'
        ];
    }
	
    public function init()
    {
    	$this->fillFromConfig([
    	]);
    }
    
    protected function loadAssets()
    {
    	$this->addJs('js/addresslocator.js');
    }
    
    
    public function render()
    {
   		$this->vars['name'] = $this->formField->getName();
   		$this->vars['value'] = $this->getLoadValue();
    	return $this->makePartial('addresslocator');
    }
}
