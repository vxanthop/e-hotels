        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel-group/<?= $group->id ?>"><?= $group->name ?></a></li>
                        <li class="breadcrumb-item"><a href="/admin/hotel/<?= $hotel->id ?>"><?= $hotel->name ?></a></li>
                        <li class="breadcrumb-item active">Update room #<?= $room->room_id ?></li>
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
                    <form action="/admin/room/update/<?= $room->room_id ?>?success=<?= urlencode('/admin/hotel/' . $hotel->id) ?>&error=<?= urlencode('/admin/room/update/' . $room->room_id) ?>" method="POST">
                        <div class="form-group">
                            <label for="capacity">Capacity:</label>
                            <select class="form-control" name="capacity">
                            <?php for($i = 1; $i <= 10; ++$i) { ?>
                                <option value="<?= $i ?>"<?= ($i == $room->capacity) ? ' selected' : '' ?> ><?= $i ?> beds</option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="form-group d-flex justify-content-around">
                            <div class="form-check form-control-lg">
                                <input type="checkbox" class="form-check-input"<?= $room->view ? ' checked' : '' ?>  name="view" id="view" value="yes">
                                <label for="view" class="form-check-label checked-bold">View to the sea</label>
                            </div>
                            <div class="form-check form-control-lg">
                                <input type="checkbox" class="form-check-input"<?= $room->repairs_need ? ' checked' : '' ?> name="repairs_need" id="repairs_need" value="yes">
                                <label for="repairs_need" class="form-check-label checked-bold">Needs repairs?</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Expandable:</label>
                            <select name="expandable" class="form-control">
                                <option value=""<?= ($room->expandable == '') ? ' selected' : '' ?> >No</option>
                                <option value="connecting_rooms"<?= ($room->expandable == 'connecting_rooms') ? ' selected' : '' ?> >Yes. By connecting rooms.</option>
                                <option value="more_beds"<?= ($room->expandable == 'more_beds') ? ' selected' : '' ?> >Yes. By adding more beds.</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price: <span class="text-danger" title="This field is required">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" min="1.00" max="300.00" step="0.01" name="price" id="price" value="<?= number_format($room->price, 2) ?>" required />
                                <div class="input-group-append">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Amenities:</label>
                        <?php foreach($room->amenities as $amenity) { ?>
                            <div class="input-group">
                                <input type="text" maxlength="42" class="form-control" name="amenities[]" value="<?= $amenity ?>" />
                                <div class="input-group-append">
                                    <button class="remove-input btn btn-secondary"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        <?php } ?>
                            <div class="input-group">
                                <input type="text" maxlength="42" class="form-control" name="amenities[]" />
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