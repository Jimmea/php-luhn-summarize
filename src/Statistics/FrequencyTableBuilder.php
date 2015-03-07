<?php

/**
 * Builds a frequency table
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 *
 * LICENSE: This source file is subject to version 2.1 of the LPGL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html.
 *
 * @version 1.0
 */

namespace Simplicitylab\Statistics;

use Simplicitylab\Splitters\Tokenizer;

class FrequencyTableBuilder
{

    private $tokens;
    private $freqTable;
    private $tokenizer;

    public function __construct()
    {
        $this->tokenizer = new Tokenizer();
    }

    public function setStopwords($stopWordsArray)
    {
        $stopWords = array();

        foreach ($stopWordsArray as $stopword) {
            $stopword = strtolower($stopword);
            $stopword = rtrim($stopword);

            array_push($stopWords, $stopword);
        }

        $this->tokenizer->setStopWords($stopWords);
    }


    public function buildTable()
    {
        $count = array();

        foreach ($this->tokens as $token) {
            $token = strtolower($token);

            if (isset($count[ $token ])) {
                $count[ $token ] =  $count[ $token ] + 1;
            } else {
                $count[ $token ] =  1;
            }
        }

        // sort array
        arsort($count);

        // cache freqtable
        $this->freqTable = $count;
    }


    public function getTable($text)
    {
        $this->tokens = $this->tokenizer->tokenize($text);

        $this->buildTable();

        return  $this->freqTable;
    }

    public function getTotalNumberOfWords()
    {
        return count($this->tokens);
    }


    public function getTotalNumberOfUniqueWords()
    {
        return count($this->freqTable);
    }
}
