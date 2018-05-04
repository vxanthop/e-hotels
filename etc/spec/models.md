[< e-hotels](index.md) / src / models

# Models

Models are either [_utility_](#utility-classes) classes or [_entity_](#entity-classes) classes.

### Utility classes
They provide global functionality to the app, like requesting data from a database or converting Greek text to Latin characters or performing arithmetic operations with Dates etc.

* **Config**: Reads the `/settings.php` file and returns configuration parameters with the `get` method.
    * `get($param)` Returns the value of the configuration parameter with key `$param`.
* **DB**: Connects with the database and provides methods to fetch and process data from it.
    * `query($sql)` Executes the SQL query given by the string `$sql` and returns the results.
    * `getCollection($query, $model = NULL)` Converts the results of a `SELECT` query to an **array** of objects of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.
    * `getOne($query, $model = NULL)` Fetches the first result from a `SELECT` query and converts it to an object of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.

### Entity classes
Entity classes represent the "real-life" objects of the app, such as a Person or a Transaction etc. All entity classes inherit from the `Model` class, which is documented [here](model.md). The entity classes used in this app are the following:

* [Room](#room)
* [Amenity](#amenity)
* ...

#### Room
Each Hotel contains Rooms that are rented to a Customer and rented by an Employee.
##### Properties:
* `room_id`: A number associated to a Room. This need not be unique within the whole table of Rooms, because the primary key of Room consists of both `room_ID` and `hotel_id`.
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

##### Methods:
* `all()`: Returns an array of all the Rooms available along with their properties.

#### Amenity
Each Room has a list of Amenities, such as Wi-Fi, A/C etc.
##### Properties:
* `room_id`: The ID of the Room that this Amenity refers to.
* `hotel_id`: The ID of the Hotel that the Room belongs to.
* `amenity`: A string representing one amenity of the Room with key (`room_id`, `hotel_id`).

_Note:_ The primary key of an Amenity entry is the tuple (`room_id`, `hotel_id`, `amenity`).

##### Methods:
* `all()`: Returns an array of strings representing all the various amenities available among all hotels and rooms.
* `ofRoom($key)`: Returns an array of Amenity objects that represent all amenities of the Room with key `$key`.

#### ...