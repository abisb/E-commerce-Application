<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Invoice;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;
class OrderController extends Controller
{
    public function index()
    { 
       
        return view('order/list');
    }
    
    public function order_create()
    { 
    $product=Product::get();
    return view('order/create',array('product'=>$product));
    }
    public function getorder(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    $createdAt= Carbon::parse($data['created_at']);
                    $value= $createdAt->format('M d Y');
                       return  $value;
                   })
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="'.url('edit_ord/'.$data->id.'/edit').'" class="edit btn btn-success btn-sm">Edit</a> 
                    <a href="'.url('delete_ord/'.$data->id.'/delete').'" id="delete_ord" class="delete btn btn-danger btn-sm">Delete</a>

                    <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#genrate-invoice" order_id="'.$data->order_id.'"  id="generate_invoice" >Invoice</a>
                    
                    <script>
                    $(document).on("click","#delete_ord",function(e) {
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
    public function create(Request $request)
    {
        $data= $request->all();
        $order_id=rand(10000, 99999);
        $product_id=$request->product_id;
        $quantity=$request->quantity;
        $a=array();
        for ($i=0; $i<count($product_id); $i++)
         {
             $prod=Product::select('price')->where('id',$product_id[$i])->first(); 
             $price=$prod->price*$quantity[$i];
            array_push($a,$price);
         }
        $total= array_sum($a);

        for ($i=0; $i<count($product_id); $i++) {
            if ($product_id[$i]!='') {
                $data['product_id']=$product_id[$i];
                $data['quantity']=$quantity[$i];
                $data['order_id']=$order_id;
                $client = new Invoice;
                $client->fill($data);
                $client->save();
            }
        }
        Order::insert(
            array(
                   'customer_name'     =>   $data['customer_name'], 
                   'order_id'   =>   $order_id,
                   'phone'   =>   $data['phone'],
                   'total' =>$total,
                   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s')
            )
       );
        return redirect('order_list')->with('success','Order Successfully Created!');
    } 

    public function edit($id)
    {
     
        $product=Product::get();
        $order=Order::where('id',$id)->first();
        $orderID=$order->order_id;
        $data = Product::join('invoice', 'products.id', '=', 'invoice.product_id')->where('invoice.order_id',$orderID)
               ->get(['products.*', 'invoice.quantity','invoice.id','invoice.product_id']);   
        return view('order/edit',array('order'=>$order,'product'=>$product,'data'=>$data));
    }

    public function update(Request $request)
    {
        $data= $request->all();
        $order_id=$data['order_id'];
        $product_id=$request->product_id;
        $quantity=$request->quantity;
        $a=array();
        for ($i=0; $i<count($product_id); $i++)
         {
             $prod=Product::select('price')->where('id',$product_id[$i])->first(); 
             $price=$prod->price*$quantity[$i];
            array_push($a,$price);
         }
        $total= array_sum($a);
        $delete_invoice=Invoice::where('order_id', $order_id)->delete();
        if($delete_invoice){
        for ($i=0; $i<count($product_id); $i++) 
        {
            if ($product_id[$i]!='') {
                $data['product_id']=$product_id[$i];
                $data['quantity']=$quantity[$i];
                $data['order_id']=$order_id;
                $client = new Invoice;
                $client->fill($data);
                $client->save();
                                    }
        }
                         }
        Order::where('id',$data['id'])->update(
            array(
                   'customer_name'     =>   $data['customer_name'], 
                   'order_id'   =>   $order_id,
                   'phone'   =>   $data['phone'],
                   'total' =>$total,
                   'updated_at' => date('Y-m-d H:i:s')
            )
       );
        return redirect('order_list')->with('success','Order Successfully Updated!');
    }

    public function delete($id)
    {
        $ordr_id=Order::select('order_id')->where('id',$id)->first();
        Invoice::where('order_id',$ordr_id->order_id)->delete();
        Order::where('id',$id)->delete();
        return redirect()->back()->with([
            'success' => 'Successfully Deleted!'
         ]);
        
    } 

    public function get_invoice(Request $request)
    {
        $order_id= $request->order_id;
        $total=Order::select('total')->where('order_id',$order_id)->first();
        $shares = Invoice::join('orders', 'orders.order_id', '=', 'invoice.order_id')
        ->join('products', 'products.id', '=', 'invoice.product_id')
        ->where('invoice.order_id', '=', $order_id)
        ->get();

        $model='<div class="ui segment cards">
    <div class="ui card customercard">
      <div class="content">
        <ul>
         <strong> ORDER ID: </strong> '.$order_id.'
        </ul>
      </div>
    </div>

    <div class="ui segment itemscard">
      <div class="content">
        <table class="ui celled table">
          <thead>
            <tr>
              <th>Products</th>
              <th class="text-center colfix">Quantity</th>
              <th class="text-center colfix">Price</th>
            </tr>
          </thead>
          <tbody>';
          foreach($shares as $value){
            $model .='<tr>
              <td>
               '.$value->product_name.'
              </td>
              <td class="text-right">
                <span class="mono">'.$value->quantity.'</span>
              </td>
              <td class="text-right">
                <span class="mono">'.$value->price.'</span>
              </td>
            </tr>';
          }
          $model .=' </tbody>
         <tfoot class="full-width">
    <tr>
      <th> Total: </th>
      <th colspan="1"></th>
      <th colspan = "1">'.$total->total.' </th>
    </tr>
  </tfoot>
        </table>

      </div>
    </div>
</div>';
        return $model;
    }
}
