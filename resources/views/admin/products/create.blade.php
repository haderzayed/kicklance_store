@extends('layouts.home')
@section('page-title','Create Products')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif
<form method="post" action="{{route('products.store')}}"   enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Category Name</label>
        <select class="form-select"  name="category__id" aria-label="Default select example">
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{old('name',$category->name)}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Price</label>
        <input type="text" name="price" class="form-control" value="{{old('price')}}" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Sale Price</label>
        <input type="text" name="sale_price" class="form-control" value="{{old('sale_price')}}" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Quantity</label>
        <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Image</label>
        <input type="file" name="image" value="{{old('image')}}" class="form-control"   >
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Description</label>
        <textarea class="form-control" name="description">{{old('description')}}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
