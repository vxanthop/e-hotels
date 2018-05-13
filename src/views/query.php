        <section class="general search-results">
            <form action="/search" method="GET" class="container">
                <div class="row">
                    <div class="col col-9 order-2">
                        <div class="results-searchbox-container">
                            <input type="search" class="results-searchbox" name="city" placeholder="Search destination..." required value="<?= $city; ?>" />
                            <div class="form-row mt-2">
                                <div class="col col-6 input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start_date" placeholder="Choose start date..." required value="<?= $start_date; ?>" />
                                    <input type="text" class="form-control" name="end_date" placeholder="Choose end date..." required value="<?= $end_date; ?>" />
                                </div>
                                <div class="col col-3">
                                    <select name="capacity" class="form-control">
<?php for($i = 1; $i <= 10; ++$i) { ?>
                                        <option value="<?= $i ?>"<?= ($capacity == $i) ? " selected" : ""?> ><?= $i ?> beds</option>
<?php } ?>
                                    </select>
                                </div>
                                <div class="col col-3">
                                    <input type="submit" name="submit" class="form-control btn btn-primary" value="Search" />
                                </div>
                            </div>
                        </div>
                        <div class="results-container">
                        <?php foreach(array_chunk($results, 2) as $row) { ?>
                            <div class="row no-gutters">
                            <?php foreach($row as $i => $room) { ?>
                                <div class="col col-6 <?= ($i == 0) ? 'pr-2 ' : 'pl-2 ' ?>py-2">
                                    <div class="card">
                                        <?php if($room->hotel->img_src) { ?><img src="<?= $room->hotel->img_src ?>" alt="" class="card-img-top" /><?php } ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $room->hotel->name ?></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="col col-3 aside-container">
                        <aside>
                            <h4>Search filters</h4>
                            <div class="search-filters mt-4">

                                <h6 class="filter-title">Stars <i class="fas fa-star"></i></h6>
                                <select name="stars" class="form-control">
                                    <option value="0"<?= $stars == 0 ? " selected" : ""?> >Any stars</option>
                                <?php for($i = 1; $i <= 5; ++$i) { ?>
                                    <option value="<?= $i ?>"<?= ($stars == $i) ? " selected" : ""?> ><?= $i ?> stars</option>
                                <?php } ?>
                                </select>

                                <h6 class="filter-title">
                                    <a href="#hotel-group-filter"<?= count($hotel_groups) < count($all_hotel_groups) ? '' : ' class="collapsed"' ?> data-toggle="collapse"><span class="collapse-arrow"></span>Hotel group</a>
                                </h6>
                                <div class="collapse<?= count($hotel_groups) < count($all_hotel_groups) ? ' show' : '' ?> collapsible filter" id="hotel-group-filter">
                                <?php foreach($all_hotel_groups as $group) { ?>
                                    <label><input type="checkbox" name="hotel_groups[]" value="<?= $group->id ?>"<?= in_array($group->id, $hotel_groups) ? " checked" : "" ?> > <span><?= $group->name ?></span></label>
                                <?php } ?>
                                    <div class="btn-group" role="group">
                                        <button id="allGroupsBtn" type="button" class="btn btn-secondary">All</button>
                                        <button id="clearGroupsBtn" type="button" class="btn btn-secondary">Clear</button>
                                    </div>
                                </div>

                                <h6 class="filter-title">Total rooms in hotel</h6>
                                <div id="rooms-range" class="nouislider-container"></div>
                                <div class="input-group mt-2">
                                    <input id="roomsStart" name="rooms_start" type="number" class="form-control" value="<?= $rooms_start ?>" min="1" max="100" />
                                    <input id="roomsEnd" name="rooms_end" type="number" class="form-control" value="<?= $rooms_end ?>" min="1" max="100" />
                                </div>

                                <h6 class="filter-title">
                                    <a href="#amenities-filter" data-toggle="collapse"><span class="collapse-arrow"></span>Amenities</a>
                                </h6>
                                <div class="collapse show collapsible filter" id="amenities-filter">
                                <?php foreach($all_amenities as $amenity) { ?>
                                    <label><input type="checkbox" name="amenities[]" value="<?= $amenity ?>"<?= in_array($amenity, $amenities) ? ' checked' : '' ?> > <span><?= $amenity ?></span></label>
                                <?php } ?>
                                </div>

                            </div>
                            <input type="submit" name="submit" class="form-control btn btn-sm btn-warning mt-4" value="Apply" />
                        </aside>
                    </div>
                </div>
            </form>
        </section>
<?php
    $block['scripts'] .= '
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/nouislider.min.js"></script>
    <script>
        const allGroupsBtn = document.getElementById("allGroupsBtn"),
              clearGroupsBtn = document.getElementById("clearGroupsBtn"),
              hotelGroups = document.querySelectorAll("#hotel-group-filter input"),
              roomsRange = document.getElementById("rooms-range"),
              roomsIn = [document.getElementById("roomsStart"), document.getElementById("roomsEnd")]
        
        allGroupsBtn.addEventListener("click", function(){
            [...hotelGroups].forEach(el => {el.checked = true})
        })
        clearGroupsBtn.addEventListener("click", function(){
            [...hotelGroups].forEach(el => {el.checked = false})
        })

        noUiSlider.create(roomsRange, {
            start: [' . $rooms_start . ', ' . $rooms_end . '],
            step: 1,
            connect: true,
            range: {
                min: [1],
                "70%": [20],
                max: [100]
            }
        })
        roomsRange.noUiSlider.on("update", function( values, handle ) {
            roomsIn[handle].value = Math.round(values[handle])
        })
        roomsIn[0].addEventListener("change", function(){
            roomsRange.noUiSlider.set([this.value, null])
        })
        roomsIn[1].addEventListener("change", function(){
            roomsRange.noUiSlider.set([null, this.value])
        })

        $().ready(function(){
            $("#datepicker").datepicker({
                format: "dd-mm-yyyy",
                maxViewMode: 2,
                todayHighlight: true
            });
        })
    </script>
    ';
    $block['stylesheets'] = array_merge($block['stylesheets'], [
        '/assets/css/bootstrap-datepicker3.min.css',
        '/assets/css/nouislider.min.css'
    ]);