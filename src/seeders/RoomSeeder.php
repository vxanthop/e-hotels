<?php

namespace seeders;

use \models\Hotel as Hotel;
use \models\Room as Room;
use \models\DB as DB;
use \models\Text as Text;

class RoomSeeder extends Seeder {

    public static function run($num) {
        header('Content-type: text/plain');
        $amenities = ['A/C', 'Wi-Fi', 'Parking', 'Pets allowed', 'Swimming pool', 'Spa', 'Gym', 'Accessibility', 'No-smoking areas', 'Bathtub', 'Balcony', 'Washing machine', 'Coffee machine', 'Flat TV', 'Kitchen', 'Soundproofing', 'Hairdryer', 'Clothes iron', 'Microwave', 'Safe', 'Fridge'];
        $pool = Hotel::all();
        if(isset($_GET['withMax'])) {
            $pool = array_values(array_filter($pool, function($hotel) {
                return $hotel->number_of_rooms <= intval($_GET['withMax']);
            }));
        }
        $expandable_values = ['', 'more_beds', 'connecting_room'];
        $hotels = [];
        foreach($pool as $hotel) {
            $hotels = array_merge($hotels, array_fill(0, $hotel->stars, $hotel));
        }
        $i = 0;
        while($i < $num) {
            $hotel = $hotels[rand(0, count($hotels) - 1)];
            $price = round(exp(rand(4070 * log($hotel->stars + 2) / log(7), 5703 * log($hotel->stars + 3) / log(8)) / 1000), 1);
            $data = [
                'hotel_id' => $hotel->id,
                'capacity' => rand(1, 10),
                'view' => rand(0, 1) == 0,
                'repairs_need' => rand(0, 1) == 0,
                'expandable' => $expandable_values[rand(0, 2)],
                'price' => $price,
            ];
            $query = Room::create($data);
            if($query) {
                $room = Room::getOne([
                    'room_id' => DB::insert_id()                
                ]);
                shuffle($amenities);
                $amenity_count = rand(0, 1.5 * $hotel->stars);
                $j = 0;
                while($j < $amenity_count) {
                    $add = $room->addAmenity($amenities[$j]);
                    if($add) {
                        ++$j;
                    } else {
                        echo DB::error(), "\n";
                    }
                }
                ++$i;
            } else {
                echo DB::error(), "\n";
            }
        }
    }

}