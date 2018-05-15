        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel-group/<?= $group->id ?>"><?= $group->name ?></a></li>
                        <li class="breadcrumb-item active">Update Hotel: <?= $hotel->name ?></li>
                    </ol>
                </nav>
                <div class="container w-50 mt-5 mx-auto">
                    <form action="/admin/hotel/update/<?= $hotel->id ?>?return=<?= urlencode('/admin/hotel/update/' . $hotel->id) ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Hotel name: <span class="text-danger" title="This field is required">*</span></label>
                            <input type="text" autofocus class="form-control" maxlength="42" required id="name" name="name" value="<?= $hotel->name ?>" />
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="street">Address street: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="street" name="street" value="<?= $hotel->address['street'] ?>" />
                            </div>
                            <div class="col">
                                <label for="number">Address number: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="number" class="form-control" min="1" max="9999" required id="number" name="number" value="<?= $hotel->address['number'] ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label for="city">City: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="text" class="form-control" maxlength="42" required id="city" name="city" value="<?= $hotel->address['city'] ?>" />
                            </div>
                            <div class="col">
                                <label for="postal">Postal code: <span class="text-danger" title="This field is required">*</span></label>
                                <input type="number" class="form-control" min="10000" max="999999" required id="postal" name="postal_code" value="<?= $hotel->address['postal_code'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <select name="stars" class="form-control">
                            <?php for($i = 1; $i <= 5; ++$i) { ?>
                                <option value="<?= $i ?>" <?= ($hotel->stars == $i) ? "selected" : "" ?>><?= $i ?> stars</option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group phones">
                            <label>Phone numbers:</label>
                        <?php foreach($hotel->phone_numbers as $phone) { ?>
                            <div class="input-group phone">
                                <input type="number" class="form-control" min="2100000000" max="6999999999" name="phones[]" value="<?= $phone ?>" />
                                <div class="input-group-append">
                                    <button class="remove-input btn btn-secondary"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        <?php } ?>
                            <div class="input-group phone">
                                <input type="number" class="form-control" min="2100000000" max="6999999999" name="phones[]" />
                                <div class="input-group-append">
                                    <button class="add-input btn btn-primary"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group emails">
                            <label>Email addresses:</label>
                        <?php foreach($hotel->email_addresses as $email) { ?>
                            <div class="input-group email">
                                <input type="email" class="form-control" name="emails[]" value="<?= $email ?>" />
                                <div class="input-group-append">
                                    <button class="remove-input btn btn-secondary"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        <?php } ?>
                            <div class="input-group email">
                                <input type="email" class="form-control" name="emails[]" />
                                <div class="input-group-append">
                                    <button class="add-input btn btn-primary"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Update" />
                    </form>
                </div>
            </div>            
        </section>
<?php
    $block['scripts'] = '
        <script>
            document.addEventListener("click", event => {
                let btn = event.target.closest(".add-input")
                if(btn !== null) {
                    event.preventDefault()
                    let el = btn.parentNode.parentNode
                    const newEl = el.parentNode.insertBefore(el.cloneNode(true), null)
                    let input = newEl.querySelector("input")
                    input.value = ""
                    input.focus()
                    el.removeChild(btn.parentNode)
                }
                btn = event.target.closest(".remove-input")
                if(btn !== null) {
                    event.preventDefault()
                    let el = btn.parentNode.parentNode
                    el.parentNode.removeChild(el)
                }
            })
        </script>
    ';