<?php
namespace Samcrosoft\UIFaces;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Samcrosoft\UIFaces\Transformers\UIFace;


/**
 * Class Generators
 * @package Samcrosoft\UIFaces
 */
class Generators
{
    const DEFAULT_TIMEOUT_SECONDS = 2;

    /**
     * @const
     */
    const API_ENDPOINT = "http://uifaces.com/api/v1/";

    /**
     * @const
     */
    const RANDOM_USER_REQUEST = "_random";

    /**
     * @const
     */
    const SPECIFIC_USER_REQUEST = "_user";


    /**
     * Client
     */
    private $oGuzzleClient = null;

    /**
     * Generators constructor.
     */
    function __construct()
    {
        $this->initiateClient();
    }

    protected function initiateClient()
    {
        $this->oGuzzleClient = new client();
    }

    /**
     * @return Client
     */
    public function getClientObject()
    {
        return $this->oGuzzleClient;
    }

    /**
     * @param string $sRequest
     * @param null $sExtra
     * @return Request
     */
    private function createFacesRequest($sRequest = self::RANDOM_USER_REQUEST, $sExtra = null)
    {
        $sRandomUserLink = $this->getRequestURL($sRequest, $sExtra);
        $oRequest = new Request('GET', $sRandomUserLink, ['timeout' => self::DEFAULT_TIMEOUT_SECONDS]);
        return $oRequest;
    }


    /**
     * This will make the request to the ui-faces api server
     * @param string $sRequest
     * @param null $sExtra
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Exception
     */
    protected function makeRequestToUiFaces($sRequest = self::RANDOM_USER_REQUEST, $sExtra = null)
    {
        $oGuzzleClient = $this->getClientObject();

        if (is_null($oGuzzleClient) || !($oGuzzleClient instanceof Client))
            throw new \Exception("HTTP Client Not Initiated");

        try {
            $oRequest = $this->createFacesRequest($sRequest, $sExtra);
            $oResponse = $this->getClientObject()->send($oRequest);
            $aReturn = $this->getBodyFromResponse($oResponse);
        } catch (RequestException $e) {
            $aReturn = [];
        }

        return $aReturn;
    }

    /**
     * @param array $oObject
     * @return UIFace;
     */
    private function transformResponseToTransformer($oObject)
    {
        $oObject = is_array($oObject) ? $oObject : (array)$oObject;

        return new UIFace($oObject);
    }


    /**
     * This will get a random user
     */
    public function getRandomUser()
    {
        $oObject = $this->makeRequestToUiFaces();
        return $this->transformResponseToTransformer($oObject);
    }

    /**
     * @param string $sUsername
     * @return UIFace
     */
    public function getUser($sUsername)
    {
        $oObject = $this->makeRequestToUiFaces(self::SPECIFIC_USER_REQUEST, $sUsername);
        return $this->transformResponseToTransformer($oObject);
    }


    /**
     * @param int $iCount
     * @return array
     */
    private function getBulkRequests($iCount = 0)
    {

        $aPromises = [];
        for ($i = 0; $i < $iCount; $i++) {
            $aPromises[] = $this->getClientObject()->sendAsync($this->createFacesRequest());
        }
        return $aPromises;
    }

    /**
     * This will return the body of the response as json decoded
     * @param Response|null $response
     * @return array|mixed
     */
    function getBodyFromResponse(Response $response = null)
    {
        return empty($response) ? [] : json_decode($response->getBody());
    }

    /**
     * @param int $iCount
     * @return array
     */
    public function getBatchUsers($iCount = 10)
    {
        $aResults = [];
        $aPromises = $this->getBulkRequests($iCount);
        // Wait on all of the requests to complete.
        $aPromiseResults = Promise\unwrap($aPromises);
        foreach ($aPromiseResults as $oResponse) {
            // this is delivered each successful response
            /** @var ResponseInterface $oResponse */
            /** @var array $sBody */
            $sBody = $this->getBodyFromResponse($oResponse);
            $aResults[] = $this->transformResponseToTransformer($sBody);
        }

        return $aResults;
    }

    /**
     * @param $sExtra
     * @param $sRequest
     * @return string
     */
    private function getRequestURL($sRequest = self::RANDOM_USER_REQUEST, $sExtra = null)
    {
        switch ($sRequest) {
            case self::RANDOM_USER_REQUEST:
                $sRandomUserLink = self::API_ENDPOINT . "random";
                break;
            case self::SPECIFIC_USER_REQUEST:
            default:
                $sRandomUserLink = self::API_ENDPOINT . "user/" . $sExtra;
                break;
        }
        return $sRandomUserLink;
    }


}