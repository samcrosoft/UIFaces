<?php
namespace Samcrosoft\UIFaces;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Samcrosoft\UIFaces\Transformers\UIFace;


/**
* 
*/
class Generators
{

	const RANDOM_USER_REQUEST = "_random";

	const SPECIFIC_USER_REQUEST = "_user";


	/**
	 * Client
	 */
	private $oGuzzleClient = null;

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
	 * @param $sExtra
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 */
	private function createFacesRequest($sRequest = self::RANDOM_USER_REQUEST, $sExtra=null){
		switch ($sRequest) {
			case self::RANDOM_USER_REQUEST:
				$sRandomUserLink =  "http://uifaces.com/api/v1/random";
				break;
			case self::SPECIFIC_USER_REQUEST:
			default:
				$sRandomUserLink =  "http://uifaces.com/api/v1/user/".$sExtra;
				break;
		}

		return $this->getClientObject()->get($sRandomUserLink);
	}


	/**
	 * This will make the request to the uifaces api server
	 * @param string $sRequest
	 * @param null $sExtra
	 * @return array|\Psr\Http\Message\StreamInterface
	 * @throws \Exception
	 */
	protected function makeRequestToUiFaces($sRequest = self::RANDOM_USER_REQUEST, $sExtra = null){
		$oGuzzleClient = $this->getClientObject();
	
		if(is_null($oGuzzleClient) || !( $oGuzzleClient instanceof Client))
			throw new \Exception("HTTP Client Not Initiated");

		try{
			$oResponse = $this->getClientObject()->send($this->createFacesRequest($sRequest, $sExtra));
			$aReturn = json_decode($oResponse->getBody());
		}catch (RequestException $e){
			$aReturn =[];
		}
		
		return  $aReturn;
	}

	/**
	 * @param array $oObject
	 * @return UIFace;
	 */
	private function transformResponseToTransformer($oObject){
		$oObject = is_array($oObject) ? $oObject : (array) $oObject;

		return new UIFace($oObject);
	}


	/**
	 * This will get a random user
	 */
	public function getRandomUser(){
		$oObject = $this->makeRequestToUiFaces();
		return $this->transformResponseToTransformer($oObject);
	}

	/**
	 * @param string $sUsername
	 * @return UIFace
	 */
	public function getUser($sUsername){
		$oObject = $this->makeRequestToUiFaces(self::SPECIFIC_USER_REQUEST, $sUsername);
		return $this->transformResponseToTransformer($oObject);
	}

	/**
	 * @param int $iCount
	 * @return array
	 * @deprecated -> resolve this
	 */
	public function getBatchUsers($iCount = 10){
		$aRequests = [];

		for($i=0;$i<$iCount;$i++){
			$aRequests[] = $this->createFacesRequest();
		}

		// send the batch
		//$oResults = Pool::batch($this->getClientObject(), $aRequests);

		$oResults = Promise\unwrap($aRequests);
		// get all the successful ones
		$aResults = [];
		foreach ($oResults as $response) {
			/** @var ResponseInterface $response */
			/** @var array $sBody */
			$sBody = json_decode($response->getBody());
			$aResults[] = $this->transformResponseToTransformer($sBody);
		}

		return $aResults;
	}


}