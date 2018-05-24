        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel-group/<?= $group->id ?>"><?= $group->name ?></a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel/<?= $hotel->id ?>"><?= $hotel->name ?></a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel/<?= $hotel->id ?>/room/<?= $room->room_id ?>">Room #<?= $room->room_id ?></a></li>
                        <li class="breadcrumb-item">Check-in</li>
                        <li class="breadcrumb-item active"><?= !isset($employee) ? 'Search employee' : 'Rent confirmation' ?><?= !isset($employee) && $query ? ': ' . $query['first_name'] . ' ' . $query['last_name'] : '' ?></li>
                    </ol>
                </nav>
                <div class="container-fluid">
                <?php if(!isset($employee)) { ?>
                    <form action="/admin/reserve/check-in" method="GET">
                        <input type="hidden" name="room_id" value="<?= $room->room_id ?>" />
                        <input type="hidden" name="hotel_id" value="<?= $hotel->id ?>" />
                        <input type="hidden" name="start_date" value="<?= $reservation['start_date'] ?>" />
                        <h3 class="text-center mt-5">Search for employee of Hotel <em><?= $hotel->name ?></em>:</h3>
                        <div class="form-group input-group w-50 mx-auto">
                            <input type="search" autofocus class="form-control form-control-lg" name="first_name" value="<?= $query['first_name'] ?? '' ?>" placeholder="First name" />
                            <input type="search" class="form-control form-control-lg" name="last_name" value="<?= $query['last_name'] ?? '' ?>" placeholder="Last name" />
                            <div class="input-group-append">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <table class="table table-striped mt-4">
                        <?php
                            if($employees) {
                        ?>
                            <thead>
                                <th>IRS Number</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Position</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php
                                foreach($employees as $employee) {
                            ?>
                                <tr>
                                    <td><?= $employee->emp_IRS ?></td>
                                    <td><?= $employee->first_name ?></td>
                                    <td><?= $employee->last_name ?></td>
                                    <td><?= $employee->current_job['position'] ?></td>
                                    <td>
                                        <button class="btn btn-secondary" name="employee_irs" value="<?= $employee->emp_IRS ?>">Select</button>
                                    </td>
                                </tr>
                        <?php
                                }
                            } else {
                        ?>
                            <tbody>
                                <tr>
                                    <td>No matches were found for "<?= $query['first_name'] . ' ' . $query['last_name'] ?>".</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                        <?php
                            }
                        ?>
                            </tbody>
                        </table>
                    </form>
                <?php } else { ?>
                    <form action="/admin/reserve/rent?success=<?= urlencode('/customer/' . $reservation['customer']->cust_IRS) ?>&error=<?= urlencode('/reserve/check-in?room_id=' . $room->room_id . '&hotel_id=' . $hotel->id . '&start_date=' . $reservation['start_date'] . '&customer_irs=' . $reservation['customer']->cust_IRS . '&employee_irs=' . $employee->emp_IRS) ?>" method="POST">
                        <input type="hidden" name="room_id" value="<?= $room->room_id ?>" />
                        <input type="hidden" name="hotel_id" value="<?= $hotel->id ?>" />
                        <input type="hidden" name="start_date" value="<?= $reservation['start_date'] ?>" />
                        <input type="hidden" name="customer_irs" value="<?= $reservation['customer']->cust_IRS ?>" />
                        <input type="hidden" name="employee_irs" value="<?= $employee->emp_IRS ?>" />
                        <div class="row">
                            <div class="col col-2 text-center">
                                <img src="/assets/images/blank-user.png" class="img-fluid mb-3" alt="No avatar available">
                                <h4 class="mb-4">
                                    Employee:<br>
                                    <?= $employee->fullname ?>
                                </h4>
                                <h6 class="font-weight-bold mt-3">IRS Number</h6>
                                <?= $employee->emp_IRS ?>
                                <h6 class="font-weight-bold mt-3">Social Security Number</h6>
                                <?= $employee->SSN ?>
                                <h6 class="font-weight-bold mt-3">Address</h6>
                                <?= $employee->address['street'] . ' ' . $employee->address['number'] ?>
                                <h6 class="font-weight-bold mt-3">City</h6>
                                <?= $employee->address['city'] . ', ' . $employee->address['postal_code'] ?>
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
                                <h3 class="text-center">
                                    <a href="/admin/reserve/check-in?room_id=<?= $room->room_id ?>&hotel_id=<?= $hotel->id ?>&start_date=<?= $reservation['start_date'] ?>&customer_irs=<?= $reservation['customer']->cust_IRS ?>&first_name=<?= urlencode($employee->first_name) ?>&last_name=<?= urlencode($employee->last_name) ?>" class="btn btn-secondary mr-2">
                                        <i class="fas fa-chevron-left"></i> Back
                                    </a>
                                    You are about to check-in this reservation:
                                </h3>
                                <div class="card w-50 mx-auto mt-3 text-center">
                                    <img src="<?= $hotel->img_src ?? 'https://via.placeholder.com/400x100' ?>" alt="" class="card-img-top" />
                                    <div class="card-body d-flex flex-column">
                                        <h4 class="card-title text-center mb-2">
                                            <?= $hotel->name ?>
                                            <span class="badge badge-warning">
                                                <?= $hotel->stars ?>
                                                <i class="fas fa-star"></i>
                                            </span>
                                        </h4>
                                        <h6 class="mb-4 text-center">
                                            <i class="fas fa-map-marker"></i>
                                            <?= $hotel->address['city'] ?>
                                        </h6>
                                        <h6>
                                            from <strong><?= $reservation['start_date'] ?></strong>
                                            to <strong><?= $reservation['end_date'] ?></strong>
                                            for <?= number_format($room->price, 2) ?>€
                                        </h6>
                                        <ul class="list-unstyled mt-4 mb-0">
                                            <li><strong>Capacity: <?= $room->capacity ?></strong></li>
                                            <?= ($room->view) ? '<li>View to the sea' : '' ?>
                                            <?= ($room->repairs_need) ? '<li>Needs repairs' : '' ?>
                                        <?php foreach($room->amenities as $amenity) { ?>
                                            <li><?= $amenity ?>
                                        <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="card-footer d-flex flex-column">
                                        <div class="form-group mt-2">
                                            <label>Transaction method</label>
                                            <select class="form-control" name="transaction_method">
                                                <option value="cash">Cash</option>
                                                <option value="debit_card">Debit card</option>
                                                <option value="credit_card">Credit card</option>
                                                <option value="invoice">Invoice</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_amount">Transaction amount</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" min="1.00" max="10000.00" step="0.01" name="transaction_amount" id="transaction_amount" required />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <button class="btn btn-lg btn-success"><i class="fas fa-check-circle"></i> Check-in &amp; Rent</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                </div>
            </div>
        </section>