<?php

namespace Pv\ZoneWeb\Document ;

class DocumentWeb
{
	protected function RenduDefsJS(& $zone)
	{
		$ctn = '' ;
		for($i=0; $i<count($zone->ContenusJs); $i++)
		{
			$ctnJs = $zone->ContenusJs[$i] ;
			$ctn .= $ctnJs->RenduDispositif().PHP_EOL ;
		}
		return $ctn ;
	}
	protected function RenduDefsCSS(& $zone)
	{
		$ctn = '' ;
		for($i=0; $i<count($zone->ContenusCSS); $i++)
		{
			$ctnCSS = $zone->ContenusCSS[$i] ;
			$ctn .= $ctnCSS->RenduDispositif().PHP_EOL ;
		}
		return $ctn ;
	}
	public function PrepareRendu(& $zone)
	{
	}
	public function RenduEntete(& $zone)
	{
		$ctn = '' ;
		$ctn .= $zone->RenduCtnJsEntete() ;
		return ;
	}
	public function RenduPied(& $zone)
	{
	}
}