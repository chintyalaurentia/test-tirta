<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <title>Total Transaksi Sales</title>
    <style>
        body {
            padding-top: 1cm;
            font-family:  Arial, Helvetica, sans-serif;
            /* background-color: red; */
        }
        .judul {
            width: 100%;

        }
        .judul .colon {
            display: inline-block;
            width: 1.5cm;
            text-align: left;
        }
        .judul .word {
            display: inline-block;
            width: 5cm;
            text-align: left;
        }
        .judul td p {
            margin-bottom: -0.3cm;
            text-align: left;
            /* border: 1px solid black;
            border-collapse: collapse; */
        }
        .tableItem {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1cm;
            /* margin-bottom: 1.5cm; */
        }
        .tableItem th {
            text-align: center;
            padding: 10px;
            border: 1px solid black;
            font-size: 12pt;
        }
        .tableItem tbody tr {
            border: 1px solid black;
            font-size: 12pt;
        }
        .tableItem td {
            /* padding: 0.2cm; */
            border: 1px solid black;
            text-align: center;
            font-size: 12pt;
            /* background-color: red; */
        }
        .tableItem img{
            width: 100%;
        }
        .ttd {
            align-items: center;
            margin: 2px auto;
            page-break-inside: avoid !important;
        }
        .ttd td{
            /* background-color: red;
            border: 1px solid black;
            border-collapse: collapse; */
            text-align: center;
            width: 10cm;
        }
        .ttd img{
            width: 50%;
            padding: -10cm;
        }
    </style>
</head>
<body>
    <p>
        Berikut ini adalah total transaksi dari sales yang telah dilakukan:
    </p>

    <table class="tableItem">
        <thead>
            <th style="width:1cm;">No</th>
            <th style="width:3cm;">Nama Sales</th>
            <th style="width: 3cm">Nominal</th>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach($data as $item)
            <tr>
                <td>{{$no}}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nominal }}</td>
            </tr>
            @php
                $no++;
            @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
