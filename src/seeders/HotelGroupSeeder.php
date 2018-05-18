<?php

namespace seeders;

use \models\HotelGroup as HotelGroup;
use \models\DB as DB;
use \models\Text as Text;

class HotelGroupSeeder extends Seeder {

    public static function run($num) {
        $names = 
        ['21c Museum', 'A&O', 'Abu Dhabi National', 'AC', 'AccorHotels', 'Ace', 'Adagio', 'Aerowisata', 'Affinia Collection', 'Aitken Spence', 'AJ Capital Partners', 'Allegro Corporation', 'Aloft', 'Aman', 'Amari', 'AmericInn', 'AMResorts', 'Andaz', 'APA', 'Aqua', 'Aqueen', 'Archipelago International', 'Arp-Hansen', 'Autograph Collection', 'Avani', 'Azimut', 'Baglioni', 'Bahia Principe', 'B&B', 'Banyan Tree Holdings', 'Baymont Inn', 'BD', 'Beaches', 'Belmond', 'Best Value Inn', 'Best Western', 'Bloc', 'Boscolo', 'Bowman-Biltmore', 'Brisas', 'Brøchner', 'Budget Host', 'Budget of America', 'Cachet', 'Camino Real', 'Canadian National', 'Canalta', 'Candlewood', 'Center Parcs', 'Cham Palaces', 'Chartwell Leisure', 'Chez', 'Choice', 'CitizenM', 'Club Med', 'Club Quarters', 'Coast', 'Cobblestone', 'Compagnie Internationale des Grands', 'Conrad Dubai', 'Conrad', 'Conrad London St. James', 'Continental', 'Corinthia International', 'Country Inns', 'Couples', 'Courtyard by Marriott', 'Crest', 'Crowne Plaza', 'Curio', 'D2', 'Dalata', 'Danubius', 'Davenport Collection', 'Days Inn', 'Days Inn China', 'Days Inns – Canada', 'Dedeman', 'Delta', 'Deutsche Hospitality', 'Divan', 'Dolce', 'Dom Pedro & Golf Collection', 'Dorchester Collection', 'Dorsett Hospitality International', 'DoubleTree', 'Doyle Collection', 'Drury', 'Dusit', 'Dusit Thani', 'EasyHotel', 'Embassy by Hilton', 'Eppley Company', 'Esso Motor', 'Eton Collection', 'Eurostars', 'Even', 'FabHotels', 'Fairfield Inn by Marriott', 'Fairmont', 'Federal', 'Fiesta Inn', 'Flair', 'Flatotel', 'Fontainebleau', 'Four Points by Sheraton', 'Four Seasons', 'FRHI', 'Fuerte', 'Gaylord', 'Generator', 'Glacier Park Company', 'Go', 'Grace', 'Grand America', 'Grange', 'Grecotel', 'GreenTree Inns', 'Groupe Lucien Barrière', 'Grupo Habita', 'Grupo Posadas', 'Guldsmeden', 'H10', 'Hampton by Hilton', 'Harbour Plaza Management', 'Harbour Plaza', 'Hawthorn', 'Heartland Inn', 'Hilton Garden Inn', 'Hilton', 'HMI', 'Holiday Inn', 'Holiday Inn Express', 'Holiday Inn Sunspree', 'Holland America Line', 'Home2 by Hilton', 'Homewood by Hilton', 'Hoshino', 'Hospitality International', 'Hotel Formule 1', 'Hotel Grand Chancellor', 'Hotel Indigo', 'Hotel loyalty program', 'Hotel RL', 'Hotel Shilla', 'Howard Johnson\'s', 'Hoxton', 'Hyatt', 'Iberostar', 'Ibis Budget', 'Ibis', 'IHG Army', 'Impala of', 'Imperial', 'InterContinental', 'Interhotel', 'Isrotel', 'ITC', 'Jameson Inn', 'Jetwing', 'JJW', 'JK Place', 'Jurys Inn', 'JW Marriott', 'Kempinski', 'Kimpton & Restaurants', 'Knights Inn', 'La Quinta Inns', 'Langham Hospitality', 'Lark', 'Leading of World', 'Lebua', 'Leela Palaces,', 'Lemon Tree', 'Loews', 'Lotte', 'Groupe du Louvre', 'Luxury Collection', 'Macdonald', 'Magnuson', 'Majestic', 'Mamaison', 'Mandarin Oriental', 'Marco Polo', 'Marcus', 'Mark Warner Ltd', 'Marriott', 'Marriott International', 'Masters Inn', 'Maybourne', 'ME by Meliá', 'Meliá International', 'Mercure', 'Le Méridien', 'Microtel Inn and', 'Mielparque', 'Minor', 'Minor International', 'Miramar and Investment', 'MKG', 'Mondrian', 'Morgans', 'Motel 6', 'Motel 8', 'Motel One', 'Mövenpick', 'Neemrana', 'New Otani', 'NH', 'Nikko', 'Nordic Choice', 'Novotel', 'Nunez i Navarro', 'Nylo', 'Oberoi', 'Okura', 'Okura Nikko Management', 'Omenahotelli', 'Omni', 'Outrigger', 'Pan Pacific', 'Parador', 'Park Plaza', 'Pearl-Continental', 'Peninsula', 'Pentahotels', 'Peppermint', 'Pierre & Vacances', 'Plaza Seoul', 'Poseidon Undersea', 'Pousadas de Portugal', 'Preferred', 'Premier Inn', 'Prince', 'Principal Company', 'Principe di Savoia', 'Protea by Marriott', 'Pueblo Bonito', 'Pullman', 'Radisson Blu', 'Radisson', 'Radisson Red', 'Raffles', 'Ramada', 'Ramada Asia-Pacific', 'Ramada International', 'Red Carpet Inn', 'Red Lion', 'Red Lion Corporation', 'Red Planet', 'Red Roof Inn', 'Referral chain', 'Regal International', 'Regent International', 'Relais & Châteaux', 'Renaissance', 'Ritz-Carlton Company', 'RIU', 'Rocco Forte', 'RockResorts', 'Rodeway Inn', 'Royal Cliff', 'Rydges', 'Sandals', 'Sandman', 'Santika Indonesia', 'Sarovar', 'Sava', 'Scandic', 'Scottish Inns', 'Serena', 'Servatur', 'Shangri-La', 'Sheraton', 'Shilo Inns', 'Shoney\'s Inn', 'Sukosol', 'Silken', 'Sinclairs Limited', 'Sino', 'Sofitel', 'Sokha', 'Sokos', 'Soneva', 'St. Regis', 'Standard', 'Starhotels', 'Suite Novotel', 'Super 8 Motels', 'Susse Chalet', 'Swire', 'Swiss Quality International', 'Swiss-Belhotel International', 'Swissôtel', 'Taj and Palaces', 'Thon', 'Toyoko Inn', 'Traveller\'s Inn', 'Travelodge', 'Travelodge Australia', 'Treebo', 'Tru by Hilton', 'Trump Organization', 'TRYP by Wyndham', 'Tsokkos', 'Tune', 'Umi', 'UNA', 'Ushuaïa Ibiza Beach', 'Vagabond Inn', 'Vantage Hospitality', 'Victoria-Jungfrau Collection', 'Virgin', 'Viva', 'W', 'Waldorf Astoria', 'Westin', 'Wingate By Wyndham', 'WoodSpring', 'Woolley’s Classic', 'Wyndham', 'Yotel', 'Zleep'];
        $extras = array_merge(array_fill(0, 20, 0), array_fill(0, 8, 1), array_fill(0, 4, 2), [3, 3]);
        $email_prefixes = ['hello', 'hey', 'accommodation', 'reserve', 'booking', 'group'];
        $i = 0;
        while($i < $num) {
            $name = $names[rand(0, count($names) - 1)];
            $checkName = HotelGroup::getOne([
                'name' => $name,
            ]);
            if(!is_null($checkName)) continue;

            $gen = self::generatePerson();
            $data = [
                'name' => $name,
                'address' => $gen['address']
            ];
            $query = HotelGroup::create($data);
            if($query) {
                $group = HotelGroup::getOne([
                    'id' => DB::insert_id()                
                ]);
                $slug = Text::slugify($name);
                $group->addEmail('info@' . $slug . '.com');
                $email_count = $extras[rand(0, count($extras) - 1)];
                shuffle($email_prefixes);
                foreach(array_slice($email_prefixes, 0, $email_count) as $prefix) {
                    $group->addEmail($prefix . '@' . $slug . '.com');
                }
                $area = strval(rand(1, 999));
                $phone = intval('2' . $area . '0' . sprintf('%0' . strval(8 - strlen($area)) . 'd', rand(0, 10 ** (8 - strlen($area)) - 4)));
                $phones = range($phone, $phone + $extras[rand(0, count($extras) - 1)]);
                foreach($phones as $p) {
                    $group->addPhone($p);
                }
                ++$i;
            }
        }
    }

}