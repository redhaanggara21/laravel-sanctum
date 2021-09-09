<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penjualan;
use App\Models\Item_Penjualan;

class Api_penjualan extends Controller
{
    // Penjualan

    public function index(){
        //get data from table posts
        // $data = Penjualan::latest()->get();
        // $data = (new Penjualan($this->whenLoaded('')));
        $data = Penjualan::with('pelanggan','itemPenjualan','barangPenjualan',)->get();

        foreach($data as $key => $value ){
            // dd($value );
        }
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Penjualan',
            'data'    => $data  
        ], 200);
    }

    public function show($id)
    {
        $data = Penjualan::findOrfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Penjualan',
            'data'    => $data 
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'TOTAL' => 'required',
            'KODE_PELANGGAN' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json([
                'terbit' => $user,
                'sarang' => $validator->errors() 
            ],400);
        }
        
        // $token = $request->bearerToken();
        $datasPenjualan =  json_decode($request->ITEM_PENJUALAN);

        //save to database
        $data = Penjualan::create([
            'KODE_PELANGGAN' => $request->KODE_PELANGGAN,
            'TOTAL' => $request->TOTAL
        ]);

        foreach($datasPenjualan as $key => $value){
            Item_Penjualan::create([
                "KODE_BARANG" => $value->KODE_BARANG,
                "QTY" => $value->QTY,
                "NOTA_KODE"=> $data->id,
            ]);
        }

        //success save to database
        if($data) {
            return response()->json([
                // 'item penjualan' => $dataArray,
                'success' => true,
                'message' => 'Penjualan Created',
                'data'    => $data  
            ], 201);
        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    public function update(Request $request, $id)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'KODE_PELANGGAN' => 'required',
            'TOTAL' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $data = Penjualan::findOrFail($id);

        if($data) {

            //update post
            $data->update([
                'KODE_PELANGGAN' => $request->KODE_PELANGGAN,
                'TOTAL' => $request->TOTAL
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Updated',
                'data'    => $data  
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Data Not Found',
        ], 404);

    }

    public function destroy($id)
    {
        //find barang by ID
        $data = Penjualan::findOrfail($id);

        if($data) {

            //delete barang
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Data Not Found',
        ], 404);
    }
}
