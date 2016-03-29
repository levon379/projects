<?php

namespace backend\components;

class UnicodeHelper
{
    /**
     * Strips Glyphs and Emoji Unicode characters that may not be properly displayed by desktop browsers.
     * @param mixed $text 
     * @return mixed
     */
    public static function CleanupText($text) {
        $result = $text;
        // REF: http://apps.timwhitlock.info/emoji/tables/unicode
        // Miscellaneous Symbols and Pictographs ( 1F300 - 1F5FF )
        $result = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $result);
        // Emoticons ( 1F600 - 1F64F )
        $result = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $result);
        // Miscellaneous Symbols ( 2600 - 26FF )
        $result = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $result);
        // Dingbats ( 2700 - 27BF )
        $result = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $result);
        // Transport and map symbols ( 1F680 - 1F6FF )
        $result = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $result);
        // Enclosed Alphanumerics ( 2460 - 24FF )
        $result = preg_replace('/[\x{2460}-\x{24FF}]/u', '', $result);
        // Box Drawing ( 2500 - 257F )
        $result = preg_replace('/[\x{2500}-\x{257F}]/u', '', $result);
        // Enclosed Ideographic Supplement ( 1F200 - 1F2FF )
        $result = preg_replace('/[\x{1F200}-\x{1F2FF}]/u', '', $result);
        // Braille Patterns ( 2800 - 28FF )
        $result = preg_replace('/[\x{2800}-\x{28FF}]/u', '', $result);
        // Miscellaneous Symbols and Arrows ( 2B00 - 2BFF )
        $result = preg_replace('/[\x{2B00}-\x{2BFF}]/u', '', $result);
        // Low Surrogates ( DC00 - DFFF ) - Isolated surrogate code points have no interpretation;
        // consequently, no character code charts or names lists are provided for this range.
        //$result = preg_replace('/[\x{DC00}-\x{DFFF}]/u', '', $result);
        // High Surrogates ( D800 - DB7F ) - Isolated surrogate code points have no interpretation;
        // consequently, no character code charts or names lists are provided for this range.
        //$result = preg_replace('/[\x{D800}-\x{DB7F}]/u', '', $result); <- Throws "Invalid Code Point" Error
        //$result = preg_replace('/[\x{D800}-\x{DB00}]/u', '', $result);
        // Private Use Area ( E000 - F8FF ) - The Private Use Area does not contain any character assignments,
        // consequently no character code charts or names lists are provided for this area.
        $result = preg_replace('/[\x{E000}-\x{F8FF}]/u', '', $result);
        
        return $result;
    }
}
