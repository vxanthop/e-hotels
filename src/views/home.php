        <section class="hero">
            <div class="container">
                <h2><?= $description; ?></h2>
                <form action="/search" method="GET" class="hero-searchbox-container">
                    <input type="search" name="city" class="hero-searchbox" autofocus placeholder="Search destination..." required />
                    <div class="form-row mt-4">
                        <div class="col col-6 input-daterange input-group" id="datepicker">
                            <input type="text" class="form-control" name="start_date" placeholder="Choose start date..." required />
                            <input type="text" class="form-control" name="end_date" placeholder="Choose end date..." required />
                        </div>
                        <div class="col col-3">
                            <select name="capacity" class="form-control">
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
    $block['scripts'] = '
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script>
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
    ]);