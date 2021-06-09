<?php

namespace Pv\ApiRestful\Route ;

class Route extends \Pv\Objet\Objet
{
	public $MethodeHttp ;
	public $NomElementApi ;
	public $CheminRouteApi ;
	public $ApiParent ;
	public $NecessiteMembreConnecte = 0 ;
	public $Privileges = array() ;
	public $PrivilegesStricts = 0 ;
	public $ArreterExecution = false ;
	public function ApprouveAppel()
	{
		return 1 ;
	}
	public function PossedeMembreConnecte()
	{
		return $this->ApiParent->PossedeMembreConnecte() ;
	}
	public function PossedePrivilege($privilege)
	{
		return $this->ApiParent->PossedePrivilege($privilege) ;
	}
	public function PossedePrivileges($privileges)
	{
		return $this->ApiParent->PossedePrivileges($privileges) ;
	}
	public function IdMembreConnecte()
	{
		return $this->ApiParent->IdMembreConnecte() ;
	}
	public function LoginMembreConnecte()
	{
		return $this->ApiParent->LoginMembreConnecte() ;
	}
	public function EstAccessible()
	{
		return (($this->NecessiteMembreConnecte == 0 || $this->PossedeMembreConnecte()) && (count($this->Privileges) == 0 || $this->ApiParent->PossedePrivileges($this->Privileges, $this->PrivilegesStricts))) ;
	}
	public function AdopteApi($nom, $cheminRoute, & $api)
	{
		$this->NomElementApi = $nom ;
		if($this->CheminRouteApi == '')
		{
			$this->CheminRouteApi = $nom ;
		}
		$this->CheminRouteApi = $cheminRoute ;
		$this->ApiParent = & $api ;
	}
	public function SuccesReponse()
	{
		return $this->ApiParent->Reponse->EstSucces() ;
	}
	public function EchecReponse()
	{
		return $this->ApiParent->Reponse->EstEchec() ;
	}
	public function Execute()
	{
		$this->Requete = & $this->ApiParent->Requete ;
		$this->Reponse = & $this->ApiParent->Reponse ;
		$this->ContenuReponse = & $this->ApiParent->Reponse->Contenu ;
		$this->ArreterExecution = false ;
		$this->Reponse->ConfirmeSucces() ;
		$this->PrepareExecution() ;
		if($this->ArreterExecution)
		{
			return ;
		}
		$this->ExecuteInstructions() ;
		if($this->ArreterExecution)
		{
			return ;
		}
		$this->TermineExecution() ;
	}
	protected function PrepareExecution()
	{
	}
	protected function ExecuteInstructions()
	{
	}
	protected function TermineExecution()
	{
	}
	public function ConfirmeData($data)
	{
		$this->ApiParent->Reponse->Contenu->data = $data ;
	}
	public function RenseigneErreur($message='')
	{
		return $this->ApiParent->Reponse->ConfirmeInvalide($message) ;
	}
	public function RenseigneException($message='')
	{
		return $this->ApiParent->Reponse->ConfirmeErreurInterne($message) ;
	}
	public function ConfirmeSucces()
	{
		return $this->ApiParent->Reponse->ConfirmeSucces() ;
	}
	public function EstSucces()
	{
		return $this->ApiParent->Reponse->EstSucces() ;
	}
	public function EstEchec()
	{
		return ! $this->EstSucces() ;
	}
}