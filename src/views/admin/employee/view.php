        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin?view=employees">Employees</a></li>
                        <li class="breadcrumb-item active"><?= $employee->fullname ?></li>
                    </ol>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-2 text-center">
                            <img src="/assets/images/blank-user.png" class="img-fluid mb-3" alt="No avatar available">
                            <h4 class="mb-4"><?= $employee->fullname ?></h4>
                            <h6 class="font-weight-bold mt-3">IRS Number</h6>
                            <?= $employee->emp_IRS ?>
                            <h6 class="font-weight-bold mt-3">Social Security Number</h6>
                            <?= $employee->SSN ?>
                            <h6 class="font-weight-bold mt-3">Address</h6>
                            <?= $employee->address['street'] . ' ' . $employee->address['number'] ?>
                            <h6 class="font-weight-bold mt-3">City</h6>
                            <?= $employee->address['city'] . ', ' . $employee->address['postal_code'] ?><br>
                            <a class="btn btn-secondary mt-3" href="/admin/employee/update/<?= $employee->emp_IRS ?>">Edit</a>
                        </div>
                        <div class="col col-10">
                        <?php if(isset($errors) && $errors) { ?>
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                <?php foreach($errors as $error) { ?>
                                    <li><?= $error ?></li>
                                <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                            <h3>
                                Employment history
                            <?php if(!$employee->current_job) { ?>
                                <a class="btn btn-primary ml-2" href="/admin/employee/move/<?= $employee->emp_IRS ?>">Assign <i class="ml-1 fas fa-plus"></i></a>
                            <?php } ?>
                            </h3>
                            <table class="table table-striped mt-3">
                                <thead>
                                    <th>Hotel</th>
                                    <th>City</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                <?php if($employee->current_job) { ?>
                                    <th>Actions</th>
                                <?php } ?>
                                </thead>
                                <tbody>
                                <?php foreach($employee->jobs as $job) { ?>
                                    <tr<?= $job['status'] == 'Current job' ? ' class="table-info"' : '' ?>>
                                        <td><a href="/admin/hotel/<?= $job['hotel']->id ?>"><?= $job['hotel']->name ?></a></td>
                                        <td><?= $job['hotel']->address['city'] ?></td>
                                        <td><?= $job['start_date'] ?></td>
                                        <td><?= $job['finish_date'] ?></td>
                                        <td><?= $job['position'] ?></td>
                                        <td><?= $job['status'] ?></td>
                                    <?php if($employee->current_job) { ?>
                                        <td>
                                        <?php if($job['start_date'] < date('Y-m-d') && $job['finish_date'] >= date('Y-m-d')) { ?>
                                            <div class="btn-group-vertical">
                                                <a class="btn btn-sm btn-secondary" href="/admin/employee/move/<?= $employee->emp_IRS ?>">Move</a>
                                                <a class="btn btn-sm btn-danger" href="/admin/employee/quit/<?= $employee->emp_IRS ?>?success=<?= urlencode('/admin/employee/' . $employee->emp_IRS) ?>&error=<?= urlencode('/admin/employee/' . $employee->emp_IRS) ?>">Quit</a>
                                            </div>
                                        <?php } ?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>