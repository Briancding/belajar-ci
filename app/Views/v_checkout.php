<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <?= form_open('buy', 'class="row g-3"') ?>

            <?= form_hidden('username', session()->get('username')) ?>
            <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga']) ?>

            <div class="col-12">
                <?= form_label('Nama', 'nama', ['class' => 'form-label']) ?>
                <?= form_input([
                    'name'     => 'nama',
                    'id'       => 'nama',
                    'class'    => 'form-control',
                    'value'    => session()->get('username'),
                    'readonly' => true]) ?>
            </div>

            <div class="col-12">
                <?= form_label('Alamat', 'alamat', ['class' => 'form-label']) ?>
                <?= form_input(['name' => 'alamat', 'id' => 'alamat', 'class' => 'form-control']) ?>
            </div>

            <div class="col-12">
                <?= form_label('Kelurahan', 'kelurahan', ['class' => 'form-label']) ?>
                <?= form_dropdown('kelurahan', [], '', ['id' => 'kelurahan', 'class' => 'form-control']) ?>
            </div>

            <div class="col-12">
                <?= form_label('Layanan', 'layanan', ['class' => 'form-label']) ?>
                <?= form_dropdown('layanan', [], '', ['id' => 'layanan', 'class' => 'form-control']) ?>
            </div>

            <div class="col-12">
                <?= form_label('Ongkir', 'ongkir', ['class' => 'form-label']) ?>
                <?= form_input([
                    'name'     => 'ongkir',
                    'id'       => 'ongkir',
                    'class'    => 'form-control',
                    'readonly' => true]) ?>
            </div>

            <!-- INPUT VOUCHER -->
            <div class="col-12">
                <?= form_label('Kode Voucher', 'voucher_code', ['class' => 'form-label']) ?>
                <div class="input-group">
                    <?= form_input([
                        'name'        => 'voucher_code',
                        'id'          => 'voucher_code',
                        'class'       => 'form-control',
                        'placeholder' => 'Masukkan kode voucher']) ?>
                    <button class="btn btn-outline-secondary" type="button" id="btn_voucher">
                        Terapkan
                    </button>
                </div>
                <small class="text-muted">
                    Tersedia: PROMO2025 (10%), PROMO2026 (15%), AKHIRTAHUN (25%)
                </small>
                <div id="voucher_info" class="mt-1"></div>
            </div>

            <div class="col-12">
                <?= form_submit('submit', 'Buat Pesanan', ['class' => 'btn btn-primary']) ?>
            </div>

        <?= form_close() ?>
    </div>

    <!-- ===== TABEL KANAN ===== -->
    <div class="col-lg-6">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)) : foreach ($items as $item) : ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                </tr>
                <?php endforeach; endif; ?>

                <tr>
                    <td colspan="2"></td>
                    <td>Subtotal</td>
                    <td><?= number_to_currency($total, 'IDR') ?></td>
                </tr>
                <tr id="row_diskon_voucher" style="display:none">
                    <td colspan="2"></td>
                    <td class="text-danger">Diskon Voucher</td>
                    <td class="text-danger" id="cell_diskon_voucher">-</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Biaya Jasa</td>
                    <td id="cell_biaya_jasa">IDR <?= number_format($biaya_jasa, 0, ',', '.') ?></td>
                </tr>
                <tr id="row_free_mouse" <?= $free_mouse == 0 ? 'style="display:none"' : '' ?>>
                    <td colspan="2"></td>
                    <td class="text-success">Free Mouse</td>
                    <td class="text-success">-IDR 150.000</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td><strong>Grand Total</strong></td>
                    <td><strong><span id="grand_total">-</span></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    const subtotal   = <?= $total ?>;
    const biayaJasa  = <?= $biaya_jasa ?>;
    const freeMouse  = <?= $free_mouse ?>;
    let ongkir       = 0;
    let diskonVoucher = 0;

    // Daftar voucher (sama dengan helper PHP)
    const vouchers = {
        'PROMO2025'  : 10,
        'PROMO2026'  : 15,
        'AKHIRTAHUN' : 25
    };

    hitungTotal();

    function hitungTotal() {
        const grandTotal = subtotal + biayaJasa - diskonVoucher - freeMouse + ongkir;

        $("#ongkir").val(ongkir.toLocaleString('id-ID'));
        $("#grand_total").text("IDR " + grandTotal.toLocaleString('id-ID'));
        $("#total_harga").val(grandTotal);
    }

    // Terapkan voucher
    $("#btn_voucher").on('click', function () {
        const kode   = $("#voucher_code").val().toUpperCase().trim();
        const persen = vouchers[kode] ?? 0;

        if (persen > 0) {
            diskonVoucher = subtotal * persen / 100;

            $("#row_diskon_voucher").show();
            $("#cell_diskon_voucher").text(
                `-IDR ${diskonVoucher.toLocaleString('id-ID')} (${persen}%)`
            );
            $("#voucher_info").html(
                `<span class="text-success">✓ Voucher ${kode} berhasil diterapkan (${persen}%)</span>`
            );
        } else {
            diskonVoucher = 0;
            $("#row_diskon_voucher").hide();
            $("#voucher_info").html(
                kode 
                ? `<span class="text-danger">✗ Kode voucher tidak valid</span>`
                : ''
            );
        }

        hitungTotal();
    });

    // Select2 kelurahan
    $('#kelurahan').select2({
        placeholder: 'Cari daerah tujuan',
        minimumInputLength: 3,
        ajax: {
            url: '<?= site_url('ajax/destinations') ?>',
            dataType: 'json',
            delay: 300,
            data: params => ({ q: params.term }),
            processResults: data => data,
            cache: true
        }
    });

    $("#kelurahan").on('change', function () {
        $("#layanan").empty();
        ongkir = 0;
        hitungTotal();

        $.ajax({
            url: "<?= site_url('ajax/costs') ?>",
            dataType: "json",
            data: { destination: $(this).val() },
            success: function (data) {
                data.forEach(item => {
                    $("#layanan").append(
                        $('<option>', {
                            value: item.cost,
                            text: `${item.description} (${item.service}) : estimasi ${item.etd}`
                        })
                    );
                });
                $("#layanan").trigger('change');
            }
        });
    });

    $("#layanan").on('change', function () {
        ongkir = parseInt($(this).val()) || 0;
        hitungTotal();
    });
});
</script>
<?= $this->endSection() ?>