        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update Employee: <?= $employee->first_name . ' ' . $employee->last_name ?></li>
                    </ol>
                </nav>
                <div class="container w-50 mt-5 mx-auto">
                <?php if(isset($errors) && $errors) { ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                        <?php foreach($errors as $error) { ?>
                            <li><?= $error ?></li>
                        <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                    <form action="/admin/employee/update/<?= $employee->emp_IRS ?>?success=<?= urlencode('/admin/employee/' . $employee->emp_IRS) ?>&error=<?= urlencode('/admin/employee/update/<?= $employee->emp_IRS ?>') ?>" method="POST">
                        <div class="form-group row">
                            <div class="col">
                                <label for="first">First name: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" autofocus class="form-control" maxlength="42" required id="first" name="first" value="<?= $employee->first_name ?>" />
                            </div>
                            <div class="col">
                                <label for="last">Last name: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="last" name="last" value="<?= $employee->last_name ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ssn">Social Security Number: <span class="text-danger" title="This field is required">*</span></label>
                            <input type="number" class="form-control" min="01010000000" max="31129999999" required id="ssn" name="ssn" value="<?= sprintf('%09d', $employee->SSN) ?>" />
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="street">Address street: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="street" name="street" value="<?= $employee->address['street'] ?>" />
                            </div>
                            <div class="col">
                                <label for="number">Address number: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="number" class="form-control" min="1" max="9999" required id="number" name="number" value="<?= $employee->address['number'] ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="city">City: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="city" name="city" value="<?= $employee->address['city'] ?>" />
                            </div>
                            <div class="col">
                                <label for="postal">Postal code: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="number" class="form-control" min="10000" max="999999" required id="postal" name="postal_code" value="<?= $employee->address['postal_code'] ?>" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Update" />
                    </form>
                </div>
            </div>            
        </section>
