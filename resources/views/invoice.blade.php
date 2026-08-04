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

        .status {

            background: #22c55e;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;

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
        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $item)
                    <tr>
                        <td>Pembayaran Booking Villa</td>
                        <td>{{ $item->jenis }}</td>
                        <td class="text-end">
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @php
            $totalBooking = $invoice->booking->total_harga;
            $totalDibayar = $invoices->sum('nominal');
            $sisaPembayaran = $totalBooking - $totalDibayar;

            $dp = $invoices->first(function ($item) {
                return strtolower($item->jenis) == 'dp';
            });

            $pelunasan = $invoices->first(function ($item) {
                return strtolower($item->jenis) == 'pelunasan';
            });
        @endphp
        <table>
            <tr>
                <td width="50%"></td>
                <td><b>Total Booking</b></td>
                <td class="text-end">
                    Rp {{ number_format($totalBooking, 0, ',', '.') }}
                </td>
            </tr>

            @if($dp)
                <tr>
                    <td></td>
                    <td><b>DP Dibayar</b></td>
                    <td class="text-end">
                        Rp {{ number_format($dp->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @endif

            @if($pelunasan)
                <tr>
                    <td></td>
                    <td><b>Pelunasan</b></td>
                    <td class="text-end">
                        Rp {{ number_format($pelunasan->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @endif

            <tr>
                <td></td>
                <td><b>Total Dibayar</b></td>
                <td class="text-end">
                    Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td><b>Sisa Pembayaran</b></td>
                <td class="text-end">
                    Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}
                </td>
            </tr>
        </table>
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