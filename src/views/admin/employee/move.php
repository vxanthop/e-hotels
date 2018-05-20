        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin?view=employees">Employees</a></li>
                        <li class="breadcrumb-item"><a href="/admin/employee/<?= $employee->emp_IRS ?>"><?= $employee->fullname ?></a></li>
                    <?php
                        if(isset($groups)) {
                    ?>
                        <li class="breadcrumb-item active">Move</li>
                    <?php
                        } else {
                    ?>
                        <li class="breadcrumb-item active">Move to Hotel Group: <?= $group->name ?></li>
                    <?php
                        }
                    ?>
                    </ol>
                </nav>
                <div class="container-fluid mt-4">
                    <div class="row">
                        <div class="col col-2 text-center">
                            <img src="/assets/images/blank-user.png" class="img-fluid mb-3" alt="No avatar available">
                            <h3 class="mb-4"><?= $employee->fullname ?></h3>
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
                        <?php if($employee->current_job) { ?>
                            <div class="alert alert-warning">
                                This Employee currently has a job until <strong><?= $employee->current_job['finish_date'] ?></strong>. If you proceed, the job will be terminated with finish date "<?= date('Y-m-d', strtotime('-1 day')) ?>", so that they will be able to be assigned a new job.
                            </div>
                        <?php } ?>
                        <?php
                            if(isset($groups)) {
                        ?>
                            <h3 class="mb-4">Choose Hotel Group:</h3>
                            <div class="container-fluid">
                                <div class="row">
                                <?php
                                    $chunk_size = ceil(count($groups) / 2);
                                    foreach(array_chunk($groups, $chunk_size) as $chunk) {
                                ?>
                                    <div class="col col-6">
                                        <div class="list-group">
                                        <?php foreach($chunk as $group) { ?>
                                            <a href="/admin/employee/move/<?= $employee->emp_IRS ?>?hotel_group_id=<?= $group->id ?>" class="list-group-item list-group-item-action"><?= $group->name ?></a>
                                        <?php } ?>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                                </div>
                            </div>
                        <?php
                            } else {
                        ?>
                            <a href="/admin/employee/move/<?= $employee->emp_IRS ?>" class="btn btn-secondary mb-4"><i class="fas fa-chevron-left"></i> Back to hotel group selection</a>
                            <form action="/admin/employee/move/<?= $employee->emp_IRS ?>?success=<?= urlencode('/admin/employee/' . $employee->emp_IRS) ?>&error=<?= urlencode('/admin/employee/move/' . $employee->emp_IRS . '?hotel_group_id=' . $group->id) ?>" method="POST">
                            <?php if(isset($errors) && $errors) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                    <?php foreach($errors as $error) { ?>
                                        <li><?= $error ?></li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                                <div class="form-group">
                                    <label>Choose Hotel from <?= $group->name ?></label>
                                    <select class="form-control" name="hotel_id">
                                    <?php foreach($hotels as $hotel) { ?>
                                        <option value="<?= $hotel->id ?>"><?= $hotel->name ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col col-4">
                                        <label for="start-date">Start date</label>
                                        <input type="text" id="start-date" class="form-control" name="start_date" value="<?= date('Y-m-d') ?>" readonly />
                                    </div>
                                    <div class="col col-4">
                                        <label for="datepicker">Finish date</label>
                                        <input type="text" id="datepicker" class="form-control" name="finish_date" required />
                                    </div>
                                    <div class="col col-4">
                                        <label for="position">Position</label>
                                        <input type="position" id="position" class="form-control" name="position" required />
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <input type="submit" class="btn btn-lg btn-primary mt-4" value="Move" />
                                </div>
                            </form>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
    ob_start();
?>
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script>
    $().ready(function(){
        $("#datepicker").datepicker({
            format: "yyyy-mm-dd",
            startDate: "<?= date('Y-m-d') ?>",
            maxViewMode: 2,
            startView: 1,
            todayHighlight: true
        });
    })
    </script>
<?php
    $block['scripts'] = ob_get_clean();
    $block['stylesheets'] = array_merge($block['stylesheets'], [
        '/assets/css/bootstrap-datepicker3.min.css',
    ]);