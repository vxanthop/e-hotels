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
                <a class="btn btn-primary mb-3" href="/admin/room/create/<?= $hotel->id ?>">Add <i class="ml-1 fas fa-plus"></i></a>
                <table class="table table-striped">
                    <thead>
                        <th>Room ID</th>
                        <th>Capacity</th>
                        <th>View to the sea</th>
                        <th>Expandable</th>
                        <th>Needs repairs</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    <?php foreach($rooms as $room) { ?>
                        <tr>
                            <td><?= $room->room_id ?></td>
                            <td><?= $room->capacity == 1 ? "1 bed" : $room->capacity . " beds" ?></td>
                            <td><?= $room->view ? "Yes" : "No" ?></td>
                            <td><?= $room->expandable ?></td>
                            <td><?= $room->repairs_need ? "Yes" : "No" ?></td>
                            <td><?= number_format($room->price, 2) ?>€</td>
                            <td><?= 'Not implemented' /*$room->current_customer ? 'Reserved by ' . $room->current_customer->first_name . ' ' . $room->current_customer->last_name : 'Available'*/ ?></td>
                            <td>
                                <div class="btn-group-vertical">
                                    <a class="btn btn-sm btn-secondary" href="/admin/room/update/<?= $room->room_id ?>">Edit</a>
                                    <a class="btn btn-sm btn-danger" href="/admin/room/delete/<?= $room->room_id ?>?return=<?= urlencode('/admin/hotel/view/' . $hotel->id) ?>">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
