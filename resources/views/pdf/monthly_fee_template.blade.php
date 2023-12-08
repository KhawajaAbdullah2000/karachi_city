<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Bill - {{$month}} {{$year}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Fee Bill - {{$month}} {{$year}}</h2>

    <p>
        <strong>Student ID:</strong> {{$id}}<br>
        <strong>Student Name:</strong> {{$f_name}} {{$l_name}}
    </p>

    <p>Dear Parent/Participant,<br>
        Please refer to the attachment of your fee bill for the month of {{$month}} {{$year}}. Read below important
        information regarding fee payment for {{$month}} {{$year}}:</p>

    <ol>
        <li><strong>Due Date:</strong>
            <p>
                The fee bill for {{$month}} {{$year}} is attached for your reference. The due date for payment
                is {{$due_date}}. If the fee payment is not received by the due date, a grace period will
                be offered until {{$grace_period}}, after which students will not be permitted to attend any
                sessions until all dues are cleared. If, due to unavoidable reasons, you cannot make the
                payment within the due date, please email us before the due date. We will schedule a
                meeting to understand the reasons and discuss the next steps.
            </p>
        </li>
        <li><strong>Payment Methods:</strong>
            <p>
                The following payment methods can be used for fee payment:
            </p>
            <ol type="a">
                <li>Payment at any Meezan Bank Branch  Across Pakistan</li>
                <li>Payment via online banking</li>
            </ol>
        </li>
        <li><strong>Bank Details:</strong>
            <table>
                <tr>
                    <th>Bank</th>
                    <th>Account Name</th>
                    <th>IBAN</th>
                    <th>Account Number</th>
                </tr>
                <tr>
                    <td>Meezan Bank Limited, Khy-e-Shamsheer</td>
                    <td>KARACHI CITY FOOTBALL CLUB</td>
                    <td>PK29MEZN0001660105259651</td>
                    <td>01660105259651</td>
                </tr>
            </table>
        </li>
        <li><strong>Payment Receipt:</strong>
            <p>
                Once payment has been made, the payment receipt must be submitted to
                <a href="mailto:admin@karachicityfc.com">admin@karachicityfc.com</a>
            </p>
            <p>For payments via online banking: A screenshot of the online fund transfer will be used as the
                payment receipt. You can email this to us at <a href="mailto:admin@karachicityfc.com">admin@karachicityfc.com</a></p>
        </li>
    </ol>

    <p>If you require any guidance and/or further clarity, please feel free to contact us. The contact details are
        provided below:</p>
    <p>Email: <a href="mailto:admin@karachictyfc.com">admin@karachictyfc.com</a> or WhatsApp 0348-KHICITY (544-2489)</p>

    <p>Regards,<br>
        Management<br>
        Karachi City FC.</p>
</div>

</body>
</html>
