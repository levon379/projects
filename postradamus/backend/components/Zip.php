<?php

namespace backend\components;

use Yii;

class Zip {
	public static function assureDir( $dir ){
		if( !file_exists($dir) ){
			$dirAry = explode("/",$dir);
			$ndir = '' ;
			foreach($dirAry as $tempDir ){
				if( !empty($tempDir) ){
					$ndir .= $tempDir ;
					if(!file_exists($ndir)){
						if(mkdir($ndir)==false){
							return false;
						}
					}
					$ndir .= '/' ;	
				}
			}
		}
		if( $ndir==$dir && file_exists($dir) ){
			return true;	
		}
		return false;
	}
	
	public static function makeZipFileFromPaths($filePaths,$zipFileName){
		// CREATE AND OPEN ZIP ARCHIVE
		$zip = new \ZipArchive();
		if($zip->open($zipFileName,\ZipArchive::CREATE)!==TRUE){
			return false;
        }
		foreach($filePaths as $elm){
			$filePath = null ;
			$localName = null ; 
			if( is_array($elm) ){
				if( array_key_exists('filePath',$elm) ){
					$filePath = $elm['filePath'] ;
				}
				else{
					continue;
				}
				if( array_key_exists('localName',$elm) ){
					$localName = $elm['localName'] ;
				}
			}
			else{
				$filePath = $elm ; 
			}
			if(file_exists($filePath) && is_file($filePath) ){
				if( is_null($localName) || empty($localName) ){
					$localName =  basename($filePath); 
				}
				$zip->addFile($filePath , $localName );	
			}
		}
		$zip->close();
		return file_exists($zipFileName);	
	}
}