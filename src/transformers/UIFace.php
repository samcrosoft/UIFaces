<?php
namespace Samcrosoft\UIFaces\Transformers;

/**
 *
 */
class UIFace
{

    const ATTRIBUTE_USERNAME = "username";
    const ATTRIBUTE_IMAGES_URL = "image_urls";

    const ATTRIBUTE_EPIC_IMAGE = "epic";
    const ATTRIBUTE_MINI_IMAGE = "mini";
    const ATTRIBUTE_BIGGER_IMAGE = "bigger";
    const ATTRIBUTE_NORMAL_IMAGE = "normal";

    /**
     * @var array
     */
    private $aRepsonse = [];

    /**
     * @param $aResponse
     */
    function __construct($aResponse)
    {
        $this->setResponseObject($aResponse);
    }

    /**
     * This would set the response object
     * @param array $aResponse
     */
    private function setResponseObject($aResponse)
    {
        $this->aRepsonse = (array)$aResponse;
    }

    /**
     * This would return the response
     * @return array
     */
    public function getResponseObject()
    {
        return $this->aRepsonse;
    }

    /**
     * Test if the user attribute value exists
     */
    private function isAttributeAvailable($sKey)
    {
        $bReturn = empty($sKey);
        if ($bReturn) {
            $aResponse = $this->getResponseObject();
            $bReturn = isset($aResponse[$sKey]);
        }

        return $bReturn;
    }

    /**
     * @param string $sKey
     * @param string|null $sDefault
     * @return string
     */
    private function getResponseAttribute($sKey, $sDefault = null)
    {
        $aResponse = $this->getResponseObject();
        $sReturn = isset($aResponse[$sKey]) ? $aResponse[$sKey] : $sDefault;
        return $sReturn;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->getResponseAttribute(self::ATTRIBUTE_USERNAME);
    }

    /**
     * @return array
     */
    public function getAllImages()
    {
        return (array) $this->getResponseAttribute(self::ATTRIBUTE_IMAGES_URL);
    }


    /**
     * @param string $sKey
     * @param string|null $sDefault
     * @return string
     */
    private function getSubImage($sKey, $sDefault = null)
    {
        $aImages = $this->getAllImages();
        if (is_null($aImages))
            return $sDefault;
        else {
            return isset($aImages[$sKey]) ? $aImages[$sKey] : $sDefault;
        }
    }

    /**
     * @return string
     */
    public function getEpicImage()
    {
        return $this->getSubImage(self::ATTRIBUTE_EPIC_IMAGE);
    }

    /**
     * @return string
     */
    public function getNormalImage()
    {
        return $this->getSubImage(self::ATTRIBUTE_NORMAL_IMAGE);
    }

    /**
     * @return string
     */
    public function getBiggerImage()
    {
        return $this->getSubImage(self::ATTRIBUTE_BIGGER_IMAGE);
    }

    /**
     * @return string
     */
    public function getMiniImage()
    {
        return $this->getSubImage(self::ATTRIBUTE_MINI_IMAGE);
    }

}