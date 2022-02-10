@extends('layouts.admin')
@section('page-title','Products')

@section('content')
    @can('products.create')
    <a  href="{{route('products.create')}}" class="btn btn-success m-1 " style="float: right">Add Product</a>
    <a  href="{{route('products.trash')}}" class="btn btn-success  m-1" style="float: right">Deleted Products</a>
    @endcan
    <br><br>

    <x-alerts></x-alerts>

    <div class="bg-light p-1 mb-3">
        <form action="{{route('products.index')}}" method="get"  class="form-check-inline"   >
            <input type="text" name="name"   class="control mb-1 " placeholder="Product Name.."    >
            <input type="number" name="price_min" class="control  mb-1" placeholder="Price from.." >
            <input type="number" name="price_max" class="control  mb-1" placeholder="price to.."  >
            <select name="category_id" class="control  mb-1"  >
                <option value="" selected> All Categories</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary"> Find </button>
        </form>
    </div>

<table class="table ">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Category</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">User</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i=0;?>
    @forelse($products as $product )
    <tr>
        <?php $i++;?>
        <td>{{$i}}
        <td><img style="width: 150px; height: 100px;" src="{{$product->image_url}}"></td>
        <td><a href="{{route('products.show',$product->id)}}">{{$product->name}}</a> </td>
        <td>{{$product->category->name}}</td>
        <td>{{$product->price}}</td>
        <td>{{$product->quantity}}</td>
        <td>{{$product->user->name}}</td>

        <td>
            @can('update',$product)
            <a href="{{route('products.edit',$product->id)}}" class="btn btn-info btn-sm fa fa-edit " role="button" aria-pressed="true"> </a>
            @endcan
            @can('delete',$product)
            <a  href="{{route('products.delete',$product->id)}}" class="btn btn-danger btn-sm fa fa-trash" >  </a>
            @endcan
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
