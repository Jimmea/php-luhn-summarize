<?php

/**
 * Test the Sentence splitter class
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 */
namespace test;

use Simplicitylab\Splitters\SentenceSplitter;

class SentenceSplitterTest extends \PHPUnit_Framework_TestCase
{

    private $sentenceSplitter;

    protected function setUp()
    {
        $this->sentenceSplitter = new SentenceSplitter();
    }

    public function testSplitter()
    {
        $testStr = "This is a test.This is a test. This is a test! This is a test?
        This is a test nr. 3?! This is a test... The End";

        $sentences = $this->sentenceSplitter->split($testStr);

        $this->assertEquals(7, count($sentences));
    }
}
