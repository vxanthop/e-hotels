[< e-hotels](index.md) / index.php

# Routing

The `index.php` file includes a set of routing directives that define what action the app has to trigger when a specific path on the website is requested.

The most common request types are `GET` and `POST`. `GET` is used when a user simply visits a webpage through the browser and `POST` is used when a user submits a form on the website along with some data.

* [GET requests](#get-requests)
* [POST requests](#post-requests)

### GET requests

A user visits `/users` and we need our app to forward that request to `UserController::index()`. In this case, we may write the routing directive as shown below:

```php
// index.php

...

use \controllers\UserController as UserController;

$app->get('/users', function () use ($app) {

    return $app->Response('user_listing.php', [

        'users' => UserController::index()

    ], 200);

});
```

What is essentially happening here is that the app will fetch a users array from the `UserController::index()` method. Afterwards, the array will be passed to the `user_listing.php` view and will be available to it as the `$users` variable. The app will finally show the view to the user with the `Response` method and will return a `200 (OK)` HTTP status code.

#### Slugs

If we need to update our view according to the value of a URL parameter, such as `/user/nelson-mandela`, we can use a **slug**. A slug is defined by `:parameter_name` inside a route and its value is passed to the callback function as an argument, as shown below:

```php
// index.php

...

use \controllers\UserController as UserController;

$app->get('/user/:name', function ($name) use ($app) {

    return $app->Response('user_profile.php', [

        'user' => UserController::getByName($name);

    ], 200);

});
```

Thus, a request to `/user/nelson-mandela` will trigger a `UserController::getByName('nelson-mandela')` call that will hopefully return the data of the user with name `nelson-mandela` either through a database or in any other way we choose to implement our `getByName` controller action.

### POST requests

A user submits a form to change his password. Let's suppose that the form is submitted via a `POST` request to `/change-password`. An example of a routing directive that forwards this request to the `UserController::changePassword()` method is shown below:

```php
// index.php

...

use \controllers\UserController as UserController;

$app->post('/change-password', function () use ($app) {

    $result = UserController::changePassword($_POST['old_password'], $_POST['new_password']);

    if($result->status == "OK") {
        return $app->Response('password_changed.php', [
            'result' => $result
        ];
    } else {
        // If the request failed, return to the form and show an error
        return $app->Response('change_password_form.php', [
            'error' => 'Password change failed.'
        ];
    }

});
```

The data submitted through the form is available in the `$_POST` superglobal ([read more](https://www.w3schools.com/php/php_forms.asp)).