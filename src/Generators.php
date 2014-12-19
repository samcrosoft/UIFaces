<?php
namespace Samcrosoft\UIFaces;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use Samcrosoft\UIFaces\Transformers\UIFace;


/**
* 
*/
class Generators
{

	const RANDOM_USER_REQUEST = "_random";

	const SPECIFIC_USER_REQUEST = "_user";


	/**
	 *
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
	 * 
	 */
	private function createFacesRequest($sRequest, $sExtra){
		$sRandomUserLink =  "http://uifaces.com/api/v1/random";

		switch ($sRequest) {
			case self::RANDOM_USER_REQUEST:
				$sRandomUserLink =  "http://uifaces.com/api/v1/random";
				break;
			case self::SPECIFIC_USER_REQUEST:
			default:
				$sRandomUserLink =  "http://uifaces.com/api/v1/user/".$sExtra;
				break;
		}

		return $this->getClientObject()->createRequest('GET', $sRandomUserLink);
	}


	/**
	 * This will make the request to the uifaces api server
	 */
	protected function makeRequestToUiFaces($sRequest = self::RANDOM_USER_REQUEST, $sExtra = null){
		$oGuzzleClient = $this->getClientObject();
	
		if(is_null($oGuzzleClient) || !( $oGuzzleClient instanceof Client))
			throw new \Exception("HTTP Client Not Initiated");

		$aReturn = [];
		try{
			$oResponse = $this->getClientObject()->send($this->createFacesRequest($sRequest, $sExtra));	
			$aReturn = $oResponse->json();
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
	 */
	public function getUser($sUsername){
		$oObject = $this->makeRequestToUiFaces(self::SPECIFIC_USER_REQUEST, $sUsername);
		return $this->transformResponseToTransformer($oObject);
	}

	/**
	 * @param int $iCount
	 * @return array
	 */
	public function getBatchUsers($iCount = 10){
		$aRequests = [];

		for($i=0;$i<$iCount;$i++){
			$aRequests[] = $this->createFacesRequest();
		}

		// send the batch
		$oResults = Pool::batch($this->getClientObject(), $aRequests);

		// get all the successful ones
		$aResults = [];
		foreach ($oResults->getSuccessful() as $response) {
			$aResults[] = $this->transformResponseToTransformer($response->json());
		}

		return $aResults;
	}


}