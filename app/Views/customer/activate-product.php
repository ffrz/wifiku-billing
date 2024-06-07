<?php
$this->title = 'Aktivasi Layanan';
$this->navActive = 'customer';
$this->extend('_layouts/default')
?>
<?= $this->section('content') ?>
<div class="col-md-8">
    <div class="card card-primary">
        <form class="form-horizontal quick-form" method="POST">
            <div class="card-body">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $customer->id ?>" />
                <div class="form-group row">
                    <label for="cid" class="col-sm-3 col-form-label required">ID Pelanggan *</label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control" id="cid" placeholder="ID Pelanggan" name="cid" value="<?= format_customer_id($customer->cid) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fullname" class="col-sm-3 col-form-label required">Nama Lengkap *</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control" id="fullname" placeholder="Nama Lengkap" name="fullname" value="<?= esc($customer->fullname) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="datetime" class=" col-form-label col-sm-3 required">Berlaku mulai *</label>
                    <div class="col-sm-3">
                        <div class="input-group date" id="datetime" data-target-input="nearest">
                            <input type="text" autocomplete="off" class="form-control datetimepicker-input" data-target="#datetime" name="date" value="<?= esc(format_date($data->date)) ?>" />
                            <div class="input-group-append" data-target="#datetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="old_product" class=" col-form-label col-sm-3">Layanan saat ini</label>
                    <div class="col-sm-9">
                        <?php
                        $current_product_text = 'Tidak diset';
                        if ($current_product) {
                            $current_product_text = esc($current_product->name) . ' - Rp. ' . format_number($current_product->price);
                        }
                        ?>
                        <input type="text" class="form-control" value="<?= $current_product_text ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product" class=" col-form-label col-sm-3 required">Layanan Baru *</label>
                    <div class="col-sm-9">
                        <select class="form-control custom-select select2" id="product" name="product_id">
                            <option value="" <?= !$data->product_id ? 'selected' : '' ?>>--------</option>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?= $product->id ?>" <?= $data->product_id == $product->id ? 'selected' : '' ?> data-price="<?= $product->price ?>">
                                    <?= esc($product->name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?php if (!empty($errors['product_id'])) : ?>
                            <span class="error form-error">
                                <?= $errors['product_id'] ?>
                            </span>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price" class=" col-form-label col-sm-3 required">Biaya *</label>
                    <div class="col-sm-3">
                        <input type="number" autocomplete="off" class="form-control text-right" id="price" name="price" value="<?= esc($data->price) ?>">
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Aktifkan Layanan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footscript') ?>
<script>
    $(document).ready(function() {
        $('.date').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $('.select2').select2();
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        $('#product').change(function(){
            var selected = $('#product').find(":selected");
            console.log(selected.val());
            if (!selected.val()) {
                return;
            }
            
            $('#price').val(parseInt(selected.data('price')));
        });
    });
</script>
<?= $this->endSection() ?>