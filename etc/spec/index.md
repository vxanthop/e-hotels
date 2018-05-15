# e-hotels/

* [src/models/](models.md)
* [src/controllers/](controllers.md)
* [src/views/](views.md)
* [src/bootstrap/](bootstrap.md)

* **index.php**  
    Routes are defined here and controllers are called to fetch the data and pass them to the views. Also the framework and the autoloader are loaded. Routing documentation is available [here](routing.md).
* **settings.php**  
    Configuration variables are declared here and are available throughout the app with the Config class. e.g. `Config::get('database')`.
* **schema.sql**  
    List of SQL creation queries that build the database and the tables.
* **seed.sql**  
    List of SQL insertion queries that fill the database tables.
* **.htaccess**  
    Magic Apache configuration file that redirects all requests to `index.php` so that it can operate as a router.
