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
                                    <h3 class="section-title">Edit Category</h3>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">Category Form(Edit)</h5>
                                    <div class="card-body">
                                    <form action="{{route('category.update')}}" method="POST" enctype="multipart/form-data" id="caretgory_form">
                                             @csrf
                                             @if(@$category->id)
                                            <input type="hidden" name="id" value="{{$category->id}}" />
                                            @endif
                                            <div class="form-group">
                                                <label for="category" class="col-form-label">Category Name</label>
                                                <input name="category_name" type="text" class="form-control" value="{{$category->category_name}}" placeholder="Enter category name">
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
    $("#caretgory_form").validate({
      ignore: "",
      rules: {
        category_name: {
          required: true,
        },
      }
    });
  });
  </script>

@stop