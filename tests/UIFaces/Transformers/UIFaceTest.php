<?php
namespace UIFaces\Tests\Transformers;
use PHPUnit_Framework_TestCase;
use Samcrosoft\UIFaces\Generators;
use Samcrosoft\UIFaces\Transformers\UIFace;

/**
 * Created by PhpStorm.
 * User: Adebola
 * Date: 11/26/2015
 * Time: 6:44 AM
 */
class UIFaceTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var null|Generators
     */
    private $oGenerator = null;

    public function setUp()
    {
        $this->oGenerator = new Generators();
    }


    /**
     * @test
     */
    public function testResultIsInstanceOfUIFaces()
    {
        $this->assertInstanceOf(UIFace::class, $this->oGenerator->getRandomUser());
    }
}