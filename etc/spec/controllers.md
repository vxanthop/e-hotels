[< e-hotels](index.md) / src / controllers

# Controllers

Controllers are responsible for handling the requests from the user, fetching the data from the [models](models.md) and passing them to the [views](views.md). This means that **each route** defined in `index.php` has to be associated to a controller action.

For example, a `/users` request may be handled by the `UserController::index()` method. This method may call the `User::listing()` method of the model `User` to get a list of the users, then process the data and prepare them for presentation and finally pass a `$users` variable to the `user_listing.php` view.

The controllers used in this app are the following:

* [ReservationController](#reservationcontroller)
* [CustomerController](#customercontroller)
* ...


### ReservationController
Handles all requests regarding the confirmation and the storage of a Reservation of a Hotel Room.

#### Methods

* `prepare($data)`: `/reserve/prepare`  
    `$data` contains the information of the customer IRS number, the (`room_id`, `hotel_id`) key pair that identifies the room to be reserved, the start date and the end date of the reservation.
    The method is responsible to confirm that the customer is already registered, otherwise it should redirect him to the user registration page. Also, confirmation is needed that the room exists and is available for the designated period, otherwise the user should be redirected to an error page.
    If both prerequisites are met, the controller should display a page where the room information, the user's data, the reservation dates and a confirmation button are presented. If the user clicks the confirmation button, he should be redirected to `/reserve/create`
* `createSubmit($data)`: `/reserve/create`  
    `$data` is the same as above. The method needs to call the appropriate Model methods to store the Registration in the database. Upon completion, the user will be redirected to `/reserve/view/$`
* `view($)`: `/reserve/view/$`  
    Finds the reservation that is identified by `$` and displays its information to the user.


### CustomerController
Handles all requests regarding the registration, the update and the removal of users.

#### Methods

* `register($irs = NULL)`: `/customer/register`  
    If `$irs` is provided, the method checks if customer with IRS = `$irs` exists. If so, the user is redirected to an error page. If not, it displays a form which enables the creation of a customer by filling the required fields. If no `$irs` is provided, then the same form is displayed with an extra field for the IRS number. Submission of the form should redirect the user to `/customer/create`.
* `registerSubmit($data)`: `/customer/registerSubmit`  
    Validates `$data` and passes them to the necessary model methods in order to create a new customer entry in the database. On success, the user should be redirected to `/customer/view/$irs`. On failure, the user should be redirected to an error page.
* `view($irs)`: `/customer/view/$irs`  
    Presents a view with the information of the customer with `$irs` as IRS number.
* `update($irs)`: `/admin/customer/update/$irs`  
    Presents a form with all possible fields of a [Customer](models.md#customer) model that are pre-filled with the information of the customer with `$irs` as IRS number. The values of the fields are editable and the form is submitted to `/admin/customer/updateSubmit/$irs`. There is also a delete button that redirects to `/admin/customer/delete/$irs`.
* `updateSubmit($irs, $data)`: `/admin/customer/updateSubmit/$irs`  
    Validates `$data` and passes them to the necessary model methods in order to update the customer with `$irs` as IRS number. On success, the user should be redirected to `/customer/view/$irs`. On failure, the user should be redirected to an error page.
* `delete($irs)`: `/admin/customer/delete/$irs`  
    Simple page that presents some basic customer information (first and last name) and asks for delete confirmation. The confirmation link leads to `/admin/customer/deleteSubmit/$irs`.
* `deleteSubmit($irs)`: `/admin/customer/deleteSubmit/$irs`  
    Removes the customer with `$irs` as IRS number and redirects to `/admin`.


### ...