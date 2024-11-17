<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $type === 'komponen-des' ? 'Komponen DES' : 'Perhitungan Error' }} - {{ $prediksi }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #2d3748;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border-bottom: 3px solid #e2e8f0;
        }

        .header h1 {
            color: #1a365d;
            font-size: 24px;
            margin: 0 0 10px 0;
        }

        .header h2 {
            color: #2b6cb0;
            font-size: 18px;
            margin: 0;
            font-weight: normal;
        }

        .info-box {
            background: #ebf8ff;
            border: 1px solid #bee3f8;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .info-box h3 {
            color: #2c5282;
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .parameter-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 10px;
        }

        .parameter-item {
            background: white;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }

        .parameter-label {
            color: #4a5568;
            font-size: 12px;
        }

        .parameter-value {
            color: #2b6cb0;
            font-weight: bold;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th {
            background: #2b6cb0;
            color: white;
            padding: 12px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #e2e8f0;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background: #f7fafc;
        }

        .error-cell {
            font-weight: bold;
        }

        .ape-low {
            color: #2f855a;
            background: #f0fff4;
        }

        .ape-medium {
            color: #744210;
            background: #fffff0;
        }

        .ape-high {
            color: #c53030;
            background: #fff5f5;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #718096;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }

        /* Responsive width for parameter grid on smaller pages */
        @media (max-width: 600px) {
            .parameter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $type === 'komponen-des' ? 'Komponen DES' : 'Perhitungan Error' }}</h1>
        <h2>{{ $prediksi }}</h2>
    </div>

    <div class="info-box">
        <h3>Parameter DES</h3>
        <div class="parameter-grid">
            <div class="parameter-item">
                <div class="parameter-label">Alpha (α)</div>
                <div class="parameter-value">{{ number_format($alpha, 3) }}</div>
            </div>
            <div class="parameter-item">
                <div class="parameter-label">Beta (β)</div>
                <div class="parameter-value">{{ number_format($beta, 3) }}</div>
            </div>
            <div class="parameter-item">
                <div class="parameter-label">Mode</div>
                <div class="parameter-value">{{ $is_auto_parameter ? 'Otomatis' : 'Manual' }}</div>
            </div>
            <div class="parameter-item">
                <div class="parameter-label">MAPE</div>
                <div class="parameter-value">{{ number_format($mape, 2) }}%</div>
            </div>
        </div>
    </div>

    @if($type === 'komponen-des')
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Level (Lt)</th>
                    <th>Trend (Tt)</th>
                    <th>Forecast (Ft)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prediksiData as $data)
                <tr>
                    <td>{{ $data['bulan'] }}</td>
                    <td>{{ number_format($data['level'], 2) }}</td>
                    <td>{{ number_format($data['trend'], 2) }}</td>
                    <td>{{ number_format($data['prediksi_f'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Aktual</th>
                    <th>Prediksi</th>
                    <th>|Error|</th>
                    <th>APE (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prediksiData as $data)
                    @if($data['tahun'] === '2023')
                    <tr>
                        <td>{{ $data['bulan'] }}</td>
                        <td>{{ $data['aktual_y'] }}</td>
                        <td>{{ number_format($data['prediksi_f'], 2) }}</td>
                        <td class="error-cell">{{ number_format(abs($data['aktual_y'] - $data['prediksi_f']), 2) }}</td>
                        <td class="{{ $data['ap'] <= 10 ? 'ape-low' : ($data['ap'] <= 20 ? 'ape-medium' : 'ape-high') }}">
                            {{ $data['ap'] ? number_format($data['ap'], 2) . '%' : '-' }}
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <style>
            .footer {
                margin-top: 30px;
                padding-top: 15px;
                border-top: 1px solid #e2e8f0;
            }
            .footer-info {
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: #718096;
                font-size: 12px;
            }
            .timestamp {
                color: #4a5568;
            }
            .developer {
                text-align: right;
                font-style: italic;
            }
            .system-info {
                margin-top: 5px;
                font-weight: 500;
                color: #2d3748;
            }
        </style>

        <div class="footer-info">
            <div class="timestamp">
                Generated on: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB
            </div>
            <div class="developer">
                Created by:
                <a href="#">Andreas Rezeki Zai</a>
            </div>
        </div>
        <div class="system-info">
            Sistem Informasi - Teknologi Informatika Anjay
        </div>
    </div>
</body>
</html>
