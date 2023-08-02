@extends('master')

@section('content')

<div class="invoice-container">
    <div class="invoice-header">
        <h2 class="invoice-title" style="background-color: blue">Welcome {{$f_name}} {{$l_name}} To karachi city</h2>
    </div>
    <h3>You can join us after you pay. Bring the receipt to the branch to complete your registeration</h3>
    <div class="invoice-details">
        <table>
            <tr>
                <th>Admission fees</th>
                <th>1 month advance fee</th>
            </tr>
            <tr>
                <td>5000</td>
                <td>1000</td>
            </tr>
            <!-- Add more rows for additional items if needed -->
        </table>
    </div>
    <div class="invoice-total">
        <p>Total: 6000 RS</p>
    </div>
</div>


@endsection