@extends('layouts.admin')
@section('page-title','Deleted Products')

@section('content')

    <x-alerts></x-alerts>



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
                 <form method="post" action="{{route('products.restore',$product->id)}}" class="d-inline">
                     @csrf
                     @method('PUT')
                      <button type="submit" class="btn btn-info btn-sm ">Restore</button>
                </form>
            @endcan
            @can('delete',$product)
                    <form method="post" action="{{route('products.force.delete',$product->id)}}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm  ">Delete</button>
                    </form>

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
