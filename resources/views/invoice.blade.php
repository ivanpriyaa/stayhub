<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #eee;
            margin: 30px;
        }

        .invoice {

            width: 900px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;

        }

        .header {

            display: flex;
            justify-content: space-between;
            border-bottom: 3px solid #213248;
            padding-bottom: 20px;

        }

        h1 {

            color: #213248;
            margin: 0;

        }

        table {

            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;

        }

        table th {

            background: #213248 !important;
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
            width: 150px;
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="header">
            <div>
                <img src="{{ asset('images/logo-stayhub.png') }}" class="logo">
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
                <tr>
                    <td>Booking Villa</td>
                    <td>{{ $invoice->jenis }}</td>
                    <td class="text-end">
                        Rp {{ number_format($invoice->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tr>
                <td width="70%"></td>
                <td>
                    <b>Total Booking</b>
                </td>
                <td class="text-end">
                    Rp {{ number_format($invoice->booking->total_harga, 0, ',', '.') }}
                </td>
            </tr>
            @if(strtolower($invoice->jenis) == 'dp')
                <tr>
                    <td></td>
                    <td><b>DP Dibayar</b></td>
                    <td class="text-end">
                        Rp {{ number_format($invoice->nominal, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Sisa Pembayaran</b></td>
                    <td class="text-end">
                        Rp {{ number_format($invoice->booking->total_harga - $invoice->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td><b>Total Dibayar</b></td>
                    <td class="text-end">
                        Rp {{ number_format($invoice->booking->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
                {{-- <tr>
                    <td></td>
                    <td><b>Sisa Pembayaran</b></td>
                    <td class="text-end">
                        Rp 0
                    </td>
                </tr> --}}
            @endif
        </table>
        <br>
        <div class="footer">
            Terima kasih telah memilih <b>StayHub</b>
        </div>
    </div>
</body>

</html>

<script>
    window.onload = function () {
        window.print();
    }
</script>