@extends('layouts.home')
@section('page-title','Products')

@section('content')
    <a  href="{{route('products.create')}}" class="btn btn-success  " style="float: right">Add Product</a>
    @include('admin.alert.success')
    @include('admin.alert.error')
<table class="table ">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Category</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i=0;?>
    @forelse($products as $product )
    <tr>
        <?php $i++;?>
        <td>{{$i}}
        <td>{{$product->name}}</td>
        <td><img style="width: 150px; height: 100px;" src="{{$product->image}}"></td>
        <td>{{$product->categories->name}}</td>
        <td>{{$product->name}}</td>
        <td>{{$product->name}}</td>
        <td>
            <a href="{{route('products.edit',$product->id)}}" class="btn btn-info btn-sm fa fa-edit" role="button" aria-pressed="true"> </a>
            <a  href="{{route('products.delete',$product->id)}}" class="btn btn-danger btn-sm fa fa-trash" >  </a>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No Products</td>
        </tr>
    @endforelse

    </tbody>
</table>
@endsection
