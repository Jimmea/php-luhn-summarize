<?php

/**
 * Split text into sentences
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

class SentenceSplitter
{

    public function split($text)
    {
        $text = preg_replace('/(?<=[.])(?=[\'\"a-z])/i', " ", $text);

        $sentences = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $text);

        return $sentences;
    }
}
