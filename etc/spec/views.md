[< e-hotels](index.md) / src / views

# Views

Views are template files that receive data from the app controllers and display them to the user in the form of HTML/CSS content. Essentially, views are the user interface of the app. Views may use _layouts_, ie. much more generic templates in which the views will be rendered, like the theme of a website. Documentation for layouts can be found [here](layouts.md).

The command to render a view is `$app->Response(...)` and has to be included inside a [route](routing.md) callback. The syntax is shown below.

```php
// index.php

...

$app->get('/dashboard', function () use ($app) {

    $data = DashboardController::index();

    // Load the src/views/dashboard.php view
    $app->Response('dashboard.php', [

        'data' => $data,
        '_layout' => 'theme.php' // Use the src/views/layouts/theme.php layout

    ], 200);

});
```

In the above example, the first parameter of the `Response` method is the filename of the view (all views are stored in the `src/views/` directory), the second parameter is an array of data that will be passed to the view and the third optional parameter is the status code that will be returned.

Also, as can be seen, the filename of the _layout_ is given along with the data array and is bound to the `_layout` key. All layouts are stored in the `src/views/layouts/` directory.

If no layout parameter is provided, then the view is simply rendered as a single file.

The views used in this app are the following:

* [Home](#home)
* [Results page](#results-page)
* ...

### Home
_Insert here description and specs of the Home view._


### Results page
_Insert here description and specs of the Results page view._
