<?php

/**
 * Test the FrequenceTable class
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 */
namespace test;

use Simplicitylab\Statistics\FrequencyTableBuilder;
use Simplicitylab\Clustering\WordClusterBuilder;

class WordClusterTest extends \PHPUnit_Framework_TestCase
{

    private $wordClusterBuilder;

    protected function setUp()
    {
    }


    public function testClusters()
    {
        $testStr = "This is a test. The test will be scheduled on 14 march. I want to eat icecream";

        // get frequency table
        $freqTableBuilder = new FrequencyTableBuilder();
        $freqTable = $freqTableBuilder->getTable($testStr);

        // get first five words
        $importantWords = array_slice($freqTable, 0, 5);

        $this->wordClusterBuilder = new WordClusterBuilder($importantWords, 3);

        $clusters = $this->wordClusterBuilder->getClusters("The test will march be scheduled on 14 march");

        $this->assertEquals(2, count($clusters));
    }
}
