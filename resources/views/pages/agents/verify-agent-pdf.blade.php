<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Agent Verification Result</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        .wrap {
            padding: 28px;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .sub {
            color: #555;
            margin-bottom: 18px;
            font-size: 11px;
        }

        .badge {
            display: inline-block;
            vertical-align: middle;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 11px;
            letter-spacing: .05em;
        }

        .active {
            background: #E8F8EF;
            color: #157A3D;
            border: 1px solid #BFE9CF;
        }

        .suspended {
            background: #FDECEC;
            color: #B42318;
            border: 1px solid #F5C2C7;
        }

        .inactive {
            background: #F3F4F6;
            color: #374151;
            border: 1px solid #E5E7EB;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border: 1px solid #E5E7EB;
            vertical-align: top;
        }

        th {
            background: #F9FAFB;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6B7280;
            width: 25%;
        }

        .section {
            margin-top: 60px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #374151;
            margin-bottom: 8px;
        }

        .note {
            font-size: 11px;
            color: #555;
            line-height: 1.6;
        }

        .warning {
            background: #FDECEC;
            border: 1px solid #F5C2C7;
            padding: 12px;
            font-size: 11px;
            color: #7A1F1F;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="wrap">

        {{-- Header --}}
        <div class="title">Agent Verification Result</div>
        <div class="sub">
            Query: <strong>{{ $q }}</strong><br>
            Generated on: {{ $generatedAt->format('d M Y H:i') }}
        </div>

        @php
            $status = strtolower($agent->status ?? 'inactive');
            $cls = $status === 'active' ? 'active' : ($status === 'suspended' ? 'suspended' : 'inactive');
        @endphp

        <div>
            <span style="vertical-align: middle;">Status:</span>
            <span class="badge {{ $cls }}">{{ strtoupper($status) }}</span>
        </div>

        {{-- Agent Info --}}
        <table>
            <tr>
                <th>Agent ID</th>
                <td>{{ $agent->agent_code }}</td>
                <th>Full Name</th>
                <td>{{ $agent->name }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $agent->phone }}</td>
                <th>Region</th>
                <td>{{ $agent->region ?? '-' }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ $agent->role }}</td>
                <th>Last Updated</th>
                <td>{{ optional($agent->updated_at)->format('d M Y H:i') ?? '-' }}</td>
            </tr>
        </table>

        {{-- Status Definition --}}
        <div class="section">
            <div class="section-title">Status Definitions</div>
            <div class="note">
                <strong>Active</strong> – Authorized to represent the company<br>
                <strong>Suspended</strong> – Authorization revoked or under investigation<br>
                <strong>Inactive</strong> – No longer associated with the company
            </div>
        </div>

        {{-- Warning --}}
        @if ($status === 'suspended')
            <div class="warning">
                <strong>Safety Notice:</strong><br>
                This individual is currently suspended and is <u>not authorized</u> to conduct any business
                on behalf of the company. Please do not proceed with payments or share sensitive information.
            </div>
        @endif

        {{-- Official Contact --}}
        <div class="section">
            <div class="section-title">Official Contact & Payment Safety</div>

            <table>
                <tr>
                    <th>Official Website</th>
                    <td>{{ request()->getHost() }}</td>
                </tr>
                <tr>
                    <th>Official Support</th>
                    <td>cs@brinnovatefuture.com</td>
                </tr>
                <tr>
                    <th>Payment Policy</th>
                    <td>
                        Payments are accepted <strong>only</strong> via official company bank accounts
                        or approved payment gateways.
                    </td>
                </tr>
            </table>

            <div class="note" style="margin-top:10px;">
                The company will never request payments to personal accounts, cash transfers,
                gift cards, or cryptocurrencies.
            </div>
        </div>

        {{-- Disclaimer --}}
        <div class="section">
            <div class="section-title">Disclaimer</div>
            <div class="note">
                This document is system-generated and reflects the agent’s status at the time of issuance.
                Authorization status may change without prior notice. The company shall not be held
                responsible for transactions conducted outside official channels.
            </div>
        </div>

    </div>
</body>

</html>
