<?php
/**
 * Created by PhpStorm.
 * User: Adebola
 * Date: 11/25/2015
 * Time: 9:50 AM
 */

namespace UIFaces\Tests;


use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;
use Samcrosoft\UIFaces\Generators;
use Samcrosoft\UIFaces\Transformers\UIFace;

/**
 * Class GeneratorsTest
 * @package UIFaces\Tests
 */
class GeneratorsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var null|Generators
     */
    private $oGenerator = null;

    /**
     *
     */
    public function setUp()
    {
        $this->oGenerator = new Generators();
    }

    /**
     * This will assert that the generator been used in test is an instance of the samcrosoft UIFaces Generator
     */
    public function testUIFaceGeneratorIsSetupCorrectly()
    {
        $this->assertInstanceOf(Generators::class, $this->oGenerator);
    }


    /**
     * This will affirm that the client object used by the generator is an instance of Guzzle Client
     * @depends testUIFaceGeneratorIsSetupCorrectly
     */
    public function testGeneratorClientIsInstanceOfGuzzleHTTPClient()
    {
        $this->assertInstanceOf(Client::class, $this->oGenerator->getClientObject());
    }


    /**
     * This will test the random user returned
     */
    public function testClientRequestRandomUser()
    {
        $oRandomUser = $this->oGenerator->getRandomUser();
        $this->assertInstanceOf(UIFace::class, $oRandomUser);
        $this->assertArrayHasKey(UIFace::ATTRIBUTE_USERNAME, $oRandomUser->getResponseObject());
        $this->assertArrayHasKey(UIFace::ATTRIBUTE_BIGGER_IMAGE, $oRandomUser->getAllImages());
        $this->assertArrayHasKey(UIFace::ATTRIBUTE_EPIC_IMAGE, $oRandomUser->getAllImages());
        $this->assertArrayHasKey(UIFace::ATTRIBUTE_MINI_IMAGE, $oRandomUser->getAllImages());
        $this->assertArrayHasKey(UIFace::ATTRIBUTE_NORMAL_IMAGE, $oRandomUser->getAllImages());

        // assert that the user object has a username
        $this->assertNotEmpty($oRandomUser->getUsername());
    }


    /**
     * @dataProvider getSpecificTestUsers
     * @param $sUsername
     */
    public function testSpecificUser($sUsername)
    {
        $oSpecificUser = $this->oGenerator->getUser($sUsername);

        $this->assertInstanceOf(UIFace::class, $oSpecificUser);
        $this->assertEquals($sUsername, $oSpecificUser->getUsername());
    }


    public function testBatchUsersRequest()
    {
        $aReturnedUsers = $this->oGenerator->getBatchUsers(5);

        $this->assertNotEmpty($aReturnedUsers);
        $this->assertTrue(is_array($aReturnedUsers));


        // test that the returned array only has elements of type UIFaces::class
        $aNotUIFaces = array_filter($aReturnedUsers, function($oElement){
            return get_class($oElement) !== UIFace::class;
        });
        $this->assertEmpty($aNotUIFaces);


    }


    /**
     * @return array
     */
    public function getSpecificTestUsers()
    {
        return [
            ['calebogden'],
            ['jsa'],
            ['marcosmoralez'],
        ];
    }

}