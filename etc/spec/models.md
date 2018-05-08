[< e-hotels](index.md) / src / models

# Models

Models are either [_utility_](#utility-classes) classes or [_entity_](#entity-classes) classes.

### Utility classes
They provide global functionality to the app, like requesting data from a database or converting Greek text to Latin characters or performing arithmetic operations with Datesetc.

* **Config**: Reads the `/settings.php` file and returns configuration parameters with the `get` method.
    * `get($param)` Returns the value of the configuration parameter with key `$param`.
* **DB**: Connects with the database and provides methods to fetch and process data from it.
    * `query($sql)` Executes the SQL query given by the string `$sql` and returns the results.
    * `getCollection($query, $model = NULL)` Converts the results of a `SELECT` query to an **array** of objects of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.
    * `getOne($query, $model = NULL)` Fetches the first result from a `SELECT` query and converts it to an object of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.

### Entity classes
Entity classes represent the "real-life" objects of the app, such as a Person or a Transaction etc. All entity classes inherit from the `Model` class, which is documented [here](model.md). The entity classes used in this app are the following:

* [HotelGroup](#hotelgroup)
* [Hotel](#hotel)
* [Room](#room)
* [Amenity](#amenity)
* [City](#city)
* ...

#### HotelGroup
Each Hotel is contained in a Hotel Group.
##### Properties
* `hotel_group_id`: The primary key of the Hotel Group
* `number_of_hotels`: A number describing how many hotels are contained in the Hotel Group
* `address`: An array containing all information about the physical address of the Hotel Group (`street`, `number`, `postal_code`, `city`)
* `email_addresses`: The email addresses of the Hotel Group (computed)
* `phone_numbers`: The phone numbers of the Hotel Group (computed)
* `hotels`:  An array of Hotel objects representing the hotels contained in the Hotel Group (computed)

##### Methods
* `all()`: Returns an array of the basic information about the Hotel Group (`hotel_group_id`, `numer_of_hotels`, `address`)
* `address_getter()`
* `email_addresses_getter()`
* `phone_addresses_getter()`
* `hotels_getter()`


#### Hotel
Each Hotel contains Rooms and Employees that work in it.
##### Properties
* `hotel_id`: A number uniquely identifying the Hotel
* `stars`: A number in the range [0, 5] describing the rating of the Hotel
* `number_of_rooms`: A number describing how many hotels rooms are contained in the Hotel
* `address`: An array containing all information about the physical address of the Hotel (`street`, `number`, `postal_code`, `city`) (computed)
* `email_addresses`: The email addresses of the Hotel (computed)
* `phone_numbers`: The phone numbers of the Hotel (computed)

##### Methods
* `all()`: Returns an array of the basic information about the Hotel (`hotel_id`, `stars`, `address`, `number_of_rooms`)
* `address_getter()`
* `email_addresses_getter()`
* `phone_addresses_getter()`


#### Room
Each Hotel contains Rooms that are rented to a Customer and rented by an Employee.
##### Properties:
* `room_id`: A number associated to a Room. This need not be unique within the whole table of Rooms, because the primary key of Room consists of both `room_id` and `hotel_id`.
* `hotel_id`: The primary key of the hotel to which this room belongs.
* `customer_id`: The SSN of the customer that has rented this Room.
* `employee_id`: The SSN of the employee that is responsible for renting and checking in the Room.
* `capacity`: An integer describing the number of people that can be accommodated in the Room.
* `view`: A boolean value indicating whether or not the Room has a view to the sea.
* `expandable`: A string that describes whether the Room can be expanded and if so, in which way. Possible values are:
    - `'connecting_room'`
    - `'more_beds'`
    - `''`
* `repairs_need`: A boolean value indicating whether or not the Room needs any repairs.
* `price`: A float number with precision of 2 digits that describes the renting cost of the Room per night.
* `amenities`: A list of strings representing the amenities of the Room (computed)

##### Methods:
* `all()`: Returns an array of all the Rooms available along with their properties.
* `amenities_getter()`


#### Amenity
Each Room has a list of Amenities, such as Wi-Fi, A/C etc.
##### Properties:
* `room_id`: The ID of the Room that this Amenity refers to.
* `hotel_id`: The ID of the Hotel that the Room belongs to.
* `amenity`: A string representing one amenity of the Room with key (`room_id`, `hotel_id`).

_Note:_ The primary key of an Amenity entry is the tuple (`room_id`, `hotel_id`, `amenity`).

##### Methods:
* `all()`: Returns an array of strings representing all the distinct amenities available among all hotels and rooms.
* `ofRoom($room_id, $hotel_id)`: Returns an array of Amenity objects that represent all amenities of the Room with key (`$room_id`, `$hotel_id`).


#### City
Each Hotel, HotelGroup is located in a city.
##### Properties
* `city_name`: The name of the city
* `hotels_in_city`: The number of hotels located in the city (computed)

##### Methods
* `all()`: Returns an array of tuples containing all the cities along with the number of hotels located in each city.
* `hotels_in_city_getter()`


#### ...