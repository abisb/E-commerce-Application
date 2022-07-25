<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
class CategoryController extends Controller
{
    public function index()
    { 
       
        return view('category/list');
    }
    public function getcategory(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="'.url('edit_cat/'.$data->id.'/edit').'" class="edit btn btn-success btn-sm">Edit</a> 
                    <a href="'.url('delete_cat/'.$data->id.'/delete').'" id="delete_cat" class="delete btn btn-danger btn-sm">Delete</a>
                    <script>
                    $(document).ready(function () {
                        $(document).on("click","#delete_cat",function(e) {
                        e.preventDefault(e);
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
                });
                    </script>';
                    return $actionBtn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function category_create()
    { 
       
        return view('category/create');
    }

    public function create(Request $request)
    {
        $data=$request->all();
        $cbvcmandate= new Category;
        $cbvcmandate->fill($data);
        $cbvcmandate->save();
        return redirect('category_list')->with('success','Successfully Created!');
    }  
    public function delete($id)
    {
        Category::where('id',$id)->delete();
        return redirect()->back()->with([
            'success' => 'Successfully Deleted!'
         ]);
        
    }  

    public function edit($id)
    {
        $category=Category::where('id',$id)->first();
        return view('category/edit',array('category'=>$category));
    }
    public function update(Request $request)
    {
        $data = request()->except(['_token']);
        Category::where("id",$data['id'])->update($data);
        return redirect('category_list')->with('success','Successfully Updated!');
    }
}
