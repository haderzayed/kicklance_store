@extends('layouts.admin')
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
        <input type="number" name="price" class="form-control" value="{{old('price')}}" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Sale Price</label>
        <input type="number" name="sale_price" class="form-control" value="{{old('sale_price')}}" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Quantity</label>
        <input type="number" name="quantity" class="form-control" value="{{old('quantity')}}" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Product Image</label>
        <input type="file" name="image" value="{{old('image')}}" class="form-control"   >
    </div>
    {{--   <div class="mb-3">
         <label for="exampleInputEmail1" class="form-label">Tags</label>
         @foreach($tags as $tag)
             <div class="form-check">
                 <input type="checkbox" class="form-check-input" name="tags[]" value="{{$tag->id}}" @if(in_array($tag->id , $product_tag)) checked @endIf>
                 <label class="form-check-label">{{$tag->name}}</label>
             </div>
         @endforeach
     </div>
     --}}
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Tags</label>

        <div class="form-group">
            <input type="text" class="form-control @error('tags')  is-invalid @enderror" name="tags" value="{{old('tags')}}"  >
            @error('$tags')
            <p class="invalid-feedback">{{$message}}</p>
            @enderror()
        </div>

    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Description</label>
        <textarea class="form-control" name="description">{{old('description')}}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
