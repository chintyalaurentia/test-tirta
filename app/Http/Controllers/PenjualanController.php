<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Imports\PenjualanImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['form'] = "create";
        return view('penjualan.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $kodes = $request->kode;
            $namaSalesArray = $request->nominal;

            $dataToInsert = [];

            foreach ($kodes as $index => $kode) {
                $dataToInsert[] = [
                    'kode_toko' => $kode,
                    'nominal_transaksi' => $namaSalesArray[$index],
                ];
            }

            Penjualan::insert($dataToInsert);

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
    public function edit(string $id)
    {
        $data['dataModel'] = Penjualan::select('*')->where('kode_toko', $id)->first();
        $data['form'] = "edit";
        return view('penjualan.create', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            // Update the record based on the where clause
            $affectedRows = Penjualan::where('kode_toko', $id)->update([
                'kode_toko' => $request->kode,
                'nominal_transaksi' => $request->nominal,
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
            $salesRecord = Penjualan::where('kode_toko', $id)->delete();

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

    public function import(Request $request){
        try {
            $file = $request->file('excel');

            $import = new PenjualanImport();
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

    public function datatable()
    {
        $query = Penjualan::select('*')->orderBy('kode_toko', 'asc');

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function ($data) {
            $edit = "<a class='btn-action btn btn-warning btn-sm btn-edit' title='Edit' id='editBtn' href=".route('penjualan.edit',$data->kode_toko)."><i class='fa fa-solid fa-edit'></i></a>";

            $delete = "<button class='btn-action btn btn-danger btn-sm' title='Delete' id='deleteBtn' data-id='$data->kode_toko'><i class='fa fa-solid fa-trash'></i></button>";

            return '<div class="btn-group">'.$edit.$delete.'</div>';
        })

        ->rawColumns(['action','AssetHTML'])
        ->make(true);
    }

    public function export(Request $request){
        $dataExport = new PenjualanExport();
        return Excel::download($dataExport, 'List Penjualan.xlsx');
    }
}
