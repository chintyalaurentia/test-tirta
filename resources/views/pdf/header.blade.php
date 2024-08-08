<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <title>Surat Jalan Transfer Eksternal</title>
    <style>

        header {
            margin-left: 0.2cm;
            margin-top: 1cm;
            display: flex;
            align-items: center;
            /* padding-bottom: 1cm; */
            /* padding-top: 1cm; */
            /* background-color: red; */
        }
        img {
            height: 1.5cm;
            margin-right: 10px;
        }
        h3 {
            margin: 0;
            font-weight: bold;
        }
        /* td{
            width: 7cm;
        }
        .text-left{
            text-align: left!important;
        } */
        /* table{
            margin-bottom: 5cm !important;
        } */
    </style>
</head>
<body>
    {{-- <p>{{$id}}</p> --}}
    <header>
        <table>
            <tr>
                <td style="width: 3cm;"><img src="{{ asset('images/logo-tirta.png') }}" alt="Logo"></td>
                <td style="width: 9cm; font-size: 0.6cm;"><h3>PT. Tirtawarna Tatakencana</h3></td>
                <td style="width: 9cm;"><h3>Total Transaksi Sales</h3></td>
            </tr>
        </table>
    </header>
</body>
</html>
