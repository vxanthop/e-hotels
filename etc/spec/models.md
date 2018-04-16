[< e-hotels](index.md) / src / models

# Models

Models are either [_utility_](#utility-classes) classes or [_entity_](#entity-classes) classes.

### Utility classes
They provide global functionality to the app, like requesting data from a database or converting Greek text to Latin characters or performing arithmetic operations with Dates etc.

* **Config**: Reads the `/settings.php` file and returns configuration parameters with the `get` method.
    * `::get($param)` Returns the value of the configuration parameter with key `$param`.
* **DB**: Connects with the database and provides methods to fetch and process data from it.
    * `::query($sql)` Executes the SQL query given by the string `$sql` and returns the results.
    * `::getCollection($query, $model = NULL)` Converts the results of a `SELECT` query to an **array** of objects of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.
    * `::getOne($query, $model = NULL)` Fetches the first result from a `SELECT` query and converts it to an object of the `$model` class. If no `$model` parameter has been given, it tries to guess it from the backtrace.

### Entity classes
Entity classes represent the "real-life" objects of the app, such as a Person or a Transaction etc. All entity classes inherit from the `Model` class, which is documented [here](model.md). The entity classes used in this app are the following:

* [HotelGroup](#hotelgroup)
* [Hotel](#hotel)
* ...

#### HotelGroup
_Insert here description and specs of the HotelGroup model._


#### Hotel
_Insert here description and specs of the Hotel model._

#### ...