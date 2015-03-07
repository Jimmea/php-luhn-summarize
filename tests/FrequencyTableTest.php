<?php
/**
 * Test the FrequenceTable class
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 */
namespace test;

use Simplicitylab\Statistics\FrequencyTableBuilder;

class FrequencyTableTest extends \PHPUnit_Framework_TestCase
{

    private $freqTable;

    protected function setUp()
    {
        $this->freqTable = new FrequencyTableBuilder();
    }


    public function testBuildFrequencyTable()
    {
        $testSentence = "The bird, is sitting on a tree. The bird is looking to another bird.";
        $freqTableData =  $this->freqTable->getTable($testSentence);

        $this->assertEquals($freqTableData['the'], 2);
        $this->assertEquals($freqTableData['bird'], 3);
        $this->assertEquals($freqTableData['is'], 2);
    }

    public function testGetTotalWords()
    {
        $testSentence = "The bird, is sitting on a tree. The bird is looking to another bird.";
        $freqTableData =  $this->freqTable->getTable($testSentence);

        $this->assertEquals($this->freqTable->getTotalNumberOfWords(), 14);
    }

    public function testGetTotalUniqueWords()
    {
        $testSentence = "The bird, is sitting on a tree. The bird is looking to another bird.";
        $freqTableData =  $this->freqTable->getTable($testSentence);

        $this->assertEquals($this->freqTable->getTotalNumberOfUniqueWords(), 10);
    }
}
