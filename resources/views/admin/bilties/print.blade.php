<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bilty Print - {{ $bilty->bilty_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f0f2f5; padding: 20px; color: #222; }
        .print-btn-bar { max-width: 900px; margin: 0 auto 15px auto; text-align: right; }
        .btn-print { background: #1D4ED8; color: #fff; border: none; padding: 10px 24px; font-weight: bold; border-radius: 6px; cursor: pointer; }
        .bilty-card { background: #fff; max-width: 900px; margin: 0 auto 25px auto; border: 2px solid #333; padding: 18px; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); }
        .bilty-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #222; padding-bottom: 10px; margin-bottom: 12px; }
        .bilty-title { font-size: 20px; font-weight: 900; text-transform: uppercase; color: #1D4ED8; }
        .bilty-badge { font-size: 12px; font-weight: bold; padding: 4px 10px; background: #eee; border: 1px solid #999; border-radius: 4px; }
        .bilty-num { font-size: 18px; font-weight: bold; color: #b91c1c; font-family: monospace; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 12px; }
        .box { border: 1px solid #ccc; padding: 10px; border-radius: 4px; background: #fafafa; }
        .box-title { font-size: 11px; text-transform: uppercase; font-weight: 800; color: #555; border-bottom: 1px dashed #bbb; padding-bottom: 4px; margin-bottom: 6px; }
        .party-name { font-size: 15px; font-weight: bold; margin-bottom: 3px; }
        .info-row { font-size: 13px; margin-bottom: 3px; }
        table.cargo-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 13px; }
        table.cargo-table th, table.cargo-table td { border: 1px solid #444; padding: 8px; text-align: left; }
        table.cargo-table th { background: #f0f0f0; font-weight: bold; }
        .freight-box { display: flex; justify-content: space-between; background: #e0f2fe; border: 1px solid #0284c7; padding: 10px; border-radius: 4px; font-size: 14px; font-weight: bold; margin-bottom: 12px; }
        .signatures { display: flex; justify-content: space-between; margin-top: 25px; padding-top: 10px; }
        .sig-line { border-top: 1px dashed #333; width: 180px; text-align: center; font-size: 11px; font-weight: bold; padding-top: 4px; }
        .copy-watermark { text-align: right; font-size: 11px; font-weight: bold; color: #666; margin-top: 8px; }

        @media print {
            body { background: #fff; padding: 0; }
            .print-btn-bar { display: none; }
            .bilty-card { border: 1.5px solid #000; box-shadow: none; margin-bottom: 30px; page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="print-btn-bar">
    <button class="btn-print" onclick="window.print()">🖨️ Print 3-Copy Bilty</button>
</div>

<!-- COPY 1: Consignor (Sender Copy) -->
<div class="bilty-card">
    <div class="bilty-header">
        <div>
            <div class="bilty-title">🚛 MOVERS GOODS FREIGHT CARGO</div>
            <div style="font-size: 12px; color: #555;">Head Office: Goods Forwarding & Commission Adda • Pakistan</div>
        </div>
        <div style="text-align: right;">
            <div class="bilty-badge">ORIGINAL - SENDER COPY (بھیجنے والے کی کاپی)</div>
            <div class="bilty-num">{{ $bilty->bilty_number }}</div>
            <div style="font-size: 12px;">Date: {{ $bilty->bilty_date ? $bilty->bilty_date->format('d/m/Y') : $bilty->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="box">
            <div class="box-title">CONSIGNOR / بھیجنے والا (FROM)</div>
            <div class="party-name">{{ $bilty->consignor_name }}</div>
            <div class="info-row"><strong>City:</strong> {{ $bilty->consignor_city }}</div>
            <div class="info-row"><strong>Phone:</strong> {{ $bilty->consignor_phone ?: 'N/A' }}</div>
            <div class="info-row"><strong>Address:</strong> {{ $bilty->consignor_address }}</div>
        </div>
        <div class="box">
            <div class="box-title">CONSIGNEE / وصول کنندہ (TO)</div>
            <div class="party-name">{{ $bilty->consignee_name }}</div>
            <div class="info-row"><strong>Destination:</strong> {{ $bilty->consignee_city }}</div>
            <div class="info-row"><strong>Phone:</strong> {{ $bilty->consignee_phone ?: 'N/A' }}</div>
            <div class="info-row"><strong>Address:</strong> {{ $bilty->consignee_address }}</div>
        </div>
    </div>

    <table class="cargo-table">
        <thead>
            <tr>
                <th>Item / Description (مال کی تفصیل)</th>
                <th>Package Type</th>
                <th>Quantity (کل نگ)</th>
                <th>Total Weight</th>
                <th>Payment Term</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>{{ $bilty->goods_description }}</strong></td>
                <td>{{ $bilty->package_type }}</td>
                <td><strong>{{ $bilty->total_packages }}</strong></td>
                <td>{{ $bilty->weight_value }} {{ $bilty->weight_unit }}</td>
                <td><span style="font-weight: bold; color: #1D4ED8;">{{ $bilty->payment_status }}</span></td>
            </tr>
        </tbody>
    </table>

    <div class="freight-box">
        <div>Total Freight: <strong>Rs. {{ number_format($bilty->freight_total) }}</strong></div>
        <div>Advance Paid: <strong>Rs. {{ number_format($bilty->advance_paid) }}</strong></div>
        <div style="color: #b91c1c;">Balance (باقی): <strong>Rs. {{ number_format($bilty->balance_amount) }}</strong></div>
    </div>

    <div class="grid-2" style="margin-bottom: 0;">
        <div style="font-size: 12px;">
            <div><strong>Driver:</strong> {{ $bilty->driver_name ?: 'N/A' }} ({{ $bilty->driver_phone }})</div>
            <div><strong>Truck No:</strong> {{ $bilty->truck_number ?: 'N/A' }} ({{ $bilty->truck_type }})</div>
        </div>
        <div style="font-size: 12px;">
            <div><strong>Guarantor / ضمانت:</strong> {{ $bilty->guarantor_name ?: 'Direct Adda' }} ({{ $bilty->guarantor_phone }})</div>
            <div><strong>Terms:</strong> Subject to standard Goods Transport terms & conditions.</div>
        </div>
    </div>

    <div class="signatures">
        <div class="sig-line">Sender / Consignor Signature</div>
        <div class="sig-line">Driver Signature</div>
        <div class="sig-line">Adda Munshi / Agent Signature</div>
    </div>
    <div class="copy-watermark">1 of 3 • Sender Copy</div>
</div>

<!-- COPY 2: Driver / Road Transit Copy -->
<div class="bilty-card">
    <div class="bilty-header">
        <div>
            <div class="bilty-title">🚛 MOVERS GOODS FREIGHT CARGO</div>
            <div style="font-size: 12px; color: #555;">Transit & Delivery Gate Pass • Pakistan</div>
        </div>
        <div style="text-align: right;">
            <div class="bilty-badge" style="background: #fef3c7;">DRIVER & TRANSIT COPY (ڈرائیور کی کاپی)</div>
            <div class="bilty-num">{{ $bilty->bilty_number }}</div>
            <div style="font-size: 12px;">Date: {{ $bilty->bilty_date ? $bilty->bilty_date->format('d/m/Y') : $bilty->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="box">
            <div class="box-title">CONSIGNOR / بھیجنے والا</div>
            <div class="party-name">{{ $bilty->consignor_name }} ({{ $bilty->consignor_city }})</div>
            <div class="info-row">Phone: {{ $bilty->consignor_phone ?: 'N/A' }}</div>
        </div>
        <div class="box">
            <div class="box-title">CONSIGNEE / وصول کنندہ (DELIVER TO)</div>
            <div class="party-name">{{ $bilty->consignee_name }} ({{ $bilty->consignee_city }})</div>
            <div class="info-row">Phone: {{ $bilty->consignee_phone ?: 'N/A' }} | Address: {{ $bilty->consignee_address }}</div>
        </div>
    </div>

    <table class="cargo-table">
        <thead>
            <tr>
                <th>Cargo Details</th>
                <th>Nag / Quantity</th>
                <th>Weight</th>
                <th>Balance to Collect (وصول طلب باقی)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>{{ $bilty->goods_description }}</strong></td>
                <td>{{ $bilty->total_packages }} {{ $bilty->package_type }}</td>
                <td>{{ $bilty->weight_value }} {{ $bilty->weight_unit }}</td>
                <td style="font-size: 15px; font-weight: bold; color: #b91c1c;">Rs. {{ number_format($bilty->balance_amount) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signatures">
        <div class="sig-line">Driver Signature (Upon Receipt)</div>
        <div class="sig-line">Receiver Signature (Upon Delivery)</div>
    </div>
    <div class="copy-watermark">2 of 3 • Driver / Transit Copy</div>
</div>

</body>
</html>
