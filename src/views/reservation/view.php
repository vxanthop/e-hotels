        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel-group/<?= $group->id ?>"><?= $group->name ?></a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel/<?= $hotel->id ?>"><?= $hotel->name ?></a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel/<?= $hotel->id ?>/room/<?= $room->room_id ?>">Room #<?= $room->room_id ?></a></li>
                        <li class="breadcrumb-item active">Reservation: <?= $reservation['start_date'] ?></li>
                    </ol>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-2 text-center">
                            <img src="/assets/images/blank-user.png" class="img-fluid mb-3" alt="No avatar available">
                            <h4 class="mb-4">
                                Customer:<br>
                                <?= $reservation['customer']->fullname ?>
                            </h4>
                            <h6 class="font-weight-bold mt-3">IRS Number</h6>
                            <?= $reservation['customer']->cust_IRS ?>
                            <h6 class="font-weight-bold mt-3">Social Security Number</h6>
                            <?= $reservation['customer']->SSN ?>
                            <h6 class="font-weight-bold mt-3">Address</h6>
                            <?= $reservation['customer']->address['street'] . ' ' . $reservation['customer']->address['number'] ?>
                            <h6 class="font-weight-bold mt-3">City</h6>
                            <?= $reservation['customer']->address['city'] . ', ' . $reservation['customer']->address['postal_code'] ?>
                            <h6 class="font-weight-bold mt-3">First registration</h6>
                            <?= $reservation['customer']->first_registration ?>
                        </div>
                        <div class="col col-10">
                            <div class="card w-50 mx-auto mt-3 text-center">
                                <img src="<?= 'https://via.placeholder.com/400x100' ?>" alt="" class="card-img-top" />
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title mb-2">
                                        <?= $hotel->name ?>
                                        <span class="badge badge-warning">
                                            <?= $hotel->stars ?>
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </h4>
                                    <h6 class="mb-4">
                                        <i class="fas fa-map-marker"></i>
                                        <?= $hotel->address['city'] ?>
                                    </h6>
                                    <h6 class="mb-4">
                                        <?= $reservation['status'] ?> by <strong><?= $reservation['customer']->fullname ?></strong>
                                        from <strong><?= $reservation['start_date'] ?></strong>
                                        to <strong><?= $reservation['finish_date'] ?></strong>
                                        for <?= number_format($room->price * $reservation['date_diff'], 2, '.', '') ?>€
                                    </h6>
                                <?php if($reservation['rent_id'] > 0) { ?>
                                    <h6 class="mb-4">
                                        Employee: <a href="/admin/employee/<?= $reservation['employee']->emp_IRS ?>"><?= $reservation['employee']->fullname ?></a>
                                    </h6>
                                <?php } ?>
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Capacity: <?= $room->capacity ?></strong></li>
                                        <?= ($room->view) ? '<li>View to the sea' : '' ?>
                                        <?= ($room->repairs_need) ? '<li>Needs repairs' : '' ?>
                                    <?php foreach($room->amenities as $amenity) { ?>
                                        <li><?= $amenity ?>
                                    <?php } ?>
                                    </ul>
                                </div>
                            <?php if($reservation['rent_id'] > 0) { ?>
                                <div class="card-footer d-flex flex-column py-3">
                                    <h6 class="font-weight-bold">Transaction method</h6>
                                    <?= $reservation['payment_method'] ?>
                                    <h6 class="font-weight-bold mt-3">Transaction amount</h6>
                                    <?= number_format($reservation['payment_amount'], 2, '.', '') ?>€
                                </div>
                            <?php } else if(is_null($reservation['finish_date']) || $reservation['finish_date'] >= date('Y-m-d')) { ?>
                                <div class="card-footer d-flex flex-column">
                                    <a class="btn btn-sm btn-warning" href="/admin/reserve/check-in?room_id=<?= $room->room_id ?>&hotel_id=<?= $hotel->id ?>&start_date=<?= $reservation['start_date'] ?>">Check-in</a>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>