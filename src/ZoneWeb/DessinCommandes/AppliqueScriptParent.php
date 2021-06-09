<?php

namespace Pv\ZoneWeb\DessinCommandes ;

class AppliqueScriptParent extends DessinCommandes
{
	public $NomMethodeScript ;
	public $MsgMethodeNonTrouvee = "La methode %s n'existe pas dans le script parent" ;
	public function Execute(& $script, & $composant, $parametres)
	{
		$nomMtd = ($this->NomMethodeScript != '') ? $this->NomMethodeScript : "DessineCommandes" ;
		if(method_exists($script, $nomMtd))
		{
			$ctn = call_user_func_array(array($script, $nomMtd), array(& $composant, $parametres)) ;
		}
		else
		{
			$ctn = sprintf($this->MsgMethodeNonTrouvee, $nomMtd) ;
		}
		return $ctn ;
	}
}