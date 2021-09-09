<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_penjualan;
use Illuminate\Support\Facades\Validator;

class Api_item_penjualan extends Controller
{
    // api item penjualan

    public function index(){
        //get data from table posts
        $data = Item_penjualan::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Item Penjualan',
            'data'    => $data  
        ], 200);
    }

    public function show($id)
    {
        $data = Item_penjualan::findOrfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Item Penjualan',
            'data'    => $data 
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'NOTA_KODE' => 'required',
            'KODE_BARANG' => 'required',
            'QTY' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $data = Item_penjualan::create([
            'NOTA_KODE' => $request->NOTA_KODE,
            'KODE_BARANG' => $request->KODE_BARANG,
            'QTY' => $request->QTY,
        ]);

        //success save to database
        if($data) {

            return response()->json([
                'success' => true,
                'message' => 'Item Penjualan Created',
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
            'NOTA_KODE' => $request->NOTA_KODE,
            'KODE_BARANG' => $request->KODE_BARANG,
            'QTY' => $request->QTY,
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $data = Item_penjualan::findOrFail($id);

        if($data) {

            //update post
            $data->update([
                'NOTA_KODE' => $request->NOTA_KODE,
                'KODE_BARANG' => $request->KODE_BARANG,
                'QTY' => $request->QTY,
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
        $data = Item_Penjualan::findOrfail($id);

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
