<?php namespace Fencus\GoogleMapsWidgets\formwidgets;

use Backend\Classes\FormWidgetBase;
use Fencus\GoogleMapsWidgets\Models\Settings as MapsSettings;
use ApplicationException;
use Lang;

class AddressFinder extends FormWidgetBase
{

	protected $defaultAlias = 'address-finder';
	
    public function widgetDetails()
    {
        return [
            'name'        => 'Address Finder',
            'description' => 'Address Finder'
        ];
    }
	
    public function init()
    {
    	$this->fillFromConfig([
    	]);
    }
    
    protected function loadAssets()
    {
    	$this->addJs('js/addressfinder.js');
    }
    
    
    public function render()
    {
   		$this->vars['name'] = $this->formField->getName();
   		$this->vars['value'] = $this->getLoadValue();
   		$this->vars['api_key'] = MapsSettings::get('api_key');
    	return $this->makePartial('addressfinder');
    }
}
