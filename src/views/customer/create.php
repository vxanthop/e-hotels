        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Customer</li>
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
                    <form action="/customer/register?success=<?= urlencode('/admin?view=customers') ?>&error=<?= urlencode('/customer/register') ?>" method="POST">
                        <div class="form-group row">
                            <div class="col">
                                <label for="first">First name: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" autofocus class="form-control" maxlength="42" required id="first" name="first" />
                            </div>
                            <div class="col">
                                <label for="last">Last name: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="last" name="last" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="irs">IRS Number: <span class="text-danger" title="This field is required">*</span></label>
                            <input type="number" class="form-control" min="0" max="999999999" required id="irs" name="irs" />
                        </div>
                        <div class="form-group">
                            <label for="ssn">Social Security Number: <span class="text-danger" title="This field is required">*</span></label>
                            <input type="number" class="form-control" min="01010000000" max="31129999999" required id="ssn" name="ssn" />
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="street">Address street: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="street" name="street" />
                            </div>
                            <div class="col">
                                <label for="number">Address number: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="number" class="form-control" min="1" max="9999" required id="number" name="number" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="city">City: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="city" name="city" />
                            </div>
                            <div class="col">
                                <label for="postal">Postal code: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="number" class="form-control" min="10000" max="999999" required id="postal" name="postal_code" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Create" />
                    </form>
                </div>
            </div>            
        </section>
