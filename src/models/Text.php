<?php

namespace models;

class Text {

    public static function toGreeklish($text) {
        $greek = ['αυ','αύ','αϋ','αΰ','Αυ','Αύ','Αϋ','Αΰ','Άυ','α','ά','Ά','Α','β','Β','γ','Γ','δ','Δ','ευ','εύ','εϋ','εΰ','Ευ','Εύ','Εϋ','Εΰ','Έυ','ε','έ','Ε','Έ','ζ','Ζ','η','ή','Η','Ή','θ','Θ','ι','ί','ϊ','ΐ','Ι','Ί','κ','Κ','λ','Λ','μπ','Μπ','μ','Μ','ν','Ν','ξ','Ξ','ου','ού','οϋ','οΰ','Ου','Ού','Οϋ','Οΰ','Όυ','ο','ό','Ο','Ό','π','Π','ρ','Ρ','σ','ς','Σ','τ','Τ','υ','ύ','Υ','Ύ','φ','Φ','χ','Χ','ψ','Ψ','ω','ώ','Ω','Ώ',' ',"'","'",',','?','!',';','(',')','/', '<', '>', '@', '#', '$', '%', '^', '&', '*', '+', '='];
        $english = ['au','au','ay','ay','Au','Au','Ay','Ay','Ay','a','a','A','A','v','V','g','G','d','D','eu','eu','ey','ey','Eu','Eu','Ey','Ey','Ey','e','e','E','E','z','Z','i','i','I','I','th','Th','i','i','i','i','I','I','k','K','l','L','b','B','m','M','n','N','x','X','ou','ou','oy','oy','Ou','Ou','Oy','Oy','Oy','o','o','O','O','p','P','r','R','s','s','S','t','T','y','y','Y','Y','f','F','ch','Ch','ps','Ps','o','o','O','O',' ','','','','','','','','','','','','','','','','','','','',''];
        $text = str_replace($greek, $english, $text);
        return $text;
    }
    
    public static function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

}