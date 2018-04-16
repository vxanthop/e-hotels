[< e-hotels](index.md) / src / bootstrap

# Bootstrap

The bootstrap folder contains the following files:

* [one_framework.php](one_framework-php)
* [loader.php](loader-php)
* [BaseModel.php](basemodel-php)

### one_framework.php

A single-file PHP micro-framework written by [J.C. Martin](https://github.com/juliomatcom/one-php-microframework) which provides us with the necessary routing and view tools that make building our MVC app easier.

### loader.php

A simple script that autoloads controller, view and model files without needing to require them anywhere in the app. Whenever an unloaded class is called, the loader script guesses the path of the corresponding file from the class namespace and includes it automatically.

### BaseModel.php

This is where the [Model](model.md) functionality is implemented.