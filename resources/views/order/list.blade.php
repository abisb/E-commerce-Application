@extends('layouts.app')
@section('content')
<style>
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}

body{
  background:#EEE;
  /* font-size:0.9em !important; */
}

.bigfont {
  font-size: 3rem !important;
}
.invoice{
  width:970px !important;
  margin:50px auto;
}

.logo {
  float:left;
  padding-right: 10px;
  margin:10px auto;
}

dt {
float:left;
}
dd {
float:left;
clear:right;
}

.customercard {
  min-width:65%;
}

.itemscard {
  min-width:98.5%;
  margin-left:0.5%;
}

.logo {
  max-width: 5rem;
  margin-top: -0.25rem;
}

.invDetails {
  margin-top: 0rem;
}

.pageTitle {
  margin-bottom: -1rem;
}

    </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
<div class="create_stud">
    <a href="{{ url('order_create') }}" type="button" class="btn btn-primary" style="float: right;">Create Order +</a>
</div>

    <h2 class="mb-4">Orders</h2>
    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Net Amount</th>
                <th>Order Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<!-- Modal -->
<div class="genrate-invoice-wrapp modal fade " id="genrate-invoice" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modalmd modal-lg" role="document">
        <div class="modal-content">
           
        </div>
    </div>
</div>
<!-- Modal -->
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script type="text/javascript">
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('order.listing') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'order_id', name: 'order_id'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'phone', name: 'phone'},
            {data: 'total', name: 'total'},
            {data: 'created_at', name: 'created_at'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });


  $(document).on('click', '#generate_invoice', function()
  {
        action_url = "{{ route('get_invoice') }}";
        var order_id = $(this).attr('order_id');
        $.ajax({
        url :action_url,
        data:{order_id:order_id},
        success:function(model)
        {
        $('.modal-content').html(model);
        }
        })
});
</script>
@stop