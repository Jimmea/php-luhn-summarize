<?php

/**
 * Tokenizes a string
 *
 * @author Glenn De Backer < glenn@simplicity.be>
 *
 * LICENSE: This source file is subject to version 2.1 of the LPGL license
 * that is available through the world-wide-web at the following URI:
 * https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html.
 *
 * @version 1.0
 */

namespace Simplicitylab\Splitters;

class Tokenizer
{
    private $stopWords;

    public function __construct()
    {
        $this->stopWords = array();
    }

    public function setStopwords($stopWordsArray)
    {
        $this->stopWords = array();

        foreach ($stopWordsArray as $stopword) {
            $stopword = strtolower($stopword);
            $stopword = rtrim($stopword);

            array_push($this->stopWords, $stopword);
        }
    }

    public function tokenize($text)
    {

        // strip punctuations
        // regular expressions selects all characters that aren't characters or numbers
        $text = preg_replace('/[^a-z0-9]+/i', '_', $text);

        // explode tokens
        // If the callback function is not supplied, array_filter() will remove all the entries
        // of input that are equal to FALSE or empty strings
        $tokens = array_filter(explode('_', $text));

        $filteredTokens = array();

        // filter tokens
        if (count($this->stopWords) > 0) {
            foreach ($tokens as $token) {
                $token = strtolower($token);

                if (!in_array($token, $this->stopWords)) {
                    array_push($filteredTokens, $token);
                }
            }
        } else {
            $filteredTokens = $tokens;
        }

        return $filteredTokens;
    }
}
