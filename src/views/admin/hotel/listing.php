        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hotel Group: <?= $group->name ?></li>
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
                <a class="btn btn-primary mb-3" href="/admin/hotel/create/<?= $group->id ?>">Add <i class="ml-1 fas fa-plus"></i></a>
                <table class="table table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Category</th>
                        <th>#rooms</th>
                        <th>Phone numbers</th>
                        <th>Email addresses</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    <?php foreach($hotels as $hotel) { ?>
                        <tr>
                            <td><?= $hotel->name ?></td>
                            <td><?= $hotel->address['street'] . ' ' . $hotel->address['number'] ?></td>
                            <td><?= $hotel->address['city'] . ', ' . $hotel->address['postal_code'] ?></td>
                            <td><?= $hotel->stars ?> <i class="fas fa-star"></i></td>
                            <td><?= $hotel->number_of_rooms ?></td>
                            <td>
                            <?php foreach($hotel->phone_numbers as $phone) { ?>
                                <?= $phone ?><br>
                            <?php } ?>
                            </td>
                            <td>
                            <?php foreach($hotel->email_addresses as $email) { ?>
                                <?= $email ?><br>
                            <?php } ?>
                            </td>
                            <td>
                                <div class="btn-group-vertical">
                                    <a class="btn btn-sm btn-secondary" href="/admin/hotel/<?= $hotel->id ?>">View rooms</a>
                                    <a class="btn btn-sm btn-secondary" href="/admin/hotel/update/<?= $hotel->id ?>">Edit</a>
                                    <a class="btn btn-sm btn-danger" href="/admin/hotel/delete/<?= $hotel->id ?>?return=<?= urlencode('/admin/hotel-group/' . $group->id) ?>">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
