<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recibo da Encomenda #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; }
        .header { width: 100%; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 20px; }
        .title { font-size: 28px; font-weight: bold; color: #2d3748; }
        .details-table { width: 100%; margin-bottom: 30px; }
        .items-table { width: 100%; border-collapse: collapse; text-align: left; }
        .items-table th { background-color: #f7fafc; padding: 10px; border-bottom: 2px solid #edf2f7; }
        .items-table td { padding: 10px; border-bottom: 1px solid #edf2f7; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

<div class="invoice-box">
    <table class="header">
        <tr>
            <td class="title">RECIBO OFICIAL</td>
            <td style="text-align: right;">
                <strong>Encomenda:</strong> #{{ $order->id }}<br>
                <strong>Data:</strong> {{ \Carbon\Carbon::parse($order->date)->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <table class="details-table">
        <tr>
            <td>
                <strong>Faturado a:</strong><br>
                {{ $order->customer->user->name ?? 'Cliente Registado' }}<br>
                {{ $order->customer->user->email ?? '' }}
            </td>
            <td style="text-align: right;">
                <strong>Método de Pagamento:</strong><br>
                {{ strtoupper($order->receipt_url ? 'Confirmado' : 'Pendente') }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Produto / Estampa</th>
                <th>Tamanho</th>
                <th>Qtd</th>
                <th>Preço Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>
                        {{ $item->tshirtImage->name ?? 'T-Shirt Customizada' }} 
                        <span style="color: #666;">({{ $item->color_code }})</span>
                    </td>
                    <td>{{ $item->size }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}€</td>
                    <td>{{ number_format($item->sub_total, 2) }}€</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Pago: {{ number_format($order->total_price, 2) }}€
    </div>
</div>

</body>
</html>