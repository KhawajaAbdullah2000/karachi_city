<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .invoice-container {
            text-align: center;
        }

        .company-logo {
            max-width: 150px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
        }

        .branch-name {
            font-size: 16px;
            margin-top: 10px;
        }

        .player-info {
            font-size: 16px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-amount {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }


    </style>
</head>
<body>

    <div class="invoice-container">
        <img src="https://www.karachicityfc.com/img/external/KCFC_LOGO.svg" alt="Company Logo" class="company-logo">
        <div class="company-name">Karachi City Football Club</div>
        <div class="branch-name">Branch: {{$branch_name}}</div>

        <div class="player-info">
            <p>Player Name: {{$f_name}} {{$l_name}}</p>
            <p>Total Amount: {{$total_amount}}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Registeration Fee</td>
                    <td>{{$reg_fees}}</td>
                </tr>
                <tr>
                    <td>{{$month1}}</td>
                    <td>{{$month1_fees}}</td>
                </tr>
           @isset($month2)
           <tr>
            <td>{{$month2}}</td>
            <td>{{$month2_fees}}</td>
        </tr>
           @endisset

            </tbody>
        </table>

        <table>

            <tbody>
                <tr>
                    <td>Bank Name</td>
                    <td>Meezan Bank Limited (Dalton's Khadda Market Branch)</td>
                </tr>
                <tr>
                    <td>Account Name</td>
                    <td>KARACHI CITY FOOTBALL CLUB</td>
                </tr>
                <tr>
                    <td>Account Number</td>
                    <td>1660105259651</td>
                </tr>
                <tr>
                    <td>IBAN</td>
                    <td>PK29MEZN0001660105259651</td>
                </tr>
            </tbody>
        </table>

        <div class="total-amount">Total Amount: {{$total_amount}}</div>

        <p>Please email a snapshot of deposit slip or online transfer to admin@karachicityfc.com</p>
    </div>





</body>
</html>
