        <section class="general search-results">
            <form id="search-form" action="/search" method="GET" class="container" autocomplete="off">
                <div class="row">
                    <div class="col col-9 order-2">
                        <div class="results-search-container">
                            <div class="results-searchbox-container">
                                <input type="search" id="city" class="results-searchbox" name="city" placeholder="Search destination..." required value="<?= $city; ?>" />
                                <div class="results-search-autocomplete list-group" id="autocomplete" data-selected="-1"></div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col col-6 input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start_date" placeholder="Choose start date..." required value="<?= $start_date; ?>" />
                                    <input type="text" class="form-control" name="end_date" placeholder="Choose end date..." required value="<?= $end_date; ?>" />
                                </div>
                                <div class="col col-3">
                                    <select name="capacity" class="form-control" onchange="search()">
                                        <option value="0"<?= ($capacity == 0) ? " selected" : "" ?> >Any beds</option>
<?php for($i = 1; $i <= 10; ++$i) { ?>
                                        <option value="<?= $i ?>"<?= ($capacity == $i) ? " selected" : "" ?> ><?= $i ?> beds</option>
<?php } ?>
                                    </select>
                                </div>
                                <div class="col col-3">
                                    <input type="submit" name="b" class="form-control btn btn-primary" value="Search" />
                                </div>
                            </div>
                        </div>
                        <div class="btn-group btn-group-lg btn-group-toggle my-2 d-flex justify-content-center">
                            <label class="btn btn-secondary<?= $view == 'rooms' ? ' active' : '' ?>">
                                <i class="fas fa-th-large"></i> <input type="radio" name="view" value="rooms"<?= $view == 'rooms' ? ' checked' : '' ?> onchange="search()"> Rooms
                            </label>
                            <label class="btn btn-secondary<?= $view == 'per_city' ? ' active' : '' ?>">
                                <i class="fas fa-map-marker"></i> <input type="radio" name="view" value="per_city"<?= $view == 'per_city' ? ' checked' : '' ?> onchange="search()"> Per city
                            </label>
                        </div>
                        <div class="results-container">
                    <?php if($view == 'rooms') { ?>
                        <?php foreach(array_chunk($results, 2) as $row) { ?>
                            <div class="row no-gutters">
                            <?php foreach($row as $i => $room) { ?>
                                <div class="col col-6 <?= ($i == 0) ? 'pr-2 ' : 'pl-2 ' ?>py-2">
                                    <div class="card h-100">
                                        <img src="<?= $room->hotel->img_src ?? 'https://via.placeholder.com/400x200' ?>" alt="" class="card-img-top" />
                                        <div class="card-body d-flex flex-column">
                                            <h4 class="card-title text-center mb-4"><?= $room->hotel->name ?> <span class="badge badge-warning"><?= $room->hotel->stars ?><i class="fas fa-star"></i></span></h4>
                                            <div class="mt-auto d-flex justify-content-between">
                                                <div class="d-flex flex-column">
                                                    <ul class="list-unstyled mb-0 mt-auto">
                                                        <li><strong>Capacity: <?= $room->capacity ?></strong></li>
                                                        <?= ($room->view) ? '<li>View to the sea' : '' ?>
                                                        <?= ($room->repairs_need) ? '<li>Needs repairs' : '' ?>
                                                    <?php foreach($room->amenities as $amenity) { ?>
                                                        <li><?= $amenity ?>
                                                    <?php } ?>
                                                    </ul>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a class="btn btn-sm btn-secondary mt-auto" href="/reserve/prepare?room_id=<?= $room->room_id ?>&hotel_id=<?= $room->hotel_id ?>&start_date=<?= $start_date ?>&end=<?= $end_date ?>">Book now<br>for <strong>€<?= number_format($room->price, 2) ?></strong>!</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?php foreach(array_chunk($results, 2) as $row) { ?>
                            <div class="row no-gutters">
                            <?php foreach($row as $i => $city) { ?>
                                <div class="col col-6 <?= ($i == 0) ? 'pr-2 ' : 'pl-2 ' ?>py-2">
                                    <div class="card h-100">
                                        <img src="<?= 'https://via.placeholder.com/400x200' ?>" alt="" class="card-img-top" />
                                        <div class="card-body d-flex flex-column text-center">
                                            <h3 class="card-title"><?= $city['city'] ?></span></h3>
                                            <h5>
                                                <span class="badge badge-info"><?= $city['availableRoomsNum'] ?></span> rooms available
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                        </div>
                    </div>
                    <div class="col col-3 aside-container">
                        <aside>
                            <h4>Search filters</h4>
                            <div class="search-filters mt-4">

                                <h6 class="filter-title">Stars <i class="fas fa-star"></i></h6>
                                <select name="stars" class="form-control" onchange="search()">
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
                                    <label><input type="checkbox" name="hotel_groups[]" onclick="search()" value="<?= $group->id ?>"<?= in_array($group->id, $hotel_groups) ? " checked" : "" ?> > <span><?= $group->name ?></span></label>
                                <?php } ?>
                                    <div class="btn-group" role="group">
                                        <button id="allGroupsBtn" type="button" class="btn btn-secondary">All</button>
                                        <button id="clearGroupsBtn" type="button" class="btn btn-secondary">Clear</button>
                                    </div>
                                </div>

                                <h6 class="filter-title">Total rooms in hotel</h6>
                                <div id="rooms-range" class="nouislider-container"></div>
                                <div class="input-group mt-2">
                                    <input id="rooms-start" name="rooms_start" type="number" class="form-control" value="<?= $rooms_start ?>" min="1" max="100" onblur="search()" />
                                    <input id="rooms-end" name="rooms_end" type="number" class="form-control" value="<?= $rooms_end ?>" min="1" max="100" onblur="search()" />
                                </div>

                                <h6 class="filter-title">
                                    <a href="#amenities-filter" data-toggle="collapse"><span class="collapse-arrow"></span>Amenities</a>
                                </h6>
                                <div class="collapse show collapsible filter" id="amenities-filter">
                                <?php foreach($all_amenities as $amenity) { ?>
                                    <label><input type="checkbox" name="amenities[]" onclick="search()" value="<?= $amenity ?>"<?= in_array($amenity, $amenities) ? ' checked' : '' ?> > <span><?= $amenity ?></span></label>
                                <?php } ?>
                                </div>

                            </div>
                            <input type="submit" name="b" class="form-control btn btn-sm btn-warning mt-4" value="Apply" />
                        </aside>
                    </div>
                </div>
            </form>
        </section>
<?php
    ob_start();
?>
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/nouislider.min.js"></script>
    <script>
        const cities = ['<?= join('\', \'', $citynames) ?>'],
              autocomplete = document.getElementById('autocomplete'),
              input = document.getElementById('city'),
              allGroupsBtn = document.getElementById("allGroupsBtn"),
              clearGroupsBtn = document.getElementById("clearGroupsBtn"),
              hotelGroups = document.querySelectorAll("#hotel-group-filter input"),
              roomsRange = document.getElementById("rooms-range"),
              roomsIn = [document.getElementById("rooms-start"), document.getElementById("rooms-end")]
        
        function search() {
            document.getElementById('search-form').submit()
        }

        let removeChildren = el => {
            while(el.firstChild) el.removeChild(el.firstChild)
        }
        
        input.addEventListener('input', event => {
            removeChildren(autocomplete)
            autocomplete.setAttribute('data-selected', -1)
            if(input.value.length >= 1) {
                let matches = cities.filter(name => {
                    return name.toLowerCase().startsWith(input.value.toLowerCase())
                        && name != input.value
                }).sort()
                matches.forEach(match => {
                    let item = document.createElement('a')
                    item.classList.add('list-group-item', 'list-group-item-action')
                    item.setAttribute('href', '#')
                    item.appendChild(document.createTextNode(match))
                    autocomplete.appendChild(item)
                })
            }
        })

        input.addEventListener('focus', event => {
            autocomplete.classList.remove('d-none')
            autocomplete.classList.add('d-block')
            input.dispatchEvent(new Event('input'))
        })

        document.addEventListener('click', event => {
            if(event.target.parentNode.id == 'autocomplete') {
                event.preventDefault()
                input.value = event.target.innerHTML
                search()
            } else if(event.target.id != 'city') {
                autocomplete.classList.remove('d-block')
                autocomplete.classList.add('d-none')
            }
        })

        document.addEventListener('keydown', event => {
            if(autocomplete.offsetParent !== null) {
                let selected = parseInt(autocomplete.getAttribute('data-selected'))
                if(event.keyCode == 13) {
                    if(selected >= 0) {
                        event.preventDefault()
                        input.value = autocomplete.children[selected].innerHTML
                        search()
                    }
                }
                if(event.keyCode == 40) {
                    if(selected < autocomplete.children.length - 1) {
                        event.preventDefault()
                        input.blur()
                        if(selected >= 0) {
                            autocomplete.children[selected].classList.remove('active')
                        }
                        autocomplete.setAttribute('data-selected', ++selected)
                        autocomplete.children[selected].classList.add('active')
                    }
                }
                if(event.keyCode == 38) {
                    if(selected >= 0) {
                        event.preventDefault()
                        input.blur()
                        autocomplete.children[selected].classList.remove('active')
                        autocomplete.setAttribute('data-selected', --selected)
                        if(selected >= 0) {
                            autocomplete.children[selected].classList.add('active')
                        } else {
                            input.focus()
                        }
                    }
                }
            }
        })
        
        allGroupsBtn.addEventListener("click", function(){
            [...hotelGroups].forEach(el => {el.checked = true})
            search()
        })
        clearGroupsBtn.addEventListener("click", function(){
            [...hotelGroups].forEach(el => {el.checked = false})
        })

        noUiSlider.create(roomsRange, {
            start: [<?= $rooms_start ?>, <?= $rooms_end ?>],
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
        roomsRange.noUiSlider.on("change", search)

        $().ready(function(){
            $("#datepicker").datepicker({
                format: "yyyy-dd-mm",
                maxViewMode: 2,
                todayHighlight: true
            });
            $("#datepicker input").on("changeDate", () => search())
        })
    </script>
<?php
    $block['scripts'] = ob_get_clean();
    $block['stylesheets'] = array_merge($block['stylesheets'], [
        '/assets/css/bootstrap-datepicker3.min.css',
        '/assets/css/nouislider.min.css'
    ]);