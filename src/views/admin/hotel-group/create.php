        <section class="general admin">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Hotel Group</li>
                    </ol>
                </nav>
                <div class="container w-50 mt-5 mx-auto">
                    <form action="/admin/hotel-group/createSubmit" method="POST">
                        <div class="form-group">
                            <label for="name">Hotel group name:</label>
                            <input type="text" autofocus class="form-control" maxlength="42" required id="name" name="name" />
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="street">Address street:</label>
                                <input type="text" class="form-control" maxlength="42" required id="street" name="street" />
                            </div>
                            <div class="col">
                                <label for="number">Address number:</label>
                                <input type="number" class="form-control" min="1" max="9999" required id="number" name="number" />
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <label for="city">City:</label>
                                <input type="text" class="form-control" maxlength="42" required id="city" name="city" />
                            </div>
                            <div class="col">
                                <label for="postal">Postal code:</label>
                                <input type="number" class="form-control" min="10000" max="999999" required id="postal" name="postal_code" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Add" />
                    </form>
                </div>
            </div>            
        </section>
