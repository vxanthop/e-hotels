        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin?view=customers">Customers</a></li>
                        <li class="breadcrumb-item active"><?= $customer->fullname ?></li>
                    </ol>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-2 text-center">
                            <img src="/assets/images/blank-user.png" class="img-fluid mb-3" alt="No avatar available">
                            <h4 class="mb-4"><?= $customer->fullname ?></h4>
                            <h6 class="font-weight-bold mt-3">IRS Number</h6>
                            <?= $customer->cust_IRS ?>
                            <h6 class="font-weight-bold mt-3">Social Security Number</h6>
                            <?= $customer->SSN ?>
                            <h6 class="font-weight-bold mt-3">Address</h6>
                            <?= $customer->address['street'] . ' ' . $customer->address['number'] ?>
                            <h6 class="font-weight-bold mt-3">City</h6>
                            <?= $customer->address['city'] . ', ' . $customer->address['postal_code'] ?>
                            <h6 class="font-weight-bold mt-3">First registration</h6>
                            <?= $customer->first_registration ?><br>
                            <a class="btn btn-secondary mt-3" href="/admin/customer/update/<?= $customer->cust_IRS ?>">Edit</a>
                        </div>
                        <div class="col col-10">
                            <h3>Reservation history</h3>
                            <table class="table table-striped mt-3">
                                <thead>
                                    <th>Hotel</th>
                                    <th>City</th>
                                    <th>Room</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Transaction</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                <?php foreach($customer->reservations as $reservation) { ?>
                                    <tr<?= $reservation['start_date'] <= date('Y-m-d') && $reservation['finish_date'] >= date('Y-m-d') ? ' class="table-info"' : '' ?>>
                                        <td><a href="/admin/hotel/<?= $reservation['hotel']->id ?>"><?= $reservation['hotel']->name ?></a></td>
                                        <td><?= $reservation['hotel']->address['city'] ?></td>
                                        <td><a href="/admin/hotel/<?= $reservation['hotel']->id ?>/room/<?= $reservation['room_id'] ?>">#<?= $reservation['room_id'] ?></a></td>
                                        <td><?= $reservation['start_date'] ?></td>
                                        <td><?= $reservation['finish_date'] ?></td>
                                        <td>
                                            <?= $reservation['status'] ?>
                                        <?php if($reservation['start_date'] <= date('Y-m-d')) {
                                                if($reservation['finish_date'] <= date('Y-m-d')) {
                                        ?>
                                            (Past)
                                        <?php   }
                                              } else {
                                        ?>
                                            (Future)
                                        <?php } ?>
                                        </td>
                                        <td>
                                        <?php if($reservation['rent_id'] > 0) { ?>
                                            <?= ucfirst($reservation['payment_method']) ?> (<?= number_format($reservation['payment_amount'], 2) ?>€)
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                        </td>
                                        <td>
                                        <?php if(
                                                $reservation['start_date'] <= date('Y-m-d') && $reservation['finish_date'] >= date('Y-m-d')
                                            &&  $reservation['rent_id'] == 0) { ?>
                                            <a class="btn btn-sm btn-secondary" href="/admin/reserve/check-in?room_id=<?= $reservation['room_id'] ?>&hotel_id=<?= $reservation['hotel']->id ?>&start_date=<?= $reservation['start_date'] ?>">Check-in</a>
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