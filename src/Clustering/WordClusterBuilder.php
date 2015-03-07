<?php

/**
 * This class creates word clusters based on a list of important words and the distance between them.
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 *
 * LICENSE: This source file is subject to version 2.1 of the LPGL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html.
 *
 * @version 1.0
 */


namespace Simplicitylab\Clustering;

class WordClusterBuilder
{

    private $listImportantWords;
    private $maxDistanceImportantWords;
    private $sentence;

    public function __construct($listImportantWords, $maxDistanceImportantWords)
    {
        $this->listImportantWords = $listImportantWords;
        $this->maxDistanceImportantWords = $maxDistanceImportantWords;
    }

    public function getClusters($sentence)
    {
        $this->sentence = $sentence;

        $clusters = array();

        // tokenize sentences
        $words = $this->tokenizeSentence();

        $importantWordsIndexes = array();
        $wordIndex = 0;


        // look for important words in sentence
        foreach ($words as $word) {
            $word = strtolower($word);

            // check if word is important
            if (array_key_exists($word, $this->listImportantWords)) {
                // push to array that will contain important word indexes
                array_push($importantWordsIndexes, $wordIndex);
            }

            $wordIndex++;
        }

        // sort array
        sort($importantWordsIndexes);

        // search for clusters
        if (count($importantWordsIndexes) > 0) {
            $cluster = array($importantWordsIndexes[0]);
            $i = 1;

            while ($i < count($importantWordsIndexes)) {
                if ($importantWordsIndexes[$i] - $importantWordsIndexes[$i-1] < $this->maxDistanceImportantWords) {
                    array_push($cluster, $importantWordsIndexes[$i]);
                } else {
                    array_push($clusters, $cluster);
                    $cluster = array( $importantWordsIndexes[$i]);
                }

                $i++;
            }
            array_push($clusters, $cluster);
        }
        return $clusters;
    }

    private function tokenizeSentence()
    {
        // strip punctuations
        // regular expressions selects all characters that aren't characters or numbers
        $this->text = preg_replace('/[^a-z0-9]+/i', '_', $this->sentence);

        // explode tokens
        // If the callback function is not supplied, array_filter() will remove all the entries
        // of input that are equal to FALSE or empty strings
        $tokens = array_filter(explode('_', $this->text));

        return $tokens;
    }
}
