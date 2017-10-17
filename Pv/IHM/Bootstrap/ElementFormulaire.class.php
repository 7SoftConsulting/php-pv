<?php
	
	if(! defined('PV_ELEMENT_FORMULAIRE_BOOTSTRAP'))
	{
		define('PV_ELEMENT_FORMULAIRE_BOOTSTRAP', 1) ;
		
		class PvCfgBootstrapSwitch
		{
			public $state = true ;
			public $size = "mini" ;
			public $animate = true ;
			public $disabled = false ;
			public $readonly = false ;
			public $indeterminate = false ;
			public $inverse = false ;
			public $radioAllOff = false ;
			public $onColor = "primary" ;
			public $offColor = "default" ;
			public $onText = "ON" ;
			public $offText = "OFF" ;
			public $labelText = "&nbsp;" ;
			public $handleWidth = "auto" ;
			public $labelWidth = "auto" ;
			public $baseClass = "bootstrap-switch" ;
			public $wrapperClass = "wrapper" ;
		}
		class PvBootstrapSwitch extends PvElementFormulaireHtml
		{
			public static $CheminFichierJs = "js/bootstrap-switch.min.js" ;
			public static $CheminFichierCSS = "css/bootstrap-switch.min.css" ;
			public static $SourceIncluse = 0 ;
			public $ValeurVrai = "1" ;
			public $ValeurFaux = "0" ;
			public $Cfg = "small" ;
			protected function InitConfig()
			{
				parent::InitConfig() ;
				$this->Cfg = new PvCfgBootstrapSwitch() ;
			}
			protected function RenduInclutSources()
			{
				if($this->ObtientValStatique("SourceIncluse") == 1)
				{
					return "" ;
				}
				$ctn = "" ;
				$ctn .= $this->RenduLienCSS($this->ObtientValStatique("CheminFichierCSS")) ;
				$ctn .= $this->RenduLienJs($this->ObtientValStatique("CheminFichierJs")) ;
				$this->AffecteValStatique("SourceIncluse", 1) ;
				return $ctn ;
			}
			protected function RenduDispositifBrut()
			{
				$this->CorrigeIDsElementHtml() ;
				$ctn = '' ;
				$styleCSS = '' ;
				$ctn .= $this->RenduInclutSources() ;
				if($this->Valeur != $this->ValeurVrai)
				{
					$this->Cfg->state = false ;
				}
				if($ctn != "") { $ctn .= PHP_EOL ; }
				$ctn .= '<input id="'.$this->IDInstanceCalc.'_Support" type="checkbox" value="'.htmlentities($this->ValeurVrai).'"'.(($this->Valeur == $this->ValeurVrai) ? ' checked' : '').' />' ;
				$ctn .= '<input name="'.$this->NomElementHtml.'"' ;
				$ctn .= ' id="'.$this->IDInstanceCalc.'"' ;
				$ctn .= ' type="hidden"' ;
				$ctn .= ' value="'.htmlspecialchars($this->Valeur).'"' ;
				$ctn .= ' />' ;
				$ctn .= $this->RenduContenuJs('jQuery(function() {
	jQuery("#'.$this->IDInstanceCalc.'_Support").bootstrapSwitch('.svc_json_encode($this->Cfg).') ;
	jQuery("#'.$this->IDInstanceCalc.'_Support").on("switchChange.bootstrapSwitch", function(event, state) {
		if(event.type === "switchChange") {
			var jqEdit = jQuery("#'.$this->IDInstanceCalc.'") ;
			var editeurSupport = this ;
			jqEdit.val((editeurSupport.checked) ? '.svc_json_encode($this->ValeurVrai).' : '.svc_json_encode($this->ValeurFaux).') ;
		}
	}) ;
}) ;') ;
				return $ctn ;
			}
		}
		
		class PvBootstrapSpinner extends PvElementFormulaireHtml
		{
			public $ValeurMin = 0 ;
			public $ValeurMax = 10 ;
			public $Ecart = 1 ;
			public static $SourceIncluse = 0 ;
			protected function CorrigeValeurParDefaut()
			{
				$this->Valeur = intval($this->Valeur) ;
				if($this->Valeur < $this->ValeurMin)
				{
					$this->Valeur = $this->ValeurMin ;
				}
				elseif($this->Valeur > $this->ValeurMax)
				{
					$this->Valeur = $this->ValeurMax ;
				}
			}
			protected function RenduInclutSources()
			{
				if(PvBootstrapSpinner::$SourceIncluse == 1)
				{
					return "" ;
				}
				$ctn = '' ;
				$ctn .= '<style type="text/css">
.spinner input {
  text-align: right;
}
.spinner .input-group-btn-vertical {
  position: relative;
  white-space: nowrap;
  width: 2%;
  vertical-align: middle;
  display: table-cell;
}
.spinner .input-group-btn-vertical > .btn {
  display: block;
  float: none;
  width: 100%;
  max-width: 100%;
  padding: 8px;
  margin-left: -1px;
  position: relative;
  border-radius: 0;
}
.spinner .input-group-btn-vertical > .btn:first-child {
  border-top-right-radius: 4px;
}
.spinner .input-group-btn-vertical > .btn:last-child {
  margin-top: -2px;
  border-bottom-right-radius: 4px;
}
.spinner .input-group-btn-vertical i {
  position: absolute;
  top: 0;
  left: 4px;
}
</style>'.PHP_EOL ;
				$ctn .= $this->RenduContenuJs('jQuery(function(){
    jQuery(".spinner input").on("change", function() {
	var input = jQuery(this) ;
	var span = (input.attr("data-spinner-span") != undefined) ? parseFloat(input.attr("data-spinner-span")) : 1 ;
	var maxValue = (input.attr("data-spinner-max") == undefined) ? 1 : parseFloat(input.attr("data-spinner-max")) ;
	var minValue = (input.attr("data-spinner-min") == undefined) ? 1 : parseFloat(input.attr("data-spinner-min")) ;
	var currentValue = parseFloat(input.val()) ;
	if(currentValue == NaN || currentValue < minValue) {
		input.val(minValue) ;
	}
	else {
		if(currentValue > maxValue) {
			input.val(maxValue) ;
		}
	}
	if(currentValue != parseInt(currentValue / span) * span) {
		input.val(parseInt(currentValue / span) * span) ;
	}
});
jQuery(".spinner .btn:first-of-type").on("click", function() {
  var btn = jQuery(this);
  var input = btn.closest(".spinner").find("input");
  var span = (input.attr("data-spinner-span") != undefined) ? parseFloat(input.attr("data-spinner-span")) : 1 ;
  if (input.attr("data-spinner-max") == undefined || parseFloat(input.val()) < parseFloat(input.attr("data-spinner-max"))) {    
	input.val(parseFloat(input.val()) + span);
  } else {
	btn.next("disabled", true);
  }
});
jQuery(".spinner .btn:last-of-type").on("click", function() {
  var btn = jQuery(this);
  var input = btn.closest(".spinner").find("input");
  var span = (input.attr("data-spinner-span") != undefined) ? parseFloat(input.attr("data-spinner-span")) : 1 ;
  if (input.attr("data-spinner-min") == undefined || parseFloat(input.val()) > parseFloat(input.attr("data-spinner-min"))) {    
	input.val(parseFloat(input.val()) - span);
  } else {
	btn.prev("disabled", true);
  }
});
}) ;') ;
				PvBootstrapSpinner::$SourceIncluse = 1 ;
				return $ctn ;
			}
			protected function RenduDispositifBrut()
			{
				$this->CorrigeIDsElementHtml() ;
				$this->CorrigeValeurParDefaut() ;
				$ctn = '' ;
				$styleCSS = '' ;
				$ctn .= $this->RenduInclutSources() ;
				$ctn .= '<div class="input-group spinner">'.PHP_EOL ;
				$ctn .= '<input name="'.htmlspecialchars($this->NomElementHtml).'"' ;
				$ctn .= ' id="'.$this->IDInstanceCalc.'"' ;
				$ctn .= ' type="text" data-spinner-min="'.$this->ValeurMin.'" data-spinner-span="'.$this->Ecart.'" data-spinner-max="'.$this->ValeurMax.'"' ;
				$ctn .= $this->RenduAttrStyleCSS() ;
				$ctn .= $this->RenduAttrsSupplHtml() ;
				$ctn .= ' value="'.htmlspecialchars($this->Valeur).'"' ;
				$ctn .= ' />'.PHP_EOL ;
				$ctn .= '<div class="input-group-btn-vertical">
<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-chevron-up"></i></button>
<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-chevron-down"></i></button>
</div>
</div>' ;
				return $ctn ;
			}
		}
		
		class PvBootstrapSelectPicker extends PvZoneSelectHtml
		{
			public $CheminFichierJs = "js/bootstrap-select.min.js" ;
			public $CheminFichierCSS = "css/bootstrap-select.min.css" ;
			public static $SourceIncluse = 0 ;
			protected function RenduInclutSources()
			{
				if(PvBootstrapSelectPicker::$SourceIncluse == 1)
				{
					return "" ;
				}
				$ctn = '' ;
				$ctn .= $this->RenduLienJs($this->CheminFichierJs) ;
				$ctn .= $this->RenduLienCSS($this->CheminFichierCSS) ;
				PvBootstrapSelectPicker::$SourceIncluse = 1 ;
				return $ctn ;
			}
			protected function RenduDispositifBrut()
			{
				$ctn = '' ;
				if(! in_array("selectpicker", $this->ClassesCSS))
				{
					$this->ClassesCSS[] = "selectpicker" ;
					// $this->ClassesCSS[] = "show-tick" ;
				}
				$ctn .= $this->RenduInclutSources() ;
				$ctn .= parent::RenduDispositifBrut() ;
				return $ctn ;
			}
		}
		class PvSelectPicker extends PvBootstrapSelectPicker
		{
		}
		class PvBootstrapSelect extends PvBootstrapSelectPicker
		{
		}
	}
	
?>