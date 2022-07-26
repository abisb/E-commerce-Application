@extends('layouts.app')
@section('content')
<style>
     .error {
        color: red;  
         }
</style>
</head>
<body>
<div class="container mt-5">
@if (session()->has('success'))
    <div class="alert alert-dismissable alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            {!! session()->get('success') !!}
        </strong>
    </div>
@endif
                    <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="section-block" id="basicform">
                                    <h3 class="section-title">Create Order</h3>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">Order Form</h5>
                                    <div class="card-body">
                                    <form action="{{route('order.create')}}" method="POST" enctype="multipart/form-data" id="order_form">
                                             @csrf
                                            <div class="form-group">
                                                <label for="customer_name" class="col-form-label">Customer Name</label>
                                                <input name="customer_name" type="text" class="form-control" placeholder="Enter customer name" required=""  >
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">Phone Number</label>
                                                <input name="phone" type="text" class="form-control" placeholder="Enter Phone Number" required="" >
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="category" class="col-form-label">Product</label>
                                                <select name="product_id[]" id="product_id" class="form-control" required="" >
                                                <option value="">Select Product</option> 
                                                @foreach($product as $prod)
                                                <option value="{{$prod->id}}">{{$prod->product_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label for="quantity" class="col-form-label">Quantity</label>
                                                <input name="quantity[]" type="number" class="form-control" name="quantity" required="" min="1" >
                                            </div>
                                            <div id="TextBoxContainer">

                                            </div>
                                            <div class="input-group-btn float-right"> 
                                            <button class="btn btn-success" type="button" id="btnAdd"><i class="glyphicon glyphicon-plus"></i> Add More Products +</button>
                                            </div>
                                            <br>
                                        
                                            <tr>
                                            <td colspan="2" align="center">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </td>
                                        </tr>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                     <div class="copy hide " style="display:none;">
                     <div class="form-group">
                                                <label for="category" class="col-form-label">Product</label>
                                                <select name="product_id[]" id="product_id" class="form-control" required="" >
                                                <option value="">Select Product</option> 
                                                @foreach($product as $prod)
                                                <option value="{{$prod->id}}">{{$prod->product_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label for="quantity" class="col-form-label">Quantity</label>
                                                <input name="quantity[]" type="number" class="form-control" name="quantity" required="" min="1" >
                                            </div>
                    </div>
   
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    $(document).ready(function () {
        
    // $("#order_form").validate({
    //   ignore: "",
    //   rules: {
    //     customer_name: {
    //       required: true,
    //     },
    //     phone: {
    //       required: true,
    //     },
    //     "product_id[]": {
    //       required: true,
    //     },
    //     "quantity[]": {
    //       required: true,
    //     },
    //   }
    // });
  });

  $(document).ready(function() {
    $(function () {
    $("#btnAdd").bind("click", function () {
        var div = $("<div />");
        div.html(GetDynamicTextBox(""));
        $("#TextBoxContainer").append(div);
    });
    $("#btnGet").bind("click", function () {
        var values = "";
        $("input[name=DynamicTextBox]").each(function () {
            values += $(this).val() + "\n";
        });
        alert(values);
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("div").remove();
    });
});
function GetDynamicTextBox(value) {
    var html = $(".copy").html();
    return html+'<input type="button" value="Remove" class="remove btn btn-danger" />'
}

});
  </script>

@stop