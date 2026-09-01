<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .invoice {
            width: 190mm;
            margin: 0 auto;
            background: white;
            padding: 10mm;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }

        h1 {
            color: #000;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background: #000 !important;
            color: white !important;
            padding: 10px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge-paid {
            background: #22c55e;
            color: white;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .badge-unpaid {
            background: #ef4444;
            color: white;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .badge-partial {
            background: #f59e0b;
            color: white;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .status {
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
            font-size: 16px;
        }

        .status-lunas {
            background: #22c55e;
            color: white;
        }

        .status-belum-lunas {
            background: #ef4444;
            color: white;
        }

        .summary-table td {
            border: none;
            padding: 8px 10px;
        }

        .summary-table tr.total-row td {
            border-top: 2px solid #000;
            font-size: 16px;
        }

        /* ==== Invoice list ala struk ==== */
        .invoice-list {
            margin-top: 20px;
        }

        .invoice-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 14px 0;
            border-bottom: 1px solid #eee;
        }

        .invoice-item .left .no-invoice {
            font-weight: bold;
            font-size: 14px;
            color: #000;
        }

        .invoice-item .left .deskripsi {
            font-size: 13px;
            color: #666;
            margin-top: 2px;
        }

        .invoice-item .right {
            text-align: right;
        }

        .invoice-item .right .nominal {
            font-weight: bold;
            font-size: 14px;
        }

        .invoice-item .right .badge-paid,
        .invoice-item .right .badge-unpaid,
        .invoice-item .right .badge-partial {
            margin-top: 4px;
        }

        /* ==== Ringkasan rata kanan-kiri ==== */
        .divider {
            border: none;
            border-top: 2px dashed #ccc;
            margin: 20px 0;
        }

        .summary-list {
            width: 100%;
        }

        .summary-list .row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
        }

        .summary-list .row.grand {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #000;
            padding-top: 12px;
            margin-top: 6px;
        }

        .summary-list .row.paid {
            color: #16a34a;
            font-weight: bold;
        }

        .summary-list .row .label {
            color: #333;
        }

        .status-final {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 12px;
            border-top: 1px solid #000;
        }

        .status-final .label {
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #888;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            display: block;
        }

        .logo-billypio {
            width: 150px;
        }

        .logo-qwhite {
            width: 130px;
            margin-top: 5px;
        }

        .logo-skymanor {
            width: 170px;
            margin-top: 10px;
        }

        .logo-valley {
            width: 170px;
            margin-top: 10px;
        }

        .logo-default {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="invoice" id="invoice">
        <div class="header">
            <div>
                @php
                    $villas = [
                        'BillyPio Homestay' => [
                            'logo' => 'logo-medan.png',
                            'class' => 'logo-billypio',
                        ],
                        'Qwhite House' => [
                            'logo' => 'logo-sby.png',
                            'class' => 'logo-qwhite',
                        ],
                        'Bromo Sky Manor' => [
                            'logo' => 'logo-bromo.jpeg',
                            'class' => 'logo-skymanor',
                        ],
                        'Bromo Valley Lodge' => [
                            'logo' => 'logo-bromo.jpeg',
                            'class' => 'logo-valley',
                        ],
                    ];

                    $namaVilla = $invoice->booking->villa->nama_villa;

                    $data = $villas[$namaVilla] ?? [
                        'logo' => 'default.png',
                        'class' => 'logo-default',
                    ];
                @endphp

                <img src="{{ asset('images/' . $data['logo']) }}" class="logo {{ $data['class'] }}" alt="Logo">
            </div>
            <div>
                <h2>INVOICE</h2>
                <b>{{ $invoice->nomor_invoice }}</b>
            </div>
        </div>
        <table>
            <tr>
                <td>
                    <b>Nama Customer</b><br>
                    {{ $invoice->booking->customer->nama_customer }}
                </td>
                <td>
                    <b>No HP</b><br>
                    {{ $invoice->booking->customer->notelp_customer }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Villa</b><br>
                    {{ $invoice->booking->villa->nama_villa }}
                </td>
                <td>
                    <b>PIC</b><br>
                    {{ $invoice->booking->pic }}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Check In</b><br>
                    {{ date('d M Y H:i', strtotime($invoice->booking->tglcekin)) }}
                </td>
                <td>
                    <b>Check Out</b><br>
                    {{ date('d M Y H:i', strtotime($invoice->booking->tglcekout)) }}
                </td>
            </tr>
        </table>

        @php
            /*
            |--------------------------------------------------------------------------
            | TOTAL BOOKING SAAT INI (sudah termasuk tambah hari, dari tabel booking)
            |--------------------------------------------------------------------------
            */
            $totalBookingSekarang = (float) $invoice->booking->total_harga;

            $tambahHari = $invoices->filter(fn($item) => strtolower(trim($item->jenis)) === 'tambah hari');
            $totalTambahHari = (float) $tambahHari->sum('nominal');

            // BOOKING AWAL = Total sekarang dikurangi semua tambahan hari
            $bookingAwal = max(0, $totalBookingSekarang - $totalTambahHari);
        @endphp

        {{-- ============================================================
             RINCIAN PER INVOICE (list ala struk)
        ============================================================ --}}
        @php
            /*
            |--------------------------------------------------------------------------
            | Bedakan "Pelunasan Booking" vs "Pelunasan Tambah Hari" vs gabungan
            |--------------------------------------------------------------------------
            | Idealnya invoice punya kolom parent_invoice_id yang eksplisit menunjuk
            | invoice mana yang sedang dilunasi. Selama kolom itu belum ada, dipakai
            | pendekatan pencocokan nominal:
            | - $sisaBookingAwal  = sisa tagihan booking awal yang belum dibayar
            | - $pendingTambahHari = total Tambah Hari yang belum dibayar
            | Saat ketemu "Pelunasan", nominalnya dicocokkan ke kombinasi keduanya
            | supaya kalau satu pembayaran melunasi dua hal sekaligus, labelnya
            | otomatis jadi "Pelunasan Booking & Tambah Hari", bukan salah satu saja.
            |--------------------------------------------------------------------------
            */
            $epsilon = 1; // toleransi pembulatan rupiah

            $sisaBookingAwal = $bookingAwal;
            $pendingTambahHari = 0;
            $displayItems = [];

            foreach ($invoices as $item) {
                $jenisLower = strtolower(trim($item->jenis));
                $nominal = (float) $item->nominal;

                if ($jenisLower === 'dp') {
                    $deskripsi = 'DP Booking';
                    $sisaBookingAwal = max(0, $sisaBookingAwal - $nominal);
                } elseif ($jenisLower === 'tambah hari') {
                    $deskripsi = isset($item->jumlah_malam)
                        ? 'Tambah Hari — ' . $item->jumlah_malam . ' malam'
                        : 'Tambah Hari';
                    $pendingTambahHari += $nominal;
                } elseif ($jenisLower === 'pelunasan') {
                    $gabungan = $sisaBookingAwal + $pendingTambahHari;

                    if ($sisaBookingAwal > 0 && $pendingTambahHari > 0 && abs($nominal - $gabungan) < $epsilon) {
                        // Satu pembayaran melunasi booking awal + tambah hari sekaligus
                        $deskripsi = 'Pelunasan Booking & Tambah Hari';
                        $sisaBookingAwal = 0;
                        $pendingTambahHari = 0;
                    } elseif ($pendingTambahHari > 0 && abs($nominal - $pendingTambahHari) < $epsilon) {
                        $deskripsi = 'Pelunasan Tambah Hari';
                        $pendingTambahHari = 0;
                    } elseif ($sisaBookingAwal > 0 && abs($nominal - $sisaBookingAwal) < $epsilon) {
                        $deskripsi = 'Pelunasan Booking';
                        $sisaBookingAwal = 0;
                    } else {
                        // Nominal tidak cocok persis (pembayaran sebagian/kombinasi tak terduga)
                        // -> fallback generik, kurangi dari yang lama dulu (booking awal diprioritaskan)
                        $deskripsi = 'Pelunasan';
                        $sisaDikurangi = min($nominal, $sisaBookingAwal);
                        $sisaBookingAwal -= $sisaDikurangi;
                        $pendingTambahHari = max(0, $pendingTambahHari - ($nominal - $sisaDikurangi));
                    }
                } else {
                    $deskripsi = $item->jenis;
                }

                $displayItems[] = [
                    'item' => $item,
                    'deskripsi' => $deskripsi,
                ];
            }
        @endphp

        <div class="invoice-list">
            @foreach($displayItems as $row)
                @php
                    $item = $row['item'];
                    $deskripsi = $row['deskripsi'];
                @endphp
                <div class="invoice-item">
                    <div class="left">
                        <div class="no-invoice">{{ $deskripsi }}</div>
                    </div>
                    <div class="right">
                        <div class="nominal">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        @php
            /*
            |--------------------------------------------------------------------------
            | TOTAL KESELURUHAN TAGIHAN
            |--------------------------------------------------------------------------
            */
            $totalTagihan = $totalBookingSekarang;

            /*
            |--------------------------------------------------------------------------
            | TOTAL DIBAYAR
            |--------------------------------------------------------------------------
            | PENTING: hanya invoice dengan status "Paid" yang dihitung.
            | Invoice Partial/Unpaid TIDAK ikut dihitung sebagai sudah dibayar penuh.
            |--------------------------------------------------------------------------
            */
            // $invoicesPaid = $invoices->filter(fn($item) => strtolower(trim($item->status)) === 'paid');
            // $totalDibayar = (float) $invoicesPaid->sum('nominal');
            $totalDibayar = (float) $invoice->booking->total_bayar;

            /*
            |--------------------------------------------------------------------------
            | SISA PEMBAYARAN
            |--------------------------------------------------------------------------
            */
            $sisaPembayaran = max(0, $totalTagihan - $totalDibayar);

            /*
            |--------------------------------------------------------------------------
            | STATUS BOOKING
            |--------------------------------------------------------------------------
            */
            $statusBooking = ($sisaPembayaran <= 0) ? 'LUNAS' : 'BELUM LUNAS';
        @endphp

        {{-- ============================================================
             RINGKASAN (rata kanan-kiri, ala struk)
        ============================================================ --}}
        <hr class="divider">

        <div class="summary-list">
            <div class="row">
                <span class="label">TOTAL BOOKING AWAL</span>
                <span>Rp {{ number_format($bookingAwal, 0, ',', '.') }}</span>
            </div>

            @if($totalTambahHari > 0)
                <div class="row">
                    <span class="label">TOTAL TAMBAHAN</span>
                    <span>Rp {{ number_format($totalTambahHari, 0, ',', '.') }}</span>
                </div>
            @endif

            <div class="row grand">
                <span class="label">TOTAL KESELURUHAN</span>
                <span>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
            </div>

            <div class="row paid">
                <span class="label">TOTAL TERBAYAR</span>
                <span>Rp {{ number_format($totalDibayar, 0, ',', '.') }}</span>
            </div>

            @if($sisaPembayaran > 0)
                <div class="row">
                    <span class="label">SISA PEMBAYARAN</span>
                    <span>Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</span>
                </div>
            @endif

            <div class="status-final">
                <span class="label">STATUS BOOKING</span>
                <span class="status {{ $statusBooking === 'LUNAS' ? 'status-lunas' : 'status-belum-lunas' }}">
                    {{ $statusBooking }}
                </span>
            </div>
        </div>

        <br>
        <div class="footer">
            Terima kasih telah memilih <b>{{ optional($invoice->booking->villa)->nama_villa ?? 'StayHub' }}</b>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        window.onload = function () {

            const element = document.getElementById('invoice');

            const opt = {
                margin: 10,
                filename: 'Invoice-{{ $invoice->nomor_invoice }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 3,
                    useCORS: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf()
                .set(opt)
                .from(element)
                .save();

        };
    </script>
</body>

</html>