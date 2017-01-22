<?php

namespace FlSouto;

class HtButton extends HtField{

	protected $label;

	function __construct($name, $label=null){		
		$this->label = $label ?: $name;
		parent::__construct($name);
		$this->inline(false);
	}

	function label($label){
		$this->label = $label;
		return $this;
	}

	function inline($inline){	
		$style = ['display'=>$inline?'inline-block':'block'];	
		if($inline){
			$style['vertical-align'] = 'text-top';
		}
		$this->attrs(['style'=>$style]);
		return $this;
	}

	function render(){
		$this->attrs(['value'=>1]);
		echo "<button {$this->attrs}>{$this->label}</button>";
	}

}