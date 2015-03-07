<?php

/**
 * Test the FrequenceTable class
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 */
namespace test;

use Simplicitylab\Summarizer\Summarizer;

class SummarizerTest extends \PHPUnit_Framework_TestCase
{
    public function testSummarizer()
    {
        // get content of textfile
        $txt       = file_get_contents("data/text.txt");
        $stopwords = file("data/stopwords.txt");

        $summarize = new Summarizer();
        $sentences = $summarize->summarize($txt, $stopwords, 5);

        $output = "";
        foreach ($sentences as $sentence) {
            $output .= " " . $sentence['sentence'];
        }

        echo $output;
    }
}
