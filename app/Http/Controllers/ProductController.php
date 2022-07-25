<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use DataTables;
use Illuminate\Support\Str;
use URL;
class ProductController extends Controller
{
    public function index()
    { 
       
        return view('product/list');
    }
    public function getproduct(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::join('category', 'products.category_id', '=', 'category.id')
               ->get(['products.*', 'category.category_name']);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="'.url('edit_prod/'.$data->id.'/edit').'" class="edit btn btn-success btn-sm">Edit</a> 
                    <a href="'.url('delete_prod/'.$data->id.'/delete').'" id="delete_prod" class="delete btn btn-danger btn-sm">Delete</a>
                    <script>
                    $(document).on("click","#delete_prod",function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You wont be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Confirm"
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = $(this).attr("href");
                            }
                        });
                    })
                    </script>';
                    return $actionBtn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function product_create()
    { 
        $category=Category::get();
        return view('product/create',array('category'=>$category));
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $input['products_name'] = $request->product_name;
        $input['price'] = $request->price;
        $input['category_id'] = $request->category_id;
        if(!empty($request->image)){
        $imageName = str_random(15).time().'.'.$request->image->extension();     
        $request->image->move(public_path('products'), $imageName);
        $input['image'] = $imageName;
        }
        $client = new Product;
        $client->fill($input);
        $client->save();
        return redirect('product_list')->with('success','Product Successfully Created!');
    } 
    public function edit($id)
    {
     
        $category=Category::get();
        $product=Product::where('id',$id)->first();
        return view('product/edit',array('product'=>$product,'category'=>$category));
    }
    public function update(Request $request)
    {
        $input = $request->all();
        if(!empty($request->image))
        {
        $image_path = public_path("products/$request->image_name");   
        unlink($image_path);
        $imageName = str_random(15).time().'.'.$request->image->extension();     
        $request->image->move(public_path('products'), $imageName);
        $input['image'] = $imageName;
        }
       $product_detail = Product::find($request->id);
       if (!$product_detail) {
           abort(404);
       }
      
       $input['products_name'] = $request->products_name;
       $input['price'] = $request->price;
       $input['category_id'] = $request->category_id;
       $product_detail->fill($input);
       $product_detail->save();
       return redirect('product_list')->with('success', 'Successfully Edited!');
    }
    public function delete($id)
    {
        Product::where('id',$id)->delete();
        return redirect()->back()->with([
            'success' => 'Successfully Deleted!'
         ]);
        
    }  
}
