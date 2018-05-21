        <section class="hero">
            <div class="container">
                <h2>Choose between <?= count($citynames) ?> destinations!</h2>
                <form action="/search" method="GET" class="hero-search-container" autocomplete="off">
                    <div class="form-group hero-searchbox-container">
                        <input type="search" id="city" name="city" class="hero-searchbox" autofocus placeholder="Search destination..." required />
                        <div class="hero-search-autocomplete list-group" id="autocomplete" data-selected="-1"></div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col col-6 input-daterange input-group" id="datepicker">
                            <input type="text" class="form-control" name="start_date" placeholder="Choose start date..." required />
                            <input type="text" class="form-control" name="end_date" placeholder="Choose end date..." required />
                        </div>
                        <div class="col col-3">
                            <select name="capacity" class="form-control">
                                <option value="0">Any beds</option>
<?php for($i = 1; $i <= 10; ++$i) { ?>
                                <option value="<?= $i ?>"><?= $i ?> beds</option>
<?php } ?>
                            </select>
                        </div>
                        <div class="col col-3">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Search" />
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="offers">
            <div class="container">
                <h3>Offers</h3>
                <div class="row">
<?php
    foreach($offers as $offer) {
?>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="https://via.placeholder.com/320x240" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">
                                    <strong><?= $offer['city'] ?></strong>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Book now</button>
                                    </div>
                                    <span><?= $offer['price'] ?>€</span>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
    }
?>
                </div>
            </div>
        </section>
<?php
    ob_start();
?>
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script>
        const cities = ['<?= join('\', \'', $citynames) ?>'],
              autocomplete = document.getElementById('autocomplete'),
              input = document.getElementById('city')
        
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
                input.focus()
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
                        input.focus()
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

        $().ready(function(){
            $("#datepicker").datepicker({
                format: "yyyy-mm-dd",
                maxViewMode: 2,
                todayHighlight: true
            });
        })
    </script>
<?php
    $block['scripts'] = ob_get_clean();
    $block['stylesheets'] = array_merge($block['stylesheets'], [
        '/assets/css/bootstrap-datepicker3.min.css',
    ]);