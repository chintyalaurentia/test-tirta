<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\MasterSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function datatable(Request $request){
        $query = "SELECT
                d.nama_sales AS 'kode',
                FORMAT(SUM(b.nominal_transaksi), 2, 'de_DE') AS 'nominal'
            FROM
                table_a a
            LEFT JOIN
                table_b b ON a.kode_toko_baru = b.kode_toko OR a.kode_toko_lama = b.kode_toko
            JOIN
                table_c c ON b.kode_toko = c.kode_toko
            JOIN
                (
                    SELECT
                        c.area_sales,
                        MAX(d.kode_sales) AS kode_sales
                    FROM
                        table_c c
                    JOIN
                        table_d d ON c.area_sales = LEFT(d.kode_sales, 1)
                    GROUP BY
                        c.area_sales
                ) recent_sales ON c.area_sales = recent_sales.area_sales
            JOIN
                table_d d ON recent_sales.kode_sales = d.kode_sales
            GROUP BY
                d.nama_sales
            ORDER BY
                d.nama_sales";

        $query = DB::select($query);

        return DataTables::of($query)
        ->addIndexColumn()
        // ->addColumn('action', function ($data) {
        //     $print = "<a class='btn-action btn btn-info btn-sm btn-print' title='Print' id='printBtn' href='".route('transaction.show', $data->kode)."'><i class='fa fa-print' aria-hidden='true'></i></a>";

        //     return '<div class="btn-group">'.$print.'</div>';
        // })

        // ->rawColumns(['action','AssetHTML'])
        ->make(true);
    }

    public function export()
    {
        $query = "SELECT
                d.nama_sales AS 'kode',
                FORMAT(SUM(b.nominal_transaksi), 2, 'de_DE') AS 'nominal'
            FROM
                table_a a
            LEFT JOIN
                table_b b ON a.kode_toko_baru = b.kode_toko OR a.kode_toko_lama = b.kode_toko
            JOIN
                table_c c ON b.kode_toko = c.kode_toko
            JOIN
                (
                    SELECT
                        c.area_sales,
                        MAX(d.kode_sales) AS kode_sales
                    FROM
                        table_c c
                    JOIN
                        table_d d ON c.area_sales = LEFT(d.kode_sales, 1)
                    GROUP BY
                        c.area_sales
                ) recent_sales ON c.area_sales = recent_sales.area_sales
            JOIN
                table_d d ON recent_sales.kode_sales = d.kode_sales
            GROUP BY
                d.nama_sales
            ORDER BY
                d.nama_sales";

        $query = DB::select($query);
        $result = collect($query);

        $pdf = PDF::loadView('pdf.content',['data' => $result]);


        $pdf->setOptions([
            'header-html' => View::make('pdf.header',['title' => 'Total Transaksi Sales']),
            'margin-top'=> '2.5cm',
            'margin-bottom'=> '0.3cm',
            'margin-left' => '0.3cm',
            'margin-right' => '0.3cm',
        ]);
        $pdf->setPaper('a4');
        $filename = "Total Transaksi Sales.pdf";

        return $pdf->inline($filename);

    }

}
