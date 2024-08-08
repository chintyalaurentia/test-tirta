<?php

namespace App\Http\Controllers;

use App\Models\MasterSales;
use App\Exports\SalesExport;
use App\Imports\SalesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class MasterSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['form'] = "create";
        return view('master.sales.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $kodes = $request->kode;
            $namaSalesArray = $request->nama;

            $dataToInsert = [];

            foreach ($kodes as $index => $kode) {
                $dataToInsert[] = [
                    'kode_sales' => $kode,
                    'nama_sales' => $namaSalesArray[$index],
                ];
            }

            MasterSales::insert($dataToInsert);

            return response()->json([
                'Code' => 200,
                'Message' => "Data Saved Successfully"
            ]);

        }
        catch (\Exception $e) {
            return response()->json([
                'Code' => 400,
                'Message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['dataModel'] = MasterSales::select('*')->where('kode_sales', $id)->first();
        $data['form'] = "edit";
        return view('master.sales.create', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            // Update the record based on the where clause
            $affectedRows = MasterSales::where('kode_sales', $id)->update([
                'kode_sales' => $request->kode,
                'nama_sales' => $request->nama,
            ]);

            // Check if any rows were affected
            if ($affectedRows > 0) {
                return response()->json([
                    'Code' => 200,
                    'Message' => "Data Updated Successfully"
                ]);
            } else {
                return response()->json([
                    'Code' => 404,
                    'Message' => "Sales record not found."
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'Code' => 400,
                'Message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the existing record by its ID
            $salesRecord = MasterSales::where('kode_sales', $id)->delete();

           if (!$salesRecord) {
                return response()->json([
                    'Code' => 404,
                    'Message' => "Sales record not found."
                ]);
            }

            // Return a JSON response indicating success
            return response()->json([
                'Code' => 200,
                'Message' => "Data Deleted Successfully"
            ]);

        } catch (\Exception $e) {
            // Return a JSON response indicating failure
            return response()->json([
                'Code' => 400,
                'Message' => $e->getMessage()
            ]);
        }
    }

    public function datatable(Request $request){
        $query = MasterSales::select('*')->orderBy('kode_sales', 'asc');

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function ($data) {
            $edit = "<a class='btn-action btn btn-warning btn-sm btn-edit' title='Edit' id='editBtn' href=".route('master.sales.edit',$data->kode_sales)."><i class='fa fa-solid fa-edit'></i></a>";

            $delete = "<button class='btn-action btn btn-danger btn-sm' title='Delete' id='deleteBtn' data-id='$data->kode_sales'><i class='fa fa-solid fa-trash'></i></button>";

            return '<div class="btn-group">'.$edit.$delete.'</div>';
        })

        ->rawColumns(['action','AssetHTML'])
        ->make(true);
    }


    public function import(Request $request){
        try {
            $file = $request->file('excel');

            $import = new SalesImport();
            $data = Excel::toArray($import, $file);

            //remove header
            array_shift($data[0]);

            //remove null row
            $data = array_filter($data[0], function($row) {
                return !empty(array_filter($row, 'strlen'));
            });
            // dd($data);
            return response()->json([
                'success' => true,
                'message' => 'Inject Data Berhasil.',
                'injected' => $data,
            ]);


        }
        catch (\Exception $ex) {
            dd($ex);
            return redirect()->back()->withErrors(['import' => $ex->getMessage()]);
        }
    }

    public function export(Request $request){
        $dataExport = new SalesExport();
        return Excel::download($dataExport, 'Sales List.xlsx');
    }
}
