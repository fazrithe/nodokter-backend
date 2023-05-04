<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\FileCategory;
use App\Models\Question;
use App\Models\Tryout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Models\UserAnswer;
use Faker\Provider\UserAgent;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::orderBy('id','DESC')->paginate(10);
        $search = '';
        return view('pages.products.index',compact('data','search'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.products.create');
    }


      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'file' => 'required|mimes:png,jpg|max:10000'
        ]);

        $file = $request->file('file');
        $productModel = new Product();
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('images', $fileName, 'public');
            $productModel->user_id = Auth::user()->id;
            $productModel->name = $request->name;
            $productModel->price = $request->price;
            $productModel->image_name = time().'_'.$request->file->getClientOriginalName();
            $productModel->image_path = '/storage/' . $filePath;
            if(!empty($request->status)){
                $productModel->status = $request->status;
            }else{
                $productModel->status = "disabled";
            }
            $productModel->save();
            return redirect()->route('products')
            ->with('success','Product created successfully');
        }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $publish = [
            'on'=> 'on',
            'off'=> 'off'
        ];
        return view('pages.products.edit',compact('product','publish'));
    }

       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required'
        ]);

        $file = $request->file('file');
        if($request->file()) {
            $productModel = Product::find($id);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('images', $fileName, 'public');
            $productModel->user_id = Auth::user()->id;
            $productModel->name = $request->name;
            $productModel->price = $request->price;
            $productModel->image_name = time().'_'.$request->file->getClientOriginalName();
            $productModel->image_path = '/storage/' . $filePath;
            if(!empty($request->status)){
                $productModel->status = "enabled";
            }else{
                $productModel->status = "disabled";
            }
            $productModel->save();
            return redirect()->route('products')
            ->with('success','Product created successfully');
        }else{
            $productModel = Product::find($id);
            $productModel->user_id = Auth::user()->id;
            $productModel->name = $request->name;
            $productModel->price = $request->price;
            if(!empty($request->status)){
                $productModel->status = $request->status;
            }else{
                $productModel->status = "disabled";
            }
            $productModel->save();
            return redirect()->route('products')
            ->with('success','Product created successfully');
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Product::findOrFail($id);
        if (file_exists(public_path($file->image_path))){
            $filedeleted = unlink(public_path($file->image_path));
            if ($filedeleted) {
               echo "File deleted";
            }
         } else {
            dd('Unable to delete the given file');
         }
         $file->delete();
        return redirect()->route('products')
                        ->with('success','Product deleted successfully');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $search = '';
        return view('pages.tryouts.list',compact('search'))
            ->with('i', ($request->input('page', 1) - 1) * 6);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        return view('pages.tryouts.view');
    }


}
