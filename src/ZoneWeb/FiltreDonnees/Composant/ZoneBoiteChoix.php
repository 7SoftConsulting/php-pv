<?php

namespace Pv\ZoneWeb\FiltreDonnees\Composant ;

class ZoneBoiteChoix extends \Pv\ZoneWeb\FiltreDonnees\Composant\ElementFormulaire
{
	public $FournisseurDonnees = null ;
	public $NomClasseFournisseurDonnees = "\Pv\FournisseurDonnees\FournisseurDonnees" ;
	public $FiltresSelection = array() ;
	public $NomColonneValeur = "" ;
	public $NomColonneLibelle = "" ;
	public $NomColonneExtra = "" ;
	public $NomColonneValeurParDefaut = "" ;
	public $UtiliserColonneExtra = 0 ;
	protected $Elements = array() ;
	public $TotalElements = 0 ;
	public $LibelleEtiqVide = "(Non trouve)" ;
	public $StockerElements = 0 ;
	protected $RequeteSupport = false ;
	public $InclureElementHorsLigne = 0 ;
	public $ValeurElementHorsLigne = "" ;
	public $LibelleElementHorsLigne = "" ;
	public $ExtraElementHorsLigne = "" ;
	protected $ValeursSelectionnees = array() ;
	protected $ChoixMultiple = 0 ;
	public $InclureLienSelectTous = 0 ;
	public $CheminIconeLienSelectTous = "" ;
	public $LibelleLienSelectTous = "Cocher tout" ;
	public $InclureLienSelectAucun = 0 ;
	public $CheminIconeLienSelectAucun = "" ;
	public $LibelleLienSelectAucun = "Decocher Tout" ;
	public $InclureLiens = 1 ;
	public $InclureFoncJs = 1 ;
	public $SelectionStricte = false ;
	public $SeparateurLibelleEtiqVide = ", " ;
	public function & CreeFiltreRef($nom, & $filtreRef)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\Ref() ;
		$filtre->Source = & $filtreRef ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		$filtre->NomParametreDonnees = $nom ;
		return $filtre ;
	}
	public function & CreeFiltreFixe($nom, $valeur)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\Fixe() ;
		$filtre->NomParametreDonnees = $nom ;
		$filtre->ValeurParDefaut = $valeur ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		return $filtre ;
	}
	public function & CreeFiltreCookie($nom)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\Cookie() ;
		$filtre->NomParametreDonnees = $nom ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		return $filtre ;
	}
	public function & CreeFiltreSession($nom)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\Session() ;
		$filtre->NomParametreDonnees = $nom ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		return $filtre ;
	}
	public function & CreeFiltreMembreConnecte($nom, $nomParamLie='')
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\MembreConnecte() ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		$filtre->NomParametreDonnees = $nom ;
		$filtre->NomParametreLie = $nomParamLie ;
		return $filtre ;
	}
	public function & CreeFiltreHttpUpload($nom, $cheminDossierDest="")
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\HttpUpload() ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		$filtre->NomParametreDonnees = $nom ;
		$filtre->CheminDossier = $cheminDossierDest ;
		return $filtre ;
	}
	public function & CreeFiltreHttpGet($nom)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\HttpGet() ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		$filtre->NomParametreLie = $nom ;
		$filtre->NomParametreDonnees = $nom ;
		return $filtre ;
	}
	public function & CreeFiltreHttpPost($nom)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\HttpPost() ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		$filtre->NomParametreLie = $nom ;
		$filtre->NomParametreDonnees = $nom ;
		return $filtre ;
	}
	public function & CreeFiltreHttpRequest($nom)
	{
		$filtre = new \Pv\ZoneWeb\FiltreDonnees\HttpRequest() ;
		$filtre->AdopteScript($nom, $this->ScriptParent) ;
		$filtre->NomParametreLie = $nom ;
		$filtre->NomParametreDonnees = $nom ;
		return $filtre ;
	}
	public function CreeFltRef($nom, & $filtreRef)
	{
		return $this->CreeFiltreRef($nom, $filtreRef) ;
	}
	public function CreeFltFixe($nom, $valeur)
	{
		return $this->CreeFiltreRef($nom, $valeur) ;
	}
	public function CreeFltCookie($nom)
	{
		return $this->CreeFiltreCookie($nom) ;
	}
	public function CreeFltSession($nom)
	{
		return $this->CreeFiltreSession($nom) ;
	}
	public function CreeFltMembreConnecte($nom, $nomParamLie='')
	{
		return $this->CreeFiltreMembreConnecte($nom, $nomParamLie) ;
	}
	public function CreeFltHttpUpload($nom, $cheminDossierDest="")
	{
		return $this->CreeFiltreHttpUpload($nom, $cheminDossierDest) ;
	}
	public function CreeFltHttpGet($nom)
	{
		return $this->CreeFiltreHttpGet($nom) ;
	}
	public function CreeFltHttpPost($nom)
	{
		return $this->CreeFiltreHttpPost($nom) ;
	}
	public function CreeFltHttpRequest($nom)
	{
		return $this->CreeFiltreHttpRequest($nom) ;
	}
	public function & InsereFltSelectRef($nom, & $filtreRef, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreRef($nom, $filtreRef) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectFixe($nom, $valeur, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreFixe($nom, $valeur) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectCookie($nom, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreCookie($nom) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectSession($nom, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreSession($nom) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectMembreConnecte($nom, $nomParamLie='', $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreMembreConnecte($nom, $nomParamLie) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectHttpUpload($nom, $cheminDossierDest="", $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreHttpUpload($nom, $cheminDossierDest) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectHttpGet($nom, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreHttpGet($nom) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectHttpPost($nom, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreHttpPost($nom) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	public function & InsereFltSelectHttpRequest($nom, $exprDonnees='', $nomClsComp='')
	{
		$flt = $this->CreeFiltreHttpRequest($nom) ;
		$flt->ExpressionDonnees = $exprDonnees ;
		if($nomClsComp != '')
			$flt->DeclareComposant($nomClsComp) ;
		$this->FiltresSelection[] = & $flt ;
		return $flt ;
	}
	protected function RenduFoncJs()
	{
		if(! $this->InclureFoncJs || $this->ChoixMultiple == 0)
			return '' ;
		$ctn = '' ;
		$ctn .= '<script language="javascript">
function SelectElems_'.$this->IDInstanceCalc.'(mode)
{
var totalElems = '.svc_json_encode($this->TotalElements).' ;
for(var i=1; i<=totalElems; i++)
{
	var noeud = document.getElementById('.svc_json_encode($this->IDInstanceCalc.'_').' + i) ;
	if(noeud == null)
	{
		continue ;
	}
	'.PHP_EOL ;
		$ctn .= $this->InstrsJsSelectElement() ;
		$ctn .= "\t\t".'}
}
</script>' ;
		return $ctn ;
	}
	protected function InstrsJsSelectElement()
	{
		return '' ;
	}
	protected function RenduLiens()
	{
		$ctn = '' ;
		if(! $this->InclureLiens || ! $this->ChoixMultiple || ! $this->InclureLienSelectAucun && ! $this->InclureLienSelectTous)
			return $ctn ;
		if($this->TotalElements == 0)
			return $ctn ;
		$lienRendu = 0 ;
		$ctn .= '<div class="liens">'.PHP_EOL ;
		if($this->InclureLienSelectTous != 0)
		{
			$libelleLien = htmlentities($this->LibelleLienSelectTous) ;
			$ctn .= '<a href="javascript:SelectElems_'.$this->IDInstanceCalc.'(1)">'.$libelleLien.'</a>' ;
			$lienRendu = 1 ;
		}
		if($this->InclureLienSelectAucun != 0)
		{
			if($lienRendu)
			{
				$ctn .= "&nbsp;&nbsp;&nbsp;&nbsp;" ;
			}
			$libelleLien = htmlentities($this->LibelleLienSelectAucun) ;
			$ctn .= '<a href="javascript:SelectElems_'.$this->IDInstanceCalc.'(0)">'.$libelleLien.'</a>' ;
		}
		$ctn .= '</div>'.PHP_EOL ;
		return $ctn ;
	}
	public function RenduEtiquette()
	{
		$this->InitFournisseurDonnees() ;
		$this->CalculeValeursSelectionnees() ;
		$lignes = array() ;
		if($this->ChoixMultiple == 0)
		{
			$lignes = $this->FournisseurDonnees->RechExacteElements($this->FiltresSelection, $this->NomColonneValeur, $this->Valeur) ;
			// print_r($this->FournisseurDonnees) ;
		}
		else
		{
			$lignes = $this->FournisseurDonnees->SelectElements(array(), $this->FiltresSelection) ;
		}
		// print_r($this->FournisseurDonnees) ;
		$etiquette = '' ;
		if(count($lignes) > 0)
		{
			foreach($lignes as $i => $ligne)
			{
				$estSelectionnee = 0 ;
				if($this->ChoixMultiple == 0)
				{
					$estSelectionnee = 1 ;
				}
				else
				{
					if($this->NomColonneValeurParDefaut != "" && $ligne[$this->NomColonneValeurParDefaut] == 1)
					{
						$estSelectionnee = 1 ;
					}
					elseif($this->EstValeurSelectionnee($ligne[$this->NomColonneValeur]))
					{
						$estSelectionnee = 1 ;
					}
				}
				if($estSelectionnee)
				{
					if($etiquette != "")
					{
						$etiquette .= $this->SeparateurLibelleEtiqVide ;
					}
					$etiquette .= $ligne[$this->NomColonneLibelle] ;
				}
			}
		}
		else
		{
			$etiquette = $this->LibelleEtiqVide ;
		}
		return '<span id="'.$this->IDInstanceCalc.'">'.$etiquette.'</span>' ;
	}
	protected function CalculeValeursSelectionnees()
	{
		if(! $this->ChoixMultiple)
		{
			if(is_array($this->Valeur))
				$this->ValeursSelectionnees = $this->Valeur ;
			else
				$this->ValeursSelectionnees = array($this->Valeur) ;
		}
		else
		{
			$this->ValeursSelectionnees = array($this->Valeur) ;
		}
	}
	protected function EstValeurSelectionnee($valeur)
	{
		// print $this->IDInstanceCalc ;
		return (in_array($valeur, $this->ValeursSelectionnees, $this->SelectionStricte)) ? 1 : 0 ;
	}
	protected function ChargeConfigFournisseurDonnees()
	{
	}
	protected function CalculeElementsRendu()
	{
		$this->CalculeValeursSelectionnees() ;
		$this->TotalElements = 0 ;
		if(! $this->EstNul($this->FournisseurDonnees))
		{
			$this->TotalElements = $this->FournisseurDonnees->CompteElements(array(), $this->FiltresSelection) ;
		}
	}
	protected function InitFournisseurDonnees()
	{
		if($this->EstNul($this->FournisseurDonnees) && $this->NomClasseFournisseurDonnees != "")
		{
			$nomClasse = $this->NomClasseFournisseurDonnees ;
			if(class_exists($nomClasse))
			{
				$this->FournisseurDonnees = new $nomClasse() ;
			}
		}
		if(! $this->EstNul($this->FournisseurDonnees))
		{
			$this->ChargeConfigFournisseurDonnees() ;
			$this->FournisseurDonnees->ChargeConfig() ;
		}
	}
	protected function RenduListeElements()
	{
		$ctn = '' ;
		return $ctn ;
	}
	protected function RenduElement($valeur, $libelle, $ligne, $position=0)
	{
		$ctn = '' ;
		return $ctn ;
	}
	protected function OuvreRequeteSupport()
	{
		$this->TotalElements = 0 ;
		$this->RequeteSupport = $this->FournisseurDonnees->OuvreRequeteSelectElements($this->FiltresSelection) ;
		// print_r($this->FournisseurDonnees->BaseDonnees) ;
		$this->AfficheExceptionFournisseurDonnees() ;
		// echo get_class($this->FournisseurDonnees) ;
	}
	protected function LitRequeteSupport()
	{
		$val = $this->FournisseurDonnees->LitRequete($this->RequeteSupport) ;
		if($val != false)
			$this->TotalElements++ ;
		return $val ;
	}
	protected function FermeRequeteSupport()
	{
		$this->FournisseurDonnees->FermeRequete($this->RequeteSupport) ;
	}
	protected function RenduDispositifBrut()
	{
		$ctn = '' ;
		$this->InitFournisseurDonnees() ;
		if(! $this->EstNul($this->FournisseurDonnees))
		{
			$this->ChargeConfigFournisseurDonnees() ;
			$this->CalculeElementsRendu() ;
			$ctn .= $this->RenduListeElements() ;
		}
		else
		{
			die("Le composant ".$this->IDInstanceCalc." necessite un fournisseur de donnees.") ;
		}
		return $ctn ;
	}
	protected function ExtraitValeur($ligne, $nomColonne)
	{
		$valeur = isset($ligne[$nomColonne]) ? $ligne[$nomColonne] : "" ;
		return $valeur ;
	}
	public function PossedeValeursSelectionnees()
	{
		// print ($this->Valeur).'<br>' ;
		// if($this->EstPasNul($this->FormulaireDonneesParent))
		return ($this->Valeur != "" && count($this->ValeursSelectionnees) > 0) ? 1 : 0 ;
	}
}