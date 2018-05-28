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
        $number = intval($number);
        $postal_code = intval(str_pad(str_replace(' ', '', $postal_code), 5, '0'));
        if($postal_code < 10000) {
            $postal_code += rand(1, 9) * 10000;
        }
        $hyphen = strpos($city, '-');
        if($hyphen !== FALSE) {
            $city = substr($city, 0, $hyphen);
        }
        $city = Text::toGreeklish($city);
        $address = compact('street', 'number', 'postal_code', 'city');
        return compact('last_name', 'first_name', 'address');
    }

    protected static function generateCity() {
        $cities = [
            ['city' => 'Elassona', 'postal_code' => 40200],
            ['city' => 'Meteora', 'postal_code' => 42200],
            ['city' => 'Lefkada', 'postal_code' => 31100],
            ['city' => 'Lindos', 'postal_code' => 85107],
            ['city' => 'Nikaia', 'postal_code' => 18453],
            ['city' => 'Skydra', 'postal_code' => 58500],
            ['city' => 'Spetses', 'postal_code' => 18050],
            ['city' => 'Delfoi', 'postal_code' => 33054],
            ['city' => 'Peiraias', 'postal_code' => 18540],
            ['city' => 'Donousa', 'postal_code' => 84300],
            ['city' => 'Amaliada', 'postal_code' => 27200],
            ['city' => 'Zagori', 'postal_code' => 44010],
            ['city' => 'Kalavryta', 'postal_code' => 25001],
            ['city' => 'Nafplio', 'postal_code' => 21100],
        ];
        return $cities[rand(0, count($cities) - 1)];
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