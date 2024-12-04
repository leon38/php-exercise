<?php
namespace Damien\Combodo\Tests;

use PHPUnit\Framework\TestCase;
use Damien\Combodo\XMLParser;
use DOMDocument;
use DOMXPath;

final class XMLParserTest extends TestCase
{
    public function testClassConstructor()
    {
        $parser = new XMLParser(__DIR__.'/../data/sample1.xml');
        $this->assertInstanceOf(DOMDocument::class, $parser->document);
        $this->assertInstanceOf(DOMXPath::class, $parser->xpath);
    }

    public function testMultipleParentsError()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("File is not formatted correctly, a class can only have one parent");
        $parser = new XMLParser(__DIR__.'/../data/multipleParents.xml');
        $parser->parseItems();
        $this->assertFileDoesNotExist(__DIR__.'/../output/classes.php');
    }

    public function testParentDoesNotExist()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The parent class is not declared");
        $parser = new XMLParser(__DIR__.'/../data/parentDoesNotExist.xml');
        $parser->parseItems();
        $this->assertFileDoesNotExist(__DIR__.'/../output/classes.php');
    }

    public function testParseItems()
    {
        $parser = new XMLParser(__DIR__.'/../data/sample1.xml');
        $parser->parseItems();
        $outputFile = __DIR__.'/../output/classes.php';
        $this->assertFileExists($outputFile);
        $handle = fopen($outputFile, 'r');
        $contents = fread($handle, filesize($outputFile));
        $expected = <<<EOS
        <?php
        class Ga
        {
        }
        class Bu extends Ga
        {
        }
        class Zo extends Bu
        {
        }
        class Meu extends Ga
        {
        }
        
        EOS;
        $this->assertEquals($expected, $contents);
    }
}