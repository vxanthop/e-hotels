        <section class="hero">
            <div class="container">
                <h2><?= $description; ?></h2>
                <input type="search" class="hero-search" autofocus placeholder="Search..." />
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