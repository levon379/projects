<?php namespace Utils;

class Util {

	/*  A list of variables to the be used throughout the site.  */
/*
    public static function SiteVars()
    {
		return array( 
			'gsite_locale_id' => 1,
			'gsite_language_id' => 1,
		);
	}

    public static function setLocale()
    {
		$gsite_locale_id=1;
    	return $gsite_locale_id;
	}
*/

	public static function Show($aVar)
	{
		echo "[[".$aVar."]]<BR>";
	}

	public static function ShowArr($aVar)
	{
		echo "------------<BR>";
		foreach ($aVar as $key => $value) {
			echo "Key: $key; Value: $value<br>\n";
		}
		echo "------------<BR>";
	}

	public static function ShowPre($aVar)
	{
		echo "------------<BR>";
		echo "<pre>";
		print_r ($aVar);
		echo "</pre>";
		echo "------------<BR>";
	}

	public static function objectToArray($object) 
	{
		if(!is_object($object) && !is_array($object))
			return $object;

		return array_map('Util::objectToArray', (array) $object);
	}

	public static function makeDate($format, $indate)
	{
		$temp = explode("-", substr($indate,0,10));
		$temp2 = explode(":", substr($indate,11,19));
		$tempsum=array_sum($temp)+array_sum($temp2);
		if ($tempsum>0)
		{
			$fulldate = mktime($temp2[0], $temp2[1], $temp2[2], $temp[1], $temp[2], $temp[0]);
			$temp = date($format, $fulldate);
		}
		else
		{	$temp = "";		}
		return ($temp);
	}


	public static function postGenInsertDate($indate)
	{
		if ($indate<>"")
		{
			$newtimestamp=strtotime($indate);
			if ($newtimestamp>0)
			{	$temp = date('Y-m-d H:i:s', $newtimestamp);		}
			else
			{	$temp = "";		}
		}
		else
		{	$temp='NULL';
		}
		return ($temp);
	}

	public static function makeMoney($value, $symbol = '$', $decimals = 2)
	{
		return ($value < 0 ? '-' : '') . number_format(abs($value), $decimals);
	}
}
?>
