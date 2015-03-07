<?php
/**
 * Summarizes a text
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 *
 * LICENSE: This source file is subject to version 2.1 of the LPGL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html.
 *
 * @version 1.0
 */

namespace Simplicitylab\Summarizer;

use Simplicitylab\Statistics\FrequencyTableBuilder;
use Simplicitylab\Clustering\WordClusterBuilder;
use Simplicitylab\Splitters\SentenceSplitter;

class Summarizer
{
    private static function compareFloats($a, $b)
    {
        $a = $a['score'];
        $b = $b['score'];
        if ($a == $b) {
            return 0;
        }

        return ($a < $b) ? 1 : -1;
    }

    public function summarize($text, $stopwords, $numberSentences)
    {

        // 1) build frequencytable
        $freqTableBuilder = new FrequencyTableBuilder();
        $freqTableBuilder->setStopwords($stopwords);
        $freqTable = $freqTableBuilder->getTable($text);

        // 2 ) split text into sentences
        $sentenceSplitter = new SentenceSplitter();
        $sentences = $sentenceSplitter->split($text);


        // 3 ) build word clusters
        $wordClusterBuilder = new WordClusterBuilder($freqTable, 5);
        $sentence_scores = array();


        foreach ($sentences as $sentence) {
            // 3.1 ) Get clusters for sentence
            $clusters = $wordClusterBuilder->getClusters($sentence);

            // 3.2 ) Calculate score
            $maxClusterScore = 0;
            foreach ($clusters as $cluster) {
                $numberOfImportantWordsCluster = count($cluster);

                $lastItem = end($cluster);
                reset($cluster);

                $totalWordsInCluster = $lastItem - $cluster[0] + 1;

                $score = 1.0 * ($numberOfImportantWordsCluster * $numberOfImportantWordsCluster) / $totalWordsInCluster;

                if ($score > $maxClusterScore) {
                    $maxClusterScore = $score;
                }
            }

            array_push($sentence_scores, array("sentence" => rtrim($sentence), "score" => $maxClusterScore ));
        }

        // 4 ) sort scores
        usort($sentence_scores, array($this, 'compareFloats'));

        return array_slice($sentence_scores, 0, $numberSentences);
    }
}
