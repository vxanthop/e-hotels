        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel-group/<?= $group->id ?>"><?= $group->name ?></a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel/<?= $hotel->id ?>"><?= $hotel->name ?></a></li>
                        <li class="breadcrumb-item active">Room #<?= $room->room_id ?></li>
                    </ol>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-3">
                            <div class="card text-center">
                                <img src="<?= $hotel->img_src ?? 'https://via.placeholder.com/400x200' ?>" alt="" class="card-img-top" />
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
                                        <strong>Price:</strong> <?= number_format($room->price, 2) ?>€
                                    </h6>
                                    <ul class="list-unstyled mt-4">
                                        <li><strong>Capacity: <?= $room->capacity ?></strong></li>
                                        <?= ($room->view) ? '<li>View to the sea' : '' ?>
                                        <?= ($room->repairs_need) ? '<li>Needs repairs' : '' ?>
                                    <?php foreach($room->amenities as $amenity) { ?>
                                        <li><?= $amenity ?>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-9">
                            <h3>Reservation history</h3>
                            <table class="table table-striped mt-3">
                                <thead>
                                    <th>Customer</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                <?php foreach($room->reservations as $reservation) { ?>
                                    <tr<?= $reservation['start_date'] <= date('Y-m-d') && $reservation['finish_date'] >= date('Y-m-d') ? ' class="table-info"' : '' ?>>
                                        <td><a href="/customer/<?= $reservation['customer']->cust_IRS ?>"><?= $reservation['customer']->first_name . ' ' . $reservation['customer']->last_name ?></a></td>
                                        <td><?= $reservation['start_date'] ?></td>
                                        <td><?= $reservation['finish_date'] ?></td>
                                        <td><?= $reservation['status'] ?></td>
                                        <td>
                                        <?php if(
                                                (is_null($reservation['finish_date'])
                                                    || $reservation['finish_date'] >= date('Y-m-d'))
                                            &&  $reservation['status'] != 'Rented') { ?>
                                            <a class="btn btn-sm btn-secondary" href="/admin/reserve/check-in?room_id=<?= $room->room_id ?>&hotel_id=<?= $hotel->id ?>&start_date=<?= $reservation['start_date'] ?>">Check-in</a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>