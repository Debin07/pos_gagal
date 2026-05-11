<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $transaction->code }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0;
            padding: 10px;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .divider { border-top: 1px dashed #000; margin: 5px 0; }
        .header { margin-bottom: 10px; }
        .footer { margin-top: 20px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; }
    </style>
</head>
<body onload="window.print()">
    <div class="header text-center">
        <strong>GAS & GALON</strong><br>
        Jl. Raya Maju Terus No. 123<br>
        Telp: 0812-3456-7890
    </div>

    <div class="divider"></div>

    <div>
        No: {{ $transaction->code }}<br>
        Tgl: {{ $transaction->transaction_date->format('d/m/Y H:i') }}<br>
        Plg: {{ $transaction->customer->name ?? 'Umum' }}
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-right">{{ $item->qty }}</td>
                <td class="text-right">{{ number_format($item->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td><strong>TOTAL</strong></td>
            <td class="text-right"><strong>{{ number_format($transaction->total_amount) }}</strong></td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-right">{{ strtoupper($transaction->payment_status) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer text-center">
        Terima kasih atas kunjungan Anda!<br>
        Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.
    </div>
</body>
</html>
