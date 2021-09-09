<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\User;


class AuthController extends Controller
{

    public function index(){

        $data = User::latest()->where('status', 'active')
        ->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data'    => $data  
        ], 200);
    }


    public function index_all(){

        $data = User::latest()->get();
        // ->where('status', 'active')
        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data'    => $data  
        ], 200);
    }

    public function login(Request $request) {
        $validate = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            $respon = [
                'status' => 'error',
                'msg' => 'Validator error',
                'errors' => $validate->errors(),
                'content' => null,
            ];
            return response()->json($respon, 200);
        } else {
            $credentials = request(['email', 'password']);
            $credentials = Arr::add($credentials, 'status', 'active');
            if (!Auth::attempt($credentials)) {
                $respon = [
                    'status' => 'error',
                    'msg' => 'Unathorized',
                    'errors' => null,
                    'content' => null,
                ];
                return response()->json($respon, 401);
            }

            $user = User::where('email', $request->email)->first();
            if (! \Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $user->createToken('token-auth')->plainTextToken;
            $respon = [
                'status' => 'success',
                'msg' => 'Login successfully',
                'errors' => null,
                'content' => [
                    'status_code' => 200,
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                ]
            ];
            return response()->json($respon, 200);
        }
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $respon = [
            'status' => 'success',
            'msg' => 'Logout successfully',
            'errors' => null,
            'content' => null,
        ];
        return response()->json($respon, 200);
    }

    public function logoutall(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        $respon = [
            'status' => 'success',
            'msg' => 'Logout successfully',
            'errors' => null,
            'content' => null,
        ];
        return response()->json($respon, 200);
    }

    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'GENDER' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // $input['status'] = $input['status'];
        
        $user = User::create($input);
        // $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['token']  = $user->createToken('token-auth')->plainTextToken;
        $success['name'] =  $user->name;

        return response()->json([
            'success' => true,
            'message' => 'User Created',
            'data'    => $success  
        ], 201);
        
        // return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }



    public function update(Request $request, $id)
    {
        //set validation
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            // 'password' => 'required',
            // 'c_password' => 'required|same:password',
            'GENDER' => 'required',
            'status' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID
        $data = User::findOrFail($id);

        if($data) {

            //update post
            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'GENDER' => $request->GENDER,
                'status'    => $request->status
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

    // public function destroy($id)
    // {
    //     //find barang by ID
    //     $data = Penjualan::findOrfail($id);

    //     if($data) {

    //         //delete barang
    //         $data->delete();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data Deleted',
    //         ], 200);

    //     }

    //     //data post not found
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Data Not Found',
    //     ], 404);
    // }

}
