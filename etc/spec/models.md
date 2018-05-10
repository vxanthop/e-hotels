[< e-hotels](index.md) / src / models

# Models

Models are either [_utility_](#utility-classes) classes or [_entity_](#entity-classes) classes. All entity classes inherit from the [`Model`](model.md) class.

### Utility classes
They provide global functionality to the app, like requesting data from a database or converting Greek text to Latin characters or performing arithmetic operations with Datesetc.

* **Config**: Reads the `/settings.php` file and returns configuration parameters with the `get` method.
    * `get($param)` Returns the value of the configuration parameter with key `$param`.
* **DB**: Connects with the database and provides methods to fetch and process data from it.
    * `query($sql)` Executes the SQL query given by the string `$sql` and returns the results.
    * `getCollection($query, $model = NULL)` Converts the results of a `SELECT` query to an **array** of objects of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.
    * `getOne($query, $model = NULL)` Fetches the first result from a `SELECT` query and converts it to an object of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.

### Entity classes
Entity classes represent the "real-life" objects of the app, such as a Person or a Transaction etc. The entity classes used in this app are the following:

* [HotelGroup](#hotelgroup)
* [Hotel](#hotel)
* [Employee](#employee)
* [Customer](#customer)
* [Transaction](#transaction)
* [Room](#room)
* [Amenity](#amenity)
* [City](#city)

#### HotelGroup
Each Hotel Group contains one or more Hotels. 
##### Properties
* `hotel_group_id`: The primary key of the Hotel Group.
* `number_of_hotels`: A number describing how many hotels are contained in the Hotel Group.
* `address`: An array containing all information about the physical address of the Hotel Group (`street`, `number`, `postal_code`, `city`). (computed)
* `email_addresses`: The email addresses of the Hotel Group. (computed)
* `phone_numbers`: The phone numbers of the Hotel Group. (computed)

##### Methods
* `all()`: Returns an array of all Hotel Groups
* `address_getter()`
* `email_addresses_getter()`
* `phone_numbers_getter()`


#### Hotel
Each Hotel contains Rooms and Employees that work in it.
##### Properties
* `hotel_id`: A number uniquely identifying the Hotel.
* `stars`: A number in the range [0, 5] describing the rating of the Hotel.
* `number_of_rooms`: A number describing how many hotels rooms are contained in the Hotel.
* `address`: An array containing all information about the physical address of the Hotel (`street`, `number`, `postal_code`, `city`). (computed)
* `email_addresses`: The email addresses of the Hotel. (computed)
* `phone_numbers`: The phone numbers of the Hotel. (computed)
* `manager`: An Employee serving as manager of the Hotel. (computed)

##### Methods
* `ofHotelGroup($hotel_group_id)`: Returns all Hotels of Hotel Group with key `$hotel_group_id`.
* `address_getter()`
* `email_addresses_getter()`
* `phone_numbers_getter()`
* `manager_getter()`


#### Employee
Each Employee works in a Hotel.
##### Properties
* `emp_IRS`: The internal revenue service number uniquely identifying an Employee.
* `SSN`: The social security number of the Employee.
* `first_name`: The first name of the Employee.
* `last_name`: The last name of the Employee.
* `current_job`: The current job of the Employee. (computed)
* `address`: An array containing all information about the address of the Employee (`street`, `number`, `postal_code`, `city`). (computed)

##### Methods
* `address_getter()`
* `current_job_getter()`


#### Customer
Each customer rents a Room and is involved in a Transcation.
##### Properties
* `cust_IRS`: The internal revenue service number uniquely identifying a Customer.
* `SSN`: The social security number of the Customer.
* `first_name`: The first name of the Customer.
* `last_name`: The last name of the Customer.
* `address`: An array containing all information about the address of the Customer (`street`, `number`, `postal_code`, `city`). (computed)
* `first_registration`: Records the first registration the Customer made to the system.z

##### Methods
* `address_getter()`

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
* `amenities`: A list of strings representing the amenities of the Room. (computed)
* `current_customer`: A Customer object representing the customer that is currently renting the room. If none is found, it is NULL.

##### Methods:
* `all()`: Returns an array of all the Rooms available along with their properties.
* `reserve($cust_IRS, $start_date, $finish_date)`: Is executed when a customer with key `$cust_IRS` reserves the room for the dates specified by `$start_date`, `$finish_date`.
* `check_in()`: Is executed when the customer that rented the room checks in.
* `amenities_getter()`
* `current_customer_getter()`


#### Transaction

##### Properties
* `transaction_id`: A number associated to a Transaction.
* `cust_IRS`: The IRS number of the customer associated with the Transaction.
* `emp_IRS`:  The IRS number of the employee associated with the Transaction.
* `room_id`: The id of the room associated with the Transaction. 
* `hotel_id`: The hotel where the room is contained.
* `payment_amount`: The amount that the customer has to pay.
* `payment_method`: A string that describes the way the customer can pay the needed amount. Possible values are:
    - `'cash'`
    - `'credit_card'`
    - `'debit_card'`
    - `'invoice'`

##### Methods
* `all()`: Returns an array with all the transactions.


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
* `city_name`: The name of the city.
* `hotels_in_city`: The number of hotels located in the city. (computed)


##### Methods
* `all()`: Returns an array of tuples containing all the cities along with the number of hotels located in each city.
* `hotels_in_city_getter()`