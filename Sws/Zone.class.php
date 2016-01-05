<?php
	
	if(! defined('ZONE_SWS'))
	{
		if(! defined('PV_NOYAU'))
		{
			include dirname(__FILE__)."/../Pv/IHM/Simple.class.php" ;
		}
		define('ZONE_SWS', 1) ;
		
		class ZoneBaseSws extends PvZoneWebSimple
		{
			public function NiveauAdmin()
			{
				return "public" ;
			}
		}
		class ZoneAdminSws extends ZoneBaseSws
		{
			public $BarreLiensMembre ;
			public $InclureScriptsMembership = 1 ;
			public $CheminLogo = "../images/logo.png" ;
			public $MsgCopyright = "SWS (C) Tous droits r&eacute;serv&eacute;s" ;
			public $InclureJQuery = 1 ;
			public $InclureJQueryUi = 1 ;
			public $IncRenduBarreLiensMembre = 1 ;
			public $IncRenduLogo = 1 ;
			public function NiveauAdmin()
			{
				return "admin" ;
			}
			protected function ObtientDefCSS()
			{
				$ctn = '' ;
				$ctn .= 'body, p, div, form, table, tr, td, th {
	font-family:tahoma ;
	font-size:12px ;
}
.titre {
	font-size:16px;
	margin-top:12px;
	margin-bottom:12px;
	font-weight:bold;
}
.menu-haut {
	background:black ;
	padding:4px;
}
.menu-haut * {
	color:white ;
}
.sws-ui-padding-2 {
	padding:2px ;
}
.sws-ui-padding-4 {
	padding:4px ;
}
.sws-ui-padding-8 {
	padding:8px ;
}
.sws-ui-padding-12 {
	padding:12px ;
}' ;
				return $ctn ;
			}
			protected function ChargeBarreLiensMembre()
			{
				$this->BarreLiensMembre = new PvBarreLiensEditMembre() ;
				$this->BarreLiensMembre->AdopteZone('barreLiensMembre', $this) ;
				$this->BarreLiensMembre->ChargeConfig() ;
				$this->BarreLiensMembre->InclureLienAccueil = 1 ;
			}
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				$this->InscritContenuCSS($this->ObtientDefCSS()) ;
				$this->ChargeBarreLiensMembre() ;
				ReferentielSws::$SystemeEnCours->RemplitZoneAdmin($this) ;
			}
			protected function RenduEnteteCorpsDocument()
			{
				$ctn = '' ;
				$ctn .= '<body>'.PHP_EOL ;
				$ctn .= '<table align="center" width="100%" cellspacing="0" cellpadding="2">' ;
				if($this->IncRenduBarreLiensMembre)
				{
					$ctn .= '<tr>
<td class="menu-haut">'.$this->BarreLiensMembre->RenduDispositif().'</td>
</tr>' ;
				}
				if($this->IncRenduLogo)
				{
					$ctn .= '<tr>
<td><img src="'.$this->CheminLogo.'" /></td>
</tr>'.PHP_EOL ;
				}
				$ctn .= '<tr>
<td>'.PHP_EOL ;
				return $ctn ;
			}
			protected function RenduPiedCorpsDocument()
			{
				$ctn = '' ;
				$ctn .= '</td>
</tr>
<tr>
<td class="copyrights" align="center"><p class="ui-widget ui-widget-content">'.$this->MsgCopyright.'</p></td>
</tr>
</table>' ;
				$ctn .= '</body>' ;
				return $ctn ;
			}
		}
		class ZoneMembreSws extends ZoneBaseSws
		{
			public $InclureScriptsMembership = 1 ;
			public $AutoriserInscription = 1 ;
			public $AutoriserModifPrefs = 1 ;
			public $InclureJQuery = 1 ;
			public $InclureJQueryUi = 1 ;
			public function NiveauAdmin()
			{
				return "membre" ;
			}
			public function ChargeConfig()
			{
				parent::ChargeConfig() ;
				ReferentielSws::$SystemeEnCours->RemplitZoneMembre($this) ;
			}
		}
		
	}
	
?>