        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Prepare reservation</li>
                        <li class="breadcrumb-item active"><?= !isset($customer) ? 'Search customer' : 'Confirm' ?><?= !isset($customer) && $query ? ': ' . $query['first_name'] . ' ' . $query['last_name'] : '' ?></li>
                    </ol>
                </nav>
                <div class="container-fluid">
                <?php if(!isset($customer)) { ?>
                    <form action="/reserve/prepare" method="GET">
                        <input type="hidden" name="room_id" value="<?= $_GET['room_id'] ?>" />
                        <input type="hidden" name="hotel_id" value="<?= $_GET['hotel_id'] ?>" />
                        <input type="hidden" name="start_date" value="<?= $_GET['start_date'] ?>" />
                        <input type="hidden" name="end_date" value="<?= $_GET['end_date'] ?>" />
                        <h3 class="text-center mt-5">Search for customer:</h3>
                        <div class="form-group input-group w-50 mx-auto">
                            <input type="search" autofocus class="form-control form-control-lg" name="first_name" value="<?= $query['first_name'] ?? '' ?>" placeholder="First name" required />
                            <input type="search" class="form-control form-control-lg" name="last_name" value="<?= $query['last_name'] ?? '' ?>" placeholder="Last name" required />
                            <div class="input-group-append">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <h6 class="text-center">
                            Not listed? <a href="/customer/register?callback=<?= urlencode('/reserve/prepare?room_id=' . $_GET['room_id'] . '&hotel_id=' . $_GET['hotel_id'] . '&start_date=' . $_GET['start_date'] . '&end_date=' . $_GET['end_date']) ?>">Register now</a>.
                        </h6>
                    <?php if($query) { ?>
                        <table class="table table-striped mt-4">
                        <?php
                            if($customers) {
                        ?>
                            <thead>
                                <th>IRS Number</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>First Registration</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                            <?php
                                foreach($customers as $customer) {
                            ?>
                                <tr>
                                    <td><?= $customer->cust_IRS ?></td>
                                    <td><?= $customer->first_name ?></td>
                                    <td><?= $customer->last_name ?></td>
                                    <td><?= $customer->first_registration ?></td>
                                    <td>
                                        <button class="btn btn-secondary" name="irs" value="<?= $customer->cust_IRS ?>">Select</button>
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
                    <?php } ?>
                <?php } else { ?>
                    <form action="/reserve/create?success=<?= urlencode('/customer/' . $customer->cust_IRS) ?>&error=<?= urlencode('/reserve/prepare?room_id=' . $_GET['room_id'] . '&hotel_id=' . $_GET['hotel_id'] . '&start_date=' . $_GET['start_date'] . '&end_date=' . $_GET['end_date'] . '&irs=' . $customer->cust_IRS) ?>" method="POST">
                        <input type="hidden" name="room_id" value="<?= $_GET['room_id'] ?>" />
                        <input type="hidden" name="hotel_id" value="<?= $_GET['hotel_id'] ?>" />
                        <input type="hidden" name="start_date" value="<?= $_GET['start_date'] ?>" />
                        <input type="hidden" name="end_date" value="<?= $_GET['end_date'] ?>" />
                        <input type="hidden" name="irs" value="<?= $customer->cust_IRS ?>" />
                        <div class="row">
                            <div class="col col-2 text-center">
                                <img src="/assets/images/blank-user.png" class="img-fluid mb-3" alt="No avatar available">
                                <h4 class="mb-4"><a href="/customer/<?= $customer->cust_IRS ?>"><?= $customer->fullname ?></a></h4>
                                <h6 class="font-weight-bold mt-3">IRS Number</h6>
                                <?= $customer->cust_IRS ?>
                                <h6 class="font-weight-bold mt-3">Social Security Number</h6>
                                <?= $customer->SSN ?>
                                <h6 class="font-weight-bold mt-3">Address</h6>
                                <?= $customer->address['street'] . ' ' . $customer->address['number'] ?>
                                <h6 class="font-weight-bold mt-3">City</h6>
                                <?= $customer->address['city'] . ', ' . $customer->address['postal_code'] ?>
                                <h6 class="font-weight-bold mt-3">First registration</h6>
                                <?= $customer->first_registration ?>
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
                                    <a href="/reserve/prepare?room_id=<?= $_GET['room_id'] ?>&hotel_id=<?= $_GET['hotel_id'] ?>&start_date=<?= $_GET['start_date'] ?>&end_date=<?= $_GET['end_date'] ?>&first_name=<?= urlencode($customer->first_name) ?>&last_name=<?= urlencode($customer->last_name) ?>" class="btn btn-secondary mr-2">
                                        <i class="fas fa-chevron-left"></i> Back
                                    </a>
                                    You are about to reserve:
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
                                            from <strong><?= $_GET['start_date'] ?></strong>
                                            to <strong><?= $_GET['end_date'] ?></strong>
                                            for <?= number_format($room->price, 2) ?>€
                                        </h6>
                                        <ul class="list-unstyled mt-4">
                                            <li><strong>Capacity: <?= $room->capacity ?></strong></li>
                                            <?= ($room->view) ? '<li>View to the sea' : '' ?>
                                            <?= ($room->repairs_need) ? '<li>Needs repairs' : '' ?>
                                        <?php foreach($room->amenities as $amenity) { ?>
                                            <li><?= $amenity ?>
                                        <?php } ?>
                                            <li><button class="btn btn-lg btn-success mt-4 w-50"><i class="fas fa-check-circle"></i> Confirm</button>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                </div>
            </div>
        </section>