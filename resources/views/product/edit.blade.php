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
                                    <h3 class="section-title">Edit Product</h3>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">Product Form(Edit)</h5>
                                    <div class="card-body">
                                    <form action="{{route('product.update')}}" method="POST" enctype="multipart/form-data" id="product_form">
                                             @csrf
                                            
                                             @if(@$product->id)
                                            <input type="hidden" name="id" value="{{$product->id}}" />
                                            @endif
                                            <div class="form-group">
                                                <label for="product_name" class="col-form-label">Product Name</label>
                                                <input name="product_name" type="text" class="form-control" value="{{@$product->product_name}}" placeholder="Enter Product name" >
                                            </div>
                                            <div class="form-group">
                                                <label for="category" class="col-form-label">Category</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                <option value="">Select Category</option> 
                                                    @foreach($category as $cat)
                                                    <option value="{{ $cat->id}}" @if($cat->id==$product->category_id) selected @endif>{{$cat->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="price" class="col-form-label">Price</label>
                                                <input name="price" type="text" class="form-control" placeholder="Enter Product price" value="{{@$product->price}}">
                                            </div>
                                            <div class="form-group">
                                            <img src="{{URL::asset('/products/'.$product->image.'')}}" alt="product Pic" height="100" width="100">
                                            </div>
                                            <input type="hidden" name="image_name" value="{{$product->image}}" />
                                            <div class="form-group">
                                                <label for="image" class="col-form-label">Product Image</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
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
   
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    $(document).ready(function () {
        
    $("#product_form").validate({
      ignore: "",
      rules: {
        product_name: {
          required: true,
        },
        category_id: {
          required: true,
        },
        price: {
          required: true,
        },

      }
    });
  });
  </script>

@stop