<?php
/**
 * Bynder UCV plugin for Craft CMS 5.x
 *
 * @link      https://www.loqus.nl
 * @copyright Copyright (c) 2024 Loqus
 */

namespace loqus\byndercraftcms\variables;

use Craft;
use loqus\byndercraftcms\models\BynderAssetModel;
use loqus\byndercraftcms\BynderAssets;
use craft\elements\Asset;
use craft\helpers\App;

class BynderAssetVariable
{
    public function getRemoteImageUrl($assetId): BynderAssetModel
    {
        return BynderAssets::$plugin->getService()->getRemoteImageUrl($assetId);
    }
    public function getAssets(): AssetQuery
    {
        return BynderAssets::$plugin->getService()->getAssets();
    }
    public function checkExternalFile($url): int
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $retCode;
    }
    public function seoName($string): string
	{
		$string = strtolower($string);
		$string = trim($string);
		$string = str_replace(" & "," ",$string);
		$string = str_replace(" and "," ",$string);
		
		
		$string = str_replace(array("&#200;","&#201;","&#202;","&#203;","ð","&#240;","&eth;","è","&#232;","&egrave;","é","&#233;","&eacute;","ê","&#234;","&ecirc;","ë","&#235;","&#281;"),"e",$string);
		$string = str_replace(array("&aelig;","æ","&#198;"),"ae",$string);
		$string = str_replace(array("ò","&#242;","&ograve;","ó","&#243;","&oacute;","ô","&#244;","&ocirc;","õ","&#245;","&otilde;","ö","&#246;","&ouml;","ø","&#248;","&#335;","&#210;","&#211;","&#212;","&#213;","&#214;","&#216;"),"o",$string);
		$string = str_replace(array("&#192;","&#193;","&#194;","&#195;","&#196;","&#197;","&atilde;","&aring;","&acirc;","&aacute;","&auml;","&agrave;","&aacute;","&#261;","à","&#224;","á","&#225;","â","&#226;","ã","&#227;","ä","&#228;","å","&#229;"),"a",$string);
		$string = str_replace(array("&#204;","&#205;","&#206;","&#207;","&iacute;","&iexcl;","&igrave;","&icirc;","&iota;","&iuml;","&icirc;","ì","&#236;","í","&#237;","î","&#238;","ï","&#239;"),"i",$string);
		$string = str_replace(array("&uacute;","&uuml;","&ucirc;","&ugrave;","&#217;","&#218;","&#219;","&#220;","ù","&#249;","ú","&#250;","û","&#251;","ü","&#252;"),"u",$string);
		
		$string = str_replace(array("&ccedil;","&#263;","ç","&#269;","&#231;","&#199;"),"c",$string);
		$string = str_replace(array("&beta;","&#223;","&szlig;","ß"),"ss",$string);
		$string = str_replace(array("&scaron;","&#351;","&#346;","&#347;"),"s",$string);
		$string = str_replace(array("&yuml;","&#255;","&#221;","ÿ"),"y",$string);

		$string = str_replace("&rsquo;","",$string);
		$string = str_replace("%7C","",$string);
		$string = str_replace("|","",$string);
		$string = str_replace(",","-",$string);
		$string = str_replace("&#287;","g",$string);
		$string = str_replace("&#321;","l",$string);
		$string = str_replace(array("©","&#169;","&copy;"),"copyright",$string);
		$string = str_replace(array("®","&#174;","&reg;"),"registered",$string);
		$string = str_replace(array("°","&#176;","&deg;"),"degree",$string);
		$string = str_replace(array("&#324;","&#241;","ñ","&#209;"),"n",$string);
		$string = str_replace(array("&#222;","þ","&#254;"),"t",$string);
		$string = str_replace("&#380;","z",$string);
		$string = str_replace("&#378;","z",$string);
		$string = str_replace("%","procent",$string);
		$string = str_replace("+","plus",$string);
		
		$string = str_replace("&#322;","l",$string);
		$string = str_replace("&trade;","-tm-",$string);
		$string = str_replace('"',"",$string);
		$string = str_replace("'","",$string);
		$string = str_replace("/","-",$string);
		$string = str_replace("\\","",$string);
		$string = str_replace("---","-",$string);
		$string = str_replace("--","-",$string);
		
		$temp = preg_replace("/[^a-z0-9]/", "-", $string);

		if(stripos(" ".$temp,"---") || $temp == "")
		{
			$string = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '?', $string);
			$string = preg_replace('/\s+/', '-', $string);
			$string = str_replace('&amp;', '', $string);
			if (!preg_match('/[\x80-\xff]/', $string)) {
				return $string;
			}
		}else{
			$string = $temp;
		}
		
		$sOutput = $string;
		
		while (strpos($sOutput, "--") !== false)
		{
			$sOutput = str_replace("--", "-", $sOutput);
		}
		if (substr($sOutput, -1, 1) == "-")
		{
			$sOutput = substr($sOutput, 0, -1);
		}
		return $sOutput;
	}
    public function transformImage(Asset|BynderAsset $image, array $transforms): \stdClass
    {
        $addstring='';
        $height=null;
        $width=null;
        $settings = BynderAssets::$plugin->getSettings();
        $alt = $image->datLocation;
        $altparts = explode("/",$alt);
        $oldfilename = $altparts[5];
        $extension = ".".strtolower($image->getExtension());
        $newfilename = $this->seoName($image->title).$extension;
        $transformparameters = array();
        $transformObj = new \stdClass();
        $i=1;
        if(isset($transforms['mode']))
        {
            if(isset($transforms['ratio']) || $transforms['mode']== 'fill'){
                $transformparameters[]='?io=transform:fill';
            }
            else
            {
            if($transforms['mode']== 'crop')
            {
                $transformparameters[]='?io=transform:fit';
            }elseif($transforms['mode']== 'fit')
            {
                $transformparameters[]='?io=transform:fit';
            }elseif($transforms['mode']== 'fill')
            {
                $transformparameters[]='?io=transform:fill';
            }
         }
        }
        elseif(isset($transforms['mode']) && $transforms['transform'] == 'fit')
        {
            $transformparameters[]='?io=transform:fit';
        }
        elseif(isset($transforms['mode']) && $transforms['transform'] == 'background' && isset($transforms['color']))
        {
            $transformparameters[]='?io=transform:'.$transforms['transform'].',color:'.$transforms['color'];
        }
        if(isset($transforms['ratio'])){
            if(isset($transforms['height']))
            {
                $transformparameters[]='height:'.$transforms['height'];
                $transformparameters[]='width:'.round($transforms['height']*$transforms['ratio']);
            }elseif(isset($transforms['width'])){
                $transformparameters[]='height:'.round($transforms['width']/$transforms['ratio']);
                $transformparameters[]='width:'.$transforms['width'];
            }
        }else{
            if(isset($transforms['height']) && isset($transforms['width']))
            {
                $transformparameters[]='height:'.$transforms['height'];
                $transformparameters[]='width:'.$transforms['width'];
            }elseif(isset($transforms['width'])){
                $transformparameters[]='width:'.$transforms['width'];
                $transformparameters[]='height:0';
            }elseif(isset($transforms['height'])){
                $transformparameters[]='height:'.$transforms['height'];
                $transformparameters[]='width:0';
            }
        }
        
        $addstring = implode(',',$transformparameters);
        if(isset($transforms['quality']))
        {
            $addstring.='&quality='.$transforms['quality'];
        }else{
            $addstring.='&quality=95';
        }
        $bynderTransform = $image->datLocation.$addstring;

        if(isset($transforms['height']) && isset($transforms['width']))
        {
            $transformObj->width = $transforms['width'];
            $transformObj->height = $transforms['height'];
        }else{
            if($this->checkExternalFile($bynderTransform) == 200)
            {
                $size = getimagesize($bynderTransform);
                $transformObj->width = $size[0];
                $transformObj->height = $size[1];
            }else{
                $transformObj->width = 0;
                $transformObj->height = 0;
            }
        }
        $bynderTransform=str_ireplace($oldfilename,$newfilename,$bynderTransform);
        $transformObj->url = $bynderTransform;
        return $transformObj;
    }
}
