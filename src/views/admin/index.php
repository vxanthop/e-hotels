        <section class="general admin">
            <div class="container">
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
                        <a class="nav-link active" data-toggle="tab" href="#groups">Hotel Groups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#customers">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#employees">Employees</a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane show active" id="groups">
                        <a class="btn btn-primary mb-3" href="/admin/hotel-group/create">Add <i class="ml-1 fas fa-plus"></i></a>
                        <table class="table table-striped">
                            <thead>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>#hotels</th>
                                <th>Phone numbers</th>
                                <th>Email addresses</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php foreach($hotel_groups as $hotel_group) { ?>
                                <tr>
                                    <td><?= $hotel_group->name ?></td>
                                    <td><?= $hotel_group->address['street'] . ' ' . $hotel_group->address['number'] ?></td>
                                    <td><?= $hotel_group->address['city'] . ', ' . $hotel_group->address['postal_code'] ?></td>
                                    <td><?= $hotel_group->number_of_hotels ?></td>
                                    <td>
                                    <?php foreach($hotel_group->phone_numbers as $phone) { ?>
                                        <?= $phone ?><br>
                                    <?php } ?>
                                    </td>
                                    <td>
                                    <?php foreach($hotel_group->email_addresses as $email) { ?>
                                        <?= $email ?><br>
                                    <?php } ?>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-secondary" href="/admin/hotel-group/<?= $hotel_group->id ?>">View hotels</a>
                                            <a class="btn btn-sm btn-secondary" href="/admin/hotel-group/update/<?= $hotel_group->id ?>">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="/admin/hotel-group/delete/<?= $hotel_group->id ?>?success=<?= urlencode('/admin') ?>&error=<?= urlencode('/admin') ?>">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="customers">
                        Customers
                    </div>
                    <div class="tab-pane" id="employees">
                        <a class="btn btn-primary mb-3" href="/admin/employee/create">Add <i class="ml-1 fas fa-plus"></i></a>
                        <table class="table table-striped">
                            <thead>
                                <th>IRS</th>
                                <th>Full name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php foreach($employees as $employee) { ?>
                                <tr>
                                    <td><?= $employee->emp_IRS ?></td>
                                    <td><?= $employee->last_name . ', ' . $employee->first_name ?></td>
                                    <td><?= $employee->address['street'] . ' ' . $employee->address['number'] ?></td>
                                    <td><?= $employee->address['city'] . ', ' . $employee->address['postal_code'] ?></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-secondary" href="/admin/employee/update/<?= $employee->emp_IRS ?>">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="/admin/employee/delete/<?= $employee->emp_IRS ?>?success=<?= urlencode('/admin#employees') ?>&error=<?= urlencode('/admin#employees') ?>">Delete</a>
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
