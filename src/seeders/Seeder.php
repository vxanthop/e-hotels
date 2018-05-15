<?php

namespace seeders;

use \models\Text as Text;

class Seeder {

    private static $positions = ['manager', 'accountant', 'receptionist', 'chef', 'gardener', 'maid', 'waiter', 'technician', 'marketing manager'];

    protected static function generatePerson() {
        $generator = file_get_contents('http://fakenametool.com/generator/random/el_GR/greece');
        $i = strpos($generator, '<h3><b>') + strlen('<h3><b>');
        $j = strpos($generator, '<', $i);
        $name = substr($generator, $i, $j - $i);
        $i = strpos($generator, '<p class="lead" >', $j) + strlen('<p class="lead" >');
        $j = strpos($generator, '</p>', $i);
        $address = substr($generator, $i, $j - $i);
        $i = strpos($name, '. ');
        if($i !== FALSE) {
            $name = substr($name, $i + 2);
        }
        $name = Text::toGreeklish($name);
        list($first_name, $last_name) = explode(' ', $name);
        list($street, $number, $postal_code, $city) = explode(', ', $address);
        $street = Text::toGreeklish(str_replace(['Όδος ', 'Λεωφόρος '], '', $street));
        $number = $number + 0;
        $postal_code = str_replace(' ', '', $postal_code) + 0;
        $hyphen = strpos($city, '-');
        if($hyphen !== FALSE) {
            $city = substr($city, 0, $hyphen);
        }
        $city = Text::toGreeklish($city);
        $address = compact('street', 'number', 'postal_code', 'city');
        return compact('last_name', 'first_name', 'address');
    }

    protected static function generateIRS() {
        return rand(0, 999999999);
    }

    protected static function generateSSN() {
        /* Random date between 1940-01-01 and 2000-12-31 */
        $moment = rand(-946771200, 978220800);
        return date('dmy', $moment) . sprintf('%05d', rand(0, 99999));
    }

    protected static function generatePosition() {
        return self::$positions[rand(0, count(self::$positions) - 1)];
    }

}