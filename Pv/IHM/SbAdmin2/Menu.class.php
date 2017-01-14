<?php
	
	if(! defined('PV_MENU_SB_ADMIN2'))
	{
		define('PV_MENU_SB_ADMIN2', 1) ;
		
		class PvMenuOuvreBoiteDlgUrl extends PvMenuIHMBase
		{
			public $TitreDlg ;
			public $UrlDlg ;
			public $LargeurDlg = null ;
			public $HauteurDlg = null ;
			public $RafraichPageSurFerm = null ;
			public function ObtientUrl()
			{
				return "javascript:BoiteDlgUrl.ouvre(".svc_json_encode($this->TitreDlg).", ".svc_json_encode($this->UrlDlg).", ".svc_json_encode($this->LargeurDlg).", ".svc_json_encode($this->HauteurDlg).", ".svc_json_encode($this->RafraichPageSurFerm).");" ;
			}
		}
		
		class PvSidebarSbAdmin2 extends PvBarreMenuWebBase
		{
			public $InclureBarreRecherche = 1 ;
			public $LibelleRecherche = "Recherche" ;
			public $NomScriptRecherche = "" ;
			public $NomParamTermeRech = "" ;
			public $InclureMenuAccueil = 1 ;
			public $LibelleMenuAccueil = "Accueil" ;
			public $SousMenuAccueil ;
			public $InclureMenuMembership = 1 ;
			public $LibelleMenuMembership = "Authentification" ;
			public $SousMenuMembership ;
			public $SousMenuListeMembres ;
			public $SousMenuAjoutMembre ;
			public $SousMenuListeProfils ;
			public $SousMenuAjoutProfil ;
			public $SousMenuListeRoles ;
			public $SousMenuAjoutRole ;
			public $LibelleMenuListeMembres = "Membres" ;
			public $LibelleMenuAjoutMembre = "Ajout membre" ;
			public $LibelleMenuListeProfils = "Profils" ;
			public $LibelleMenuAjoutProfil = "Ajout profil" ;
			public $LibelleMenuListeRoles = "R&ocirc;les"  ;
			public $LibelleMenuAjoutRole = "Ajout r&ocirc;le" ;
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->ChargeSousMenusSpec() ;
			}
			protected function ChargeSousMenusSpec()
			{
				if($this->InclureMenuAccueil == 1)
				{
					$this->SousMenuAccueil = $this->MenuRacine->InscritSousMenuUrl($this->LibelleMenuAccueil, "?") ;
					$this->DefClasseFa($this->SousMenuAccueil, "fa-dashboard") ;
				}
				if($this->InclureMenuMembership == 1 && $this->ZoneParent->PossedePrivileges($this->ZoneParent->PrivilegesEditMembership))
				{
					$this->SousMenuMembership = $this->MenuRacine->InscritSousMenuFige("membership", $this->LibelleMenuMembership) ;
					$this->DefClasseFa($this->SousMenuMembership, "fa-lock") ;
					$this->SousMenuListeMembres = $this->SousMenuMembership->InscritSousMenuScript($this->ZoneParent->NomScriptListeMembres) ;
					$this->SousMenuListeMembres->Titre = $this->LibelleMenuListeMembres ;
					$this->SousMenuAjoutMembre = $this->SousMenuMembership->InscritSousMenuScript($this->ZoneParent->NomScriptAjoutMembre) ;
					$this->SousMenuAjoutMembre->Titre = $this->LibelleMenuAjoutMembre ;
					$this->SousMenuListeProfils = $this->SousMenuMembership->InscritSousMenuScript($this->ZoneParent->NomScriptListeProfils) ;
					$this->SousMenuListeProfils->Titre = $this->LibelleMenuListeProfils ;
					$this->SousMenuAjoutProfil = $this->SousMenuMembership->InscritSousMenuScript($this->ZoneParent->NomScriptAjoutProfil) ;
					$this->SousMenuAjoutProfil->Titre = $this->LibelleMenuAjoutProfil ;
					$this->SousMenuListeRoles = $this->SousMenuMembership->InscritSousMenuScript($this->ZoneParent->NomScriptListeRoles) ;
					$this->SousMenuListeRoles->Titre = $this->LibelleMenuListeRoles ;
					$this->SousMenuAjoutRole = $this->SousMenuMembership->InscritSousMenuScript($this->ZoneParent->NomScriptAjoutRole) ;
					$this->SousMenuAjoutRole->Titre = $this->LibelleMenuAjoutRole ;
				}
			}
			protected function RenduMenuRacine(& $menu)
			{
				$ctn = '' ;
				$ctn .= '<div class="navbar-default sidebar" role="navigation">
<div class="sidebar-nav navbar-collapse">
<ul class="nav" id="side-menu">'.PHP_EOL ;
				if($this->InclureBarreRecherche == 1 && $this->NomScriptRecherche != "")
				{
					$ctn .= '<li class="sidebar-search">
<form action="?" method="get">
<input type="hidden" name="'.htmlspecialchars($this->ZoneParent->NomParamScriptAppele).'" value="'.htmlspecialchars($this->NomScriptRecherche).'" />
<div class="input-group custom-search-form">
<input type="text" class="form-control" placeholder="'.htmlspecialchars($this->LibelleRecherche).'" name="'.htmlspecialchars($this->NomParamTermeRech).'" />
<span class="input-group-btn">
<button class="btn btn-default" type="submit">
<i class="fa fa-search"></i>
</button>
</span>
</div>
</li>'.PHP_EOL ;
				}
				$sousMenus = $menu->SousMenusAffichables() ;
				foreach($sousMenus as $i => $sousMenu)
				{
					$ctn .= '<li>'.PHP_EOL ;
					$ctn .= $this->RenduMenuNv1($sousMenu).PHP_EOL ;
					$ctn .= '</li>'.PHP_EOL ;
				}
				$ctn .= '</ul>
</div>
</div>' ;
				return $ctn ;
			}
			protected function RenduMenuNv1(& $menu)
			{
				$ctn = '' ;
				$classeFa = $menu->ObtientValCfgSpec("classe_fa", "fa-bars") ;
				$ctn .= '<a href="'.htmlspecialchars($menu->ObtientUrl()).'"'.(($menu->FenetreCible != '') ? ' target="'.htmlspecialchars($menu->FenetreCible).'"' : '').'><i class="fa '.$classeFa.' fa-fw"></i> '.$menu->ObtientTitre() ;
				$sousMenus = $menu->SousMenusAffichables() ;
				if(count($sousMenus) > 0)
				{
					$ctn .= '<span class="fa arrow"></span>' ;
				}
				$ctn .= '</a>' ;
				if(count($sousMenus) > 0)
				{
					$ctn .= PHP_EOL .''.PHP_EOL .'<ul class="nav nav-second-level">'.PHP_EOL ;
					foreach($sousMenus as $i => $sousMenu)
					{
						$ctn .= '<li>'.PHP_EOL .$this->RenduMenuNv2($sousMenu).PHP_EOL .'</li>'.PHP_EOL ;
					}
					$ctn .= '</ul>' ;
				}
				return $ctn ;
			}
			protected function RenduMenuNv2(& $menu)
			{
				return '<a href="'.htmlspecialchars($menu->ObtientUrl()).'"'.(($menu->FenetreCible != '') ? ' target="'.htmlspecialchars($menu->FenetreCible).'"' : '').'>'.$menu->ObtientTitre().'</a>' ;
			}
			public function DefinitClasseFa(& $menu, $classeFa)
			{
				$menu->DefinitValConfigSpec("classe_fa", $classeFa) ;
			}
			public function DefClasseFa(& $menu, $classeFa)
			{
				return $this->DefinitClasseFa($menu, $classeFa) ;
			}
		}
	}
	
?>