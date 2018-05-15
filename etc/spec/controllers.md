[< e-hotels](index.md) / src / controllers

# Controllers

Controllers are responsible for handling the requests from the user, fetching the data from the [models](models.md) and passing them to the [views](views.md). This means that **each route** defined in `index.php` has to be associated to a controller action.

For example, a `/users` request may be handled by the `UserController::index()` method. This method may call the `User::listing()` method of the model `User` to get a list of the users, then process the data and prepare them for presentation and finally pass a `$users` variable to the `user_listing.php` view.

The controllers used in this app are the following:

* [reservationController](#reservationcontroller)
* [adminController](#admincontroller)
* [hotelGroupController](#hotelgroupcontroller)
* [hotelController](#hotelcontroller)
* [roomController](#roomcontroller)
* [employeeController](#employeecontroller)
* [customerController](#customercontroller)
* ...

---

### reservationController
Handles all requests regarding the confirmation and the storage of a Reservation of a Hotel Room.

##### Methods:

* `prepare($data)`: `GET /reserve/prepare`  
    `$data` contains the information of the customer IRS number, the (`room_id`, `hotel_id`) key pair that identifies the room to be reserved, the start date and the end date of the reservation.
    The method is responsible to confirm that the customer is already registered, otherwise it should redirect him to the user registration page. Also, confirmation is needed that the room exists and is available for the designated period, otherwise the user should be redirected to an error page.
    If both prerequisites are met, the controller should display a page where the room information, the user's data, the reservation dates and a confirmation button are presented. If the user clicks the confirmation button, he should be redirected to `/reserve/create`
* `createSubmit($data)`: `POST /reserve/create`  
    `$data` is the same as above. The method needs to call the appropriate Model methods to store the Registration in the database. Upon completion, the user will be redirected to `/reservation/$room_id/$start_date`.
* `view($room_id, $start_date)`: `GET /reservation/$room_id/$start_date`  
    Finds the reservation that is identified by `($room_id, $start_date)` and displays its information to the user.

---

### adminController
Presents the admin interface that allows the inspection, the creation, the update and the removal of Customers, Employees, Hotels, Hotel Groups or Rooms.

##### Methods:

* `index()`: `/admin`

---

### hotelGroupController

##### Methods:

* `create()`: `GET /admin/hotel-group/create`  
    Creation form.
* `createSubmit($vars)`: `POST /admin/hotel-group/create`  
    Creates a new Hotel Group. Redirects to `/admin` on success and to `/admin/hotel-group/create` on failure.
* `update($hotel_group_id)`: `GET /admin/hotel-group/update/$hotel_group_id`  
    Update form.
* `updateSubmit($vars)`: `POST /admin/hotel-group/update/$hotel_group_id`  
    Updates the Hotel Group with id `$hotel_group_id`. Redirects to `/admin` on success and to `/admin/hotel-group/update/$hotel_group_id` on failure.
* `delete($hotel_group_id)`: `GET /admin/hotel-group/delete/$hotel_group_id`  
    Deletes the Hotel Group with id `$hotel_group_id`. Redirects to `/admin` both on success and failure.
* `view($hotel_group_id)`: `GET /admin/hotel-group/$hotel_group_id`  
    Displays information about the Hotel Group with id `$hotel_group_id`, ie. a list of its hotels.

---

### hotelController

##### Methods:

* `create($hotel_group_id)`: `GET /admin/hotel/create/$hotel_group_id`  
    Creation form.
* `createSubmit($vars)`: `POST /admin/hotel/create/$hotel_group_id`  
    Creates a new Hotel for the Hotel Group with id `$hotel_group_id`. Redirects to `/admin/hotel-group/$hotel_group_id` on success and to `/admin/hotel/create/$hotel_group_id` on failure.
* `update($hotel_id)`: `GET /admin/hotel/update/$hotel_id`  
    Update form.
* `updateSubmit($vars)`: `POST /admin/hotel/update/$hotel_id`  
    Updates the Hotel with id `$hotel_id`. Redirects to `/admin/hotel-group/($hotel->hotel_group_id)` on success and to `/admin/hotel/update/$hotel_id` on failure.
* `delete($hotel_id)`: `GET /admin/hotel/delete/$hotel_id`  
    Deletes the Hotel with id `$hotel_id`. Redirects to `/admin/hotel-group/($hotel->hotel_group_id)` both on success and failure.
* `view($hotel_id)`: `GET /admin/hotel/$hotel_id`  
    Displays information about the Hotel with id `$hotel_id`, ie. a list of its rooms and the employees that work at it.

---

### roomController

##### Methods:

* `create($hotel_id)`: `GET /admin/room/create/$hotel_id`  
    Creation form.
* `createSubmit($vars)`: `POST /admin/room/create/$hotel_id`  
    Creates a new Room for the Hotel with id `$hotel_id`. Redirects to `/admin/hotel/$hotel_id` on success and to `/admin/room/create/$hotel_id` on failure.
* `update($room_id)`: `GET /admin/room/update/$room_id`  
    Update form.
* `updateSubmit($vars)`: `POST /admin/room/update/$room_id`  
    Updates the room with room ID `$room_id`. Redirects to `/admin/hotel/($room->hotel_id)` on success and to `/admin/room/update/$room_id` on failure.
* `delete($room_id)`: `GET /admin/room/delete/$room_id`  
    Deletes the room with room ID `$room_id`. Redirects to `/admin/hotel/($room->hotel_id)` both on success and failure.
* `view($room_id)`: `GET /admin/room/$room_id`  
    Displays information about the Room with id `$room_id`, ie. a description of the room, a list of past reservations and information about the current reservation, if one exists.

---

### employeeController

##### Methods:

* `create()`: `GET /admin/employee/create`  
    Creation form for employees that won't be assigned to any Hotel initially.
* `create($hotel_id)`: `GET /admin/employee/create/$hotel_id`  
    Creation form for employees that will initially be assigned to the Hotel with id `$hotel_id`.
* `createSubmit($vars)`: `POST /admin/employee/create`  
    Creates an employee that initially won't be assigned to any Hotel. Redirects to `/admin/employee/$irs` on success and to `/admin/employee/create` on failure.
* `createSubmit($vars)`: `POST /admin/employee/create/$hotel_id`  
    Creates an employee that will initially be assigned to the Hotel with id `$hotel_id`. Redirects to `/admin/hotel/$hotel_id#employees` on success and to `/admin/employee/create/$hotel_id` on failure.
* `update($irs)`: `GET /admin/employee/update/$irs`  
    Update form.
* `updateSubmit($vars)`: `POST /admin/employee/update/$irs`  
    Updates the employee with IRS `$irs`. Redirects to `/admin/employee/$irs` on success and to `/admin/employee/update/$irs` on failure.
* `delete($irs)`: `GET /admin/employee/delete/$irs`  
    Deletes the employee with IRS `$irs`. Redirects to `/admin/#employees` both on success and failure.
* `view($irs)`: `GET /admin/employee/$irs`  
    Displays information about the employee with IRS `$irs`, ie. properties, current and past jobs.

---

### customerController
Handles all requests regarding the registration, the update and the removal of users.

##### Methods:

* `register($irs = NULL)`: `GET /customer/register`  
    * If `$irs` is provided, the method checks if customer with `$irs` as IRS number exists. If so, the user is redirected to an error page. If not, it displays a form which enables the creation of a customer by filling the required fields.
    * If no `$irs` is provided, then the same form is displayed with an extra field for the IRS number.
    * Submission of the form should be directed to `/customer/create` with method `POST`.
* `registerSubmit($data)`: `POST /customer/register`  
    Validates `$data` and passes them to the necessary model methods in order to create a new customer entry in the database. On success, the user should be redirected to `/admin/customer/$irs`. On failure, the user should be redirected to an error page.
* `update($irs)`: `GET /admin/customer/update/$irs`  
    Presents a form with all possible fields of a [Customer](models.md#customer) model that are pre-filled with the information of the customer with `$irs` as IRS number. The values of the fields are editable and the form is submitted to `/admin/customer/updateSubmit/$irs`. There is also a delete button that redirects to `/admin/customer/delete/$irs`.
* `updateSubmit($irs, $data)`: `POST /admin/customer/update/$irs`  
    Validates `$data` and passes them to the necessary model methods in order to update the customer with `$irs` as IRS number. On success, the user should be redirected to `/customer/view/$irs`. On failure, the user should be redirected to an error page.
* `delete($irs)`: `GET /admin/customer/delete/$irs`  
    Simple page that presents some basic customer information (first and last name) and asks for delete confirmation. The confirmation link leads to `/admin/customer/deleteSubmit/$irs`.
* `deleteSubmit($irs)`: `POST /admin/customer/delete/$irs`  
    Removes the customer with `$irs` as IRS number and redirects to `/admin`.
* `view($irs)`: `/admin/customer/$irs`  
    Presents a view with the information of the customer with `$irs` as IRS number.

---

### ...