<form class="erp-contact-form">
    <div class="row">
        <input type="hidden" name="entity_id" value="<?= $data['entity_id'] ?? '0' ?>">
        <input type="hidden" name="select_id" value="<?= $data['id'] ?? '0' ?>">
        <input type="hidden" name="contact_id" value="<?= $data['id'] ?? '0' ?>">
        <div class="col-md-3 form-group">
            <label for="customerName">Title</label>
            <input type="text" class="form-control erp-title" name="title" value="<?= $data['title'] ?? '' ?>" />
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">First Name</label>
            <input type="text" class="form-control erp-fname" name="fname" value="<?= $data['fname'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Last Name</label>
            <input type="text" class="form-control erp-lname" name="lname" value="<?= $data['lname'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Is Type</label>
            <select class="form-control erp-istype">
                <option value="0">Person</option>
                <option value="1">Company</option>
            </select>
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Email</label>
            <input type="text" class="form-control erp-email" name="email" value="<?= $data['email'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Phone 1</label>
            <input type="text" class="form-control erp-phone1" name="phone1" value="<?= $data['phone1'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Phone 2</label>
            <input type="text" class="form-control erp-phone2" name="phone2" value="<?= $data['phone2'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Fax</label>
            <input type="text" class="form-control erp-fax" name="fax" value="<?= $data['fax'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Address</label>
            <input type="text" class="form-control erp-address" name="address" value="<?= $data['address'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">City</label>
            <input type="text" class="form-control erp-city" name="city" value="<?= $data['city'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Postal Code</label>
            <input type="text" class="form-control erp-postal_code" name="postal_code" value="<?= $data['postal_code'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Country</label>
            <input type="text" class="form-control erp-country" name="country" value="<?= $data['country'] ?? '' ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit-btn">Save</button>
    </div>
</form>

