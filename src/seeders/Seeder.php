<?php

namespace seeders;

use \models\Text as Text;

class Seeder {

    private static $positions = ['accountant', 'receptionist', 'chef', 'gardener', 'maid', 'waiter', 'technician', 'marketing manager'];
    private static $names;
    private static $surnames;
    private static $addresses;
    private static $cities;

    private static function initDatasets() {
        if(!self::$names) {
            self::$names = json_decode(file_get_contents(__DIR__ . "/data/names.json"), true);
        }
        if(!self::$surnames) {
            self::$surnames = json_decode(file_get_contents(__DIR__ . "/data/surnames.json"), true);
        }
        if(!self::$addresses) {
            self::$addresses = json_decode(file_get_contents(__DIR__ . "/data/addresses.json"), true);
        }
        if(!self::$cities) {
            self::$cities = json_decode(file_get_contents(__DIR__ . "/data/cities.json"), true);
        }
    }

    protected static function generateName() {
        self::initDatasets();
        $gender = rand(0, 1) ? "males" : "females";
        $names = self::$names[$gender];
        $surnames = self::$surnames[$gender];
        $first_name = Text::toGreeklish($names[rand(0, count($names) - 1)]);
        $last_name = Text::toGreeklish($surnames[rand(0, count($surnames) - 1)]);
        return compact('last_name', 'first_name');
    }

    protected static function generateAddress() {
        self::initDatasets();
        $street = Text::toGreeklish(self::$addresses[rand(0, count(self::$addresses) - 1)]);
        $number = rand(1, 242);
        $city_tuple = self::$cities[rand(0, count(self::$cities) - 1)];
        $city = Text::toGreeklish($city_tuple["city"]);
        $postal_code = $city_tuple["zip"];
        return ['address' => compact('street', 'number', 'city', 'postal_code')];
    }

    protected static function generatePerson() {
        return array_merge(self::generateName(), self::generateAddress());
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