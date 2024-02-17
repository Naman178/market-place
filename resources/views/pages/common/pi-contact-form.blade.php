<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"> </script>
<link rel="stylesheet"  href= "https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css" />
<script src= "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />
<style>
    #my-modal .select2-container{
        width: 100% !important;
    }
</style>
<form class="erp-contact-form">
    <div class="row">
        <input type="hidden" name="entity_id" value="<?= $data['entity_id'] ?? '0' ?>">
        <input type="hidden" name="select_id" value="<?= $data->contacts['id'] ?? '0' ?>">
        <input type="hidden" name="contact_id" value="<?= $data->contacts['id'] ?? '0' ?>">
        <!-- <div class="col-md-3 form-group">
            <label for="customerName">Title</label>
            <input type="text" class="form-control erp-title" name="title" value="<?= $data->contacts['title'] ?? '' ?>" />
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">First Name</label>
            <input type="text" class="form-control erp-fname" name="fname" value="<?= $data->contacts['fname'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Last Name</label>
            <input type="text" class="form-control erp-lname" name="lname" value="<?= $data->contacts['lname'] ?? '' ?>">
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
            <input type="text" class="form-control erp-email" name="email" value="<?= $data->contacts['email'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Phone 1</label>
            <input type="text" class="form-control erp-phone1" name="phone1" value="<?= $data->contacts['phone1'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Phone 2</label>
            <input type="text" class="form-control erp-phone2" name="phone2" value="<?= $data->contacts['phone2'] ?? '' ?>">
        </div>
        <div class="col-md-3 form-group">
            <label for="orderDate">Fax</label>
            <input type="text" class="form-control erp-fax" name="fax" value="<?= $data->contacts['fax'] ?? '' ?>">
        </div>
        <div class="col-md-6 form-group">
            <label for="orderDate">Address</label>
            <input type="text" class="form-control erp-address" name="address" value="<?= $data->contacts['address'] ?? '' ?>">
        </div> -->
        <div class="col-md-6 form-group">
            <label for="orderDate">City</label>
            <input type="text" class="form-control erp-city" name="city" value="<?= $data->contacts['city'] ?? '' ?>">
        </div>
        <!-- <div class="col-md-4 form-group">
            <label for="orderDate">State</label>
            <input type="text" class="form-control erp-state" name="state" value="<?= $data->contacts['state'] ?? '' ?>">
        </div>
        <div class="col-md-4 form-group">
            <label for="orderDate">Postal Code</label>
            <input type="text" class="form-control erp-postal_code" name="postal_code" value="<?= $data->contacts['postal_code'] ?? '' ?>">
        </div> -->
        <div class="col-md-6 form-group">
            <label for="orderDate">Country</label>
            <select class="form-control select2 erp-country" name="country">
                <option value="">---SELECT---</option>
                    <?php foreach(Helper::ContactCountryAll() as $country){ 
                        $selected = '';
                        if(!empty($data->contacts['country'])){
                            if($data->contacts['country'] == $country->name){
                                $selected = 'selected';
                            }    
                        }
                    ?>
                        <option value="<?= $country->name; ?>"  <?= $selected; ?> > <?= $country->name; ?> </option>
                    <?php } ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit-btn">Save</button>
    </div>
</form>
<script>
    $(document).ready(function(){
        $('.erp-country').select2({
            dropdownParent: $('#my-modal')
        });
    });
</script>