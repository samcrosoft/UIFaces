<?php
namespace Samcrosoft\UIFaces\Transformers;

/**
* 
*/
class UIFace 
{

	const ATTRIBUTE_USERNAME 		= "username";
	const ATTRIBUTE_IMAGES_URL  	= "image_urls";

	const ATTRIBUTE_EPIC_IMAGE 		= "epic";
	const ATTRIBUTE_MINI_IMAGE 		= "mini";
	const ATTRIBUTE_BIGGER_IMAGE 	= "bigger";
	const ATTRIBUTE_NORMAL_IMAGE 	= "normal";

	/**
	 * @var array
	 */
	private $aRepsonse = [];

	/**
	 * @param array $aResponse
	 */
	function __construct($aRepsonse)
	{
		$this->setResponseObject($aRepsonse);
	}

	/**
	 * This would set the response object
	 * @param array $aResponse
	 */
	private function setResponseObject($aRepsonse){
		$this->aRepsonse= (array) $aRepsonse;
	}

	/**
	 * This would return the response
	 * @return array
	 */
	private function getResponseObject(){
		return $this->aRepsonse;
	}

	/**
	 * Test if the user atttribute value exists
	 */
	private function isAttributeAvailable($sKey){
		$bReturn = empty($sKey);
		if($bReturn){
			$aRepsonse = $this->getResponseObject();
			$bReturn = isset($aRepsonse[$sKey]);
		}

		return $bReturn;
	}

	/**
	 * @param string $sKey 
	 * @param string|null $sDefault
	 * @return string
	 */
	private function getResponseAttribute($sKey, $sDefault = null){
		$aRepsonse = $this->getResponseObject();
		$sReturn = isset($aRepsonse[$sKey]) ? $aRepsonse[$sKey] : $sDefault;
		return $sReturn;
	}

	/**
	 * @return string
	 */
	public function getUsername(){
		return $this->getResponseAttribute(self::ATTRIBUTE_USERNAME);
	}

	/**
	 * @return string
	 */
	public function getAllImages(){
		return $this->getResponseAttribute(self::ATTRIBUTE_IMAGES_URL);
	}


	/**
	 * @param string $sKey
	 * @param string|null $sDefault
	 * @return string
	 */
	private function getSubImage($sKey, $sDefault = null)
	{
		$aImages = $this->getAllImages();
		if(is_null($aImages))
			return $sDefault;
		else{
			return isset($aImages[$sKey]) ? $aImages[$sKey] : $sDefault;
		}
	}

	/**
	 * @return string
	 */
	public function getEpicImage(){
		return $this->getSubImage(self::ATTRIBUTE_EPIC_IMAGE);
	}

	/**
	 * @return string
	 */
	public function getNormalImage(){
		return $this->getSubImage(self::ATTRIBUTE_NORMAL_IMAGE);
	}

	/**
	 * @return string
	 */
	public function getBiggerImage(){
		return $this->getSubImage(self::ATTRIBUTE_BIGGER_IMAGE);
	}

	/**
	 * @return string
	 */
	public function getMiniImage(){
		return $this->getSubImage(self::ATTRIBUTE_MINI_IMAGE);
	}

}