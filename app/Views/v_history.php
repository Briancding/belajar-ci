<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
History Transaksi Pembelian <strong><?= $username ?></strong>
<hr>
<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pembelian</th>
                <th scope="col">Waktu Pembelian</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Alamat</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)) : ?>
                <?php foreach ($transactions as $index => $item) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= $item['alamat'] ?></td>
                        <td>
                            <?= ($item['status'] == "1")
                                ? '<span class="badge bg-success">Sudah Selesai</span>'
                                : '<span class="badge bg-warning">Belum Selesai</span>' ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (!empty($transactions)) : ?>
    <?php foreach ($transactions as $item) : ?>
        <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Detail Transaksi #<?= $item['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- ===== PRODUK ===== -->
                        <?php if (!empty($products[$item['id']])) : ?>
                            <?php foreach ($products[$item['id']] as $index2 => $item2) : ?>
                                <?= $index2 + 1 . ")" ?>

                                <?php
                                $imagePath = FCPATH . 'img/' . $item2['foto'];
                                if (!empty($item2['foto']) && file_exists($imagePath)) : ?>
                                    <div class="my-2">
                                        <img src="<?= base_url('img/' . $item2['foto']) ?>" 
                                             width="100" class="img-thumbnail">
                                    </div>
                                <?php endif; ?>

                                <strong><?= $item2['nama'] ?></strong><br>
                                <?= number_to_currency($item2['harga'], 'IDR') ?>
                                (<?= $item2['jumlah'] ?> pcs)<br>
                                <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- ===== RINGKASAN BIAYA ===== -->
                        <table class="table table-sm">
                            <tr>
                                <td>Ongkir</td>
                                <td class="text-end">
                                    <?= number_to_currency($item['ongkir'], 'IDR') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Biaya Jasa</td>
                                <td class="text-end">
                                    <?= number_to_currency($item['biaya_jasa'] ?? 0, 'IDR') ?>
                                </td>
                            </tr>

                            <?php if (!empty($item['voucher_code'])) : ?>
                            <tr>
                                <td class="text-danger">
                                    Diskon Voucher
                                    <span class="badge bg-danger"><?= $item['voucher_code'] ?></span>
                                </td>
                                <td class="text-end text-danger">
                                    -<?= number_to_currency($item['diskon_voucher'] ?? 0, 'IDR') ?>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <?php if (!empty($item['free_mouse']) && $item['free_mouse'] > 0) : ?>
                            <tr>
                                <td class="text-success">Free Mouse 🖱️</td>
                                <td class="text-end text-success">
                                    -<?= number_to_currency($item['free_mouse'], 'IDR') ?>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <tr class="fw-bold">
                                <td>Grand Total</td>
                                <td class="text-end">
                                    <?= number_to_currency($item['total_harga'], 'IDR') ?>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>