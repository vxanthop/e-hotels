        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel-group/<?= $group->id ?>"><?= $group->name ?></a></li>
                        <li class="breadcrumb-item active">Hotel: <?= $hotel->name ?></li>
                    </ol>
                </nav>
            <?php if(isset($errors) && $errors) { ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                    <?php foreach($errors as $error) { ?>
                        <li><?= $error ?></li>
                    <?php } ?>
                    </ul>
                </div>
            <?php } ?>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#employees">Employees</a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane show active" id="rooms">
                        <a class="btn btn-primary mb-3" href="/admin/room/create/<?= $hotel->id ?>">Add <i class="ml-1 fas fa-plus"></i></a>
                        <table class="table table-striped">
                            <thead>
                                <th>Room ID</th>
                                <th>Capacity</th>
                                <th>View to the sea</th>
                                <th>Expandable</th>
                                <th>Needs repairs</th>
                                <th>Price</th>
                                <th>Amenities</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php foreach($rooms as $room) { ?>
                                <tr>
                                    <td><?= $room->room_id ?></td>
                                    <td><?= $room->capacity == 1 ? "1 bed" : $room->capacity . " beds" ?></td>
                                    <td><?= $room->view ? "Yes" : "No" ?></td>
                                    <td><?= $room->expandable_description ?></td>
                                    <td><?= $room->repairs_need ? "Yes" : "No" ?></td>
                                    <td><?= number_format($room->price, 2) ?>€</td>
                                    <td>
                                        <ul class="list-unstyled text-center">
                                        <?php foreach($room->amenities as $amenity) { ?>
                                            <li><?= $amenity->amenity ?></li>
                                        <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?= 'Not implemented' /*$room->current_customer ? 'Reserved by ' . $room->current_customer->first_name . ' ' . $room->current_customer->last_name : 'Available'*/ ?></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-secondary" href="/admin/room/update/<?= $room->room_id ?>">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="/admin/room/delete/<?= $room->room_id ?>?success=<?= urlencode('/admin/hotel/' . $hotel->id) ?>&error=<?= urlencode('/admin/hotel/' . $hotel->id) ?>">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="employees">
                        <a class="btn btn-primary mb-3" href="/admin/employee/create/<?= $hotel->id ?>">Add <i class="ml-1 fas fa-plus"></i></a>
                        <table class="table table-striped">
                            <thead>
                                <th>IRS</th>
                                <th>Full name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Position</th>
                                <th>Start date</th>
                                <th>Finish date</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php foreach($employees as $employee) { ?>
                                <tr>
                                    <td><?= $employee->emp_IRS ?></td>
                                    <td><?= $employee->last_name . ', ' . $employee->first_name ?></td>
                                    <td><?= $employee->address['street'] . ' ' . $employee->address['number'] ?></td>
                                    <td><?= $employee->address['city'] . ', ' . $employee->address['postal_code'] ?></td>
                                    <td><?= $employee->current_job['position'] ?></td>
                                    <td><?= $employee->current_job['start_date'] ?></td>
                                    <td><?= $employee->current_job['finish_date'] ?? '-' ?></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-secondary" href="/admin/employee/update/<?= $employee->emp_IRS ?>">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="/admin/employee/delete/<?= $employee->emp_IRS ?>?success=<?= urlencode('/admin/hotel/' . $hotel->id) . '#employees' ?>&error=<?= urlencode('/admin/hotel/' . $hotel->id . '#employees') ?>">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
