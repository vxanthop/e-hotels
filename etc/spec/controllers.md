[< e-hotels](index.md) / src / controllers

# Controllers

Controllers are responsible for handling the requests from the user, fetching the data from the [models](models.md) and passing them to the [views](views.md). This means that **each route** defined in `index.php` has to be associated to a controller action.

For example, a `/users` request may be handled by the `UserController::index()` method. This method may call the `User::listing()` method of the model `User` to get a list of the users, then process the data and prepare them for presentation and finally pass a `$users` variable to the `user_listing.php` view.

The controllers used in this app are the following:

* [HotelController](#hotelcontroller)
* [ReservationController](#reservationcontroller)
* ...


### HotelController
_Insert here description and specs of the Hotel controller._

### ReservationController
_Insert here description and specs of the Reservation controller._

### ...