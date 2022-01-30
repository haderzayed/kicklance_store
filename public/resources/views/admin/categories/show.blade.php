@extends('layouts.admin')
@section('page-title',' ')

@section('content')
    <h2>{{ $category->name }}</h2>
    <h4>Child Categories</h4>
    <ul>
        @foreach($category->children as $child)
            <li>{{$child->name}}</li>
        @endforeach
    </ul>
    <br>
    <hr>
    <h4>Products</h4>
    <table class="table " title="Products">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>

        </tr>
        </thead>
        <tbody>
        <?php $i=0;?>
        @forelse($products as $product )
            <tr>
                <?php $i++;?>
                <td>{{$i}}
                <td>{{$product->name}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->quantity}}</td>

            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No Products</td>
            </tr>
        @endforelse

        </tbody>
    </table>
 @endsection
