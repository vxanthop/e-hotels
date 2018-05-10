[< e-hotels](index.md) / src / controllers

# Controllers

Controllers are responsible for handling the requests from the user, fetching the data from the [models](models.md) and passing them to the [views](views.md). This means that **each route** defined in `index.php` has to be associated to a controller action.

For example, a `/users` request may be handled by the `UserController::index()` method. This method may call the `User::listing()` method of the model `User` to get a list of the users, then process the data and prepare them for presentation and finally pass a `$users` variable to the `user_listing.php` view.

The controllers used in this app are the following:

* [ReservationController](#reservationcontroller)
* ...


### ReservationController
Handles all requests regarding the confirmation and the storage of a Reservation of a Hotel Room.

#### Methods

* `prepare($data)`: `/reserve/prepare`
    `$data` contains the information of the customer IRS number, the (`room_id`, `hotel_id`) key pair that identifies the room to be reserved, the start date and the end date of the reservation.
    The method is responsible to confirm that the customer is already registered, otherwise it should redirect him to the user registration page. Also, confirmation is needed that the room exists and is available for the designated period, otherwise the user should be redirected to an error page.
    If both prerequisites are met, the controller should display a page where the room information, the user's data, the reservation dates and a confirmation button are presented. If the user clicks the confirmation button, he should be redirected to the `create` method's URL.
* `create($data)`: `/reserve/create`
    `$data` is the same as above. The method needs to call the appropriate Model methods to store the Registration in the database. Upon completion, the user will be redirected to the `view` method's URL.
* `view($)`: `/reserve/view/$`
    Finds the reservation that is identified by `$` and displays its information to the user.

### ...