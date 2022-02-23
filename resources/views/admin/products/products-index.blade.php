@extends('admin.layouts.app', ['page' => 'products'])
@section('title')
    View All Products
@stop
@section('scripts.header')

@stop
@section('content')
<product-create inline-template>
    <div>
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">All Products</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('admin.products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-utensils fa-sm text-white-50"></i> Add New Product</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                    <thead>
                    <tr role="row">
                        <th>Title</th>
                        <th>Price</th>
                        <th>SKU</th>
                        <th>Inventory</th>
                        <th>Weight</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>SKU</th>
                        <th>Inventory</th>
                        <th>Weight</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($products as $product)
                        <tr role="row" class="odd">
                            <td><a href="{{ route('admin.products.show', [$product->id]) }}" title="View Product"><strong>{{ $product->title }}</strong></a></td>
                            <td>${{ $product->price / 100 }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->inventory }}</td>
                            <td>{{ $product->weight }} grams</td>
                            <td>{{ $product->status }}</td>
                            <td>{{ $product->type }}</td>
                            <td class="text-center">
                                @if($product->image)
                                    <img style="height: 40px; width: auto;" src="/images/{{$product->image->filename}}">
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', [$product->id]) }}" class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                      <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">Edit Product</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</product-create>

@endsection
@section('scripts.footer')

@stop
