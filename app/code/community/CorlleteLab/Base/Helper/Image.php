<?php
class CorlleteLab_Base_Helper_Image extends Mage_Core_Helper_Abstract
{
	public function __construct() {
		require_once 'PhpThumb/ThumbLib.inc.php';
	}
	
    public function resize($path,$width,$height)
    {
    	$filename = basename($path);
        if (is_readable($path)) {
        	try
			{
				$thumb = PhpThumbFactory::create($path)
		        		->resize($width, $height)
						->save($this->getImagePath().$filename)
				;
				
				$filepath = $this->getImagePath(true).$filename;
			}
			catch (Exception $e)
			{
			     $filepath = '';
			}
        }
       
		return $filepath;
    }
	
	protected function getImagePath($http = false) {
		if (!is_dir(Mage::getBaseDir('media').DS.'clbase'.DS.'cache'.DS)) {
			mkdir(Mage::getBaseDir('media').DS.'clbase'.DS.'cache'.DS, 0777,true);
		}
		
		return $http ?
			Mage::getBaseUrl('media').'clbase/cache/' :
			Mage::getBaseDir('media').DS.'clbase'.DS.'cache'.DS
		;
	}
}