[< e-hotels](index.md) / [src / models](models.md) / Model.php

# Model

Entity classes represent the "real-life" objects of the app, such as a Person or a Transaction etc. All entity classes inherit from the `Model` class, which provides the following functionalities:

* [Auto-properties](#auto-properties)
* [Mapper](#mapper)
* [Computed properties](#computed-properties)

### Auto-properties

The `DB::getCollection` and `DB::getOne` methods will automatically assign a property for each field in the MySQL entry to your Model. For example:

```php
// models/User.php

class User extends Model {

    public static function getFirstNames() {
        
        // Get all first names
        $query = DB::query('SELECT First_name FROM Users');
        $users = DB::getCollection($query);

        // getCollection has returned an array of User objects
        foreach($users as $user) {
            // Print the properties of each object
            print_r(get_object_vars($user));
        }

    }

}
```

```php
// Result of User::getFirstNames()
Array
(
    [First_name] => Alice
)
Array
(
    [First_name] => Bob
)
Array
(
    [First_name] => Charlie
)
```

### Mapper

Auto-properties by default will have a `string` type and their name will be the same as the field name. If you need to rename some properties or change their type, you should use a mapper. A mapper is an associative array that is assigned to the protected static `$mapper` property in your Model, as shown in the following example:

```php
// models/User.php

class User extends Model {

    public $first, $last, $username, $birthyear;

    protected static $mapper = [
        'first_name' => 'first',
        'last_name' => 'last',
        'birthyear' => ['birthyear', 'int'],
    ];

}
```

The key of each mapper entry represents the MySQL field name. The value can be a string -the property name- or an array with 2 elements, the property name and the property type (`int`, `string`, `float`, `boolean` or `json`). Field names not included in the mapper will be assigned as they are, e.g. the `username` field will be automatically assigned to the `$username` property.

### Computed properties

Some desired properties of your Model may not be stored in the database as fields of an entry, either because they are dynamic or because they can be directly derived from other fields. For example, you cannot store the number of a user's Facebook friends, since it's a dynamic property and you need to use an API to obtain it. Or, you don't need to store the full name of a user since you can simply concatenate his first and last name. For this kind of properties, you can use a **computed property** that is calculated at runtime by a method, but can be used in the same manner as a normal property, e.g. `$user->fullname`. To define a computed property named _myproperty_, you need to create a _myproperty_\_getter function as shown below:

```php
// models/User.php

class User extends Model {

    public $first, $last;

    public function fullname_getter() {
        return $this->first . " " . $this->last;
    }

}
```

```php
<!-- views/user_profile.php -->

<h1><?php echo $user->fullname; ?></h1>
```