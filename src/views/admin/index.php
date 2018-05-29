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
                <?php
                    $tabs = ['groups' => 'Hotel Groups', 'employees' => 'Employees', 'customers' => 'Customers'];
                    foreach($tabs as $id => $title) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link<?= $view == $id ? ' active' : '' ?>" data-toggle="tab" href="#<?= $id ?>"><?= $title ?></a>
                    </li>
                <?php } ?>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane<?= $view == 'groups' ? ' show active' : '' ?>" id="groups">
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
                    <div class="tab-pane<?= $view == 'employees' ? ' show active' : '' ?>" id="employees">
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
                                    <td><?= $employee->fullname ?></td>
                                    <td><?= $employee->address['street'] . ' ' . $employee->address['number'] ?></td>
                                    <td><?= $employee->address['city'] . ', ' . $employee->address['postal_code'] ?></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-secondary" href="/admin/employee/<?= $employee->emp_IRS ?>">Manage</a>
                                            <a class="btn btn-sm btn-secondary" href="/admin/employee/update/<?= $employee->emp_IRS ?>">Edit info</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane<?= $view == 'customers' ? ' show active' : '' ?>" id="customers">
                        <a class="btn btn-primary mb-3" href="/customer/register">Add <i class="ml-1 fas fa-plus"></i></a>
                        <table class="table table-striped">
                            <thead>
                                <th>IRS</th>
                                <th>Full name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>First Registration</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php foreach($customers as $customer) { ?>
                                <tr>
                                    <td><?= $customer->cust_IRS ?></td>
                                    <td><?= $customer->fullname ?></td>
                                    <td><?= $customer->address['street'] . ' ' . $customer->address['number'] ?></td>
                                    <td><?= $customer->address['city'] . ', ' . $customer->address['postal_code'] ?></td>
                                    <td><?= $customer->first_registration ?></td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-secondary" href="/customer/<?= $customer->cust_IRS ?>">View</a>
                                            <a class="btn btn-sm btn-secondary" href="/admin/customer/update/<?= $customer->cust_IRS ?>">Edit</a>
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