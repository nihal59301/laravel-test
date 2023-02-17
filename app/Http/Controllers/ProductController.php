<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ProductModel;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string'],
            'price'=>['required', 'numeric'],
            'ProductDescription'=> ['required', 'string'],
            'user_id'=> ['required'],
            'ProductImg'=>['required','mimes:jpg,jpeg,png']
        ]);
        $image=time().'.'.$request->ProductImg->extension();
        $request->ProductImg->move(public_path('productImage'),$image); 


        $prodcut = ProductModel::create([
            'name'=> $request->name,
            'model'=> $request->model,
            'price'=> $request->price,
            'ProductDescription'=> $request->ProductDescription,
            'user_id'=> $request->user_id,
            'ProductImg'=>$image,
            'is_active'=>1
            
        ]);
        if($prodcut){
            return response()->json([
                'code' => '200',
                'status' => 'Success',
            ]);
        }
        else{
            return response()->json([
                'code' => '500',
                'status' => 'error',
            ]);
        }

    }

    public function productlist(Request $request){
        // dd($request->toArray());
        $data=ProductModel::where('user_id','=',$request->user_id)->where('is_active',1)->orderBy('id', 'DESC')->get();
            return response()->json([
                'code' => '200',
                'status' => 'Success',
                'data'=>$data
            ]);
    }



    public function productdelete(Request $request){
        return ProductModel::where('id', $request->product_id)->update([
            'is_active' => 0,
        ]);
    }

    public function itemlist(){
        $data=ProductModel::where('is_active',1)->get();
        return response()->json([
            'code' => '200',
            'status' => 'Success',
            'data'=>$data
        ]);
    }
    public function userlist(){
        $data=User::where('is_active',1)->get();
        return response()->json([
            'code' => '200',
            'status' => 'Success',
            'data'=>$data
        ]);
    }

    public function deleteuser(Request $request){
        return User::where('id', $request->user_id)->update([
            'is_active' => 0,
        ]);
    }

    public function update(Request $request, $key){
        $id=$key;
        return view('editProduct',compact('id'));
    }
    public function getData(Request $request, $key,$id){
        // dd($id);
        $data=ProductModel::where('id','=',$id)->where('is_active',1)->first();
        return response()->json([
            'code' => '200',
            'status' => 'Success',
            'data'=>$data
        ]);
    }


    public function updateData(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string'],
            'price'=>['required', 'numeric'],
            'ProductDescription'=> ['required', 'string'],
            'user_id'=> ['required'],
            'ProductImg'=>['required','mimes:jpg,jpeg,png']
        ]);
        $image=time().'.'.$request->ProductImg->extension();
        $request->ProductImg->move(public_path('productImage'),$image); 
        return ProductModel::where('id', $request->editId)->update([
            'name'=> $request->name,
            'model'=> $request->model,
            'price'=> $request->price,
            'ProductDescription'=> $request->ProductDescription,
            'user_id'=> $request->user_id,
            'ProductImg'=>$image,
            'is_active'=>1
        ]);

    }
}
