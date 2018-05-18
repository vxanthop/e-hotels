<?php

namespace seeders;

use \models\HotelGroup as HotelGroup;
use \models\Hotel as Hotel;
use \models\DB as DB;
use \models\Text as Text;

class HotelSeeder extends Seeder {

    public static function run($num) {
        $suffixes = ['', ' Hotel', ' Resort', ' Suites', ' Apartments'];
        $groups = HotelGroup::all();
        $extras = array_merge(array_fill(0, 20, 0), array_fill(0, 8, 1), array_fill(0, 4, 2), [3, 3]);
        $email_prefixes = ['hello', 'hey', 'accommodation', 'reserve', 'booking', 'group'];
        $i = 0;
        while($i < $num) {
            $group = $groups[rand(0, count($groups) - 1)];
            $gen = self::generatePerson();
            $names = array_merge($suffixes, array_fill(0, count($suffixes), ' ' . $gen['address']['city']));
            $name = $group->name . $names[rand(0, count($names) - 1)];
            $data = [
                'hotel_group_id' => $group->id,
                'address' => $gen['address'],
                'name' => $name,
                'stars' => rand(1, 5)
            ];
            $query = Hotel::create($data);
            if($query) {
                $hotel = Hotel::getOne([
                    'id' => DB::insert_id()                
                ]);
                $slug = Text::slugify($group->name);
                $hotel->addEmail('info@' . $slug . '.com');
                if(rand(0, 1) == 0) $hotel->addEmail(Text::slugify($data['address']['city']) . '@' . $slug . '.com');
                $area = strval(rand(1, 999));
                $phone = intval('2' . $area . '0' . sprintf('%0' . strval(8 - strlen($area)) . 'd', rand(0, 10 ** (8 - strlen($area)) - 4)));
                $phones = range($phone, $phone + $extras[rand(0, count($extras) - 1)]);
                foreach($phones as $p) {
                    $hotel->addPhone($p);
                }
                ++$i;
            }
        }
    }

}