@extends('layouts.admin')
@section('page-title','Categories')

@section('content')
    <a  href="{{route('categories.create')}}" class="btn btn-success  " style="float: right">Add Category</a>
    <br><br>
    <x-alerts></x-alerts>
<table class="table ">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Parent</th>
        <th scope="col">NO.Product</th>
        <th scope="col">Created AT</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i=0;?>
    @foreach($categories as $category )
    <tr>
        <?php $i++;?>
        <td>{{$i}}</td>
        <td><a href="{{route('categories.show',$category->id)}}">{{$category->name}}</a> </td>
        <td>{{$category->parent->name}}</td>
        <td>{{$category->products->count()}}</td>
        <td>{{$category->created_at}}</td>
        <td>
            <a href="{{route('categories.edit',$category->id)}}" class="btn btn-info btn-sm fa fa-edit" role="button" aria-pressed="true"> </a>
            <a  href="{{route('categories.delete',$category->id)}}" class="btn btn-danger btn-sm fa fa-trash" >  </a>
        </td>
    </tr>
    @endforeach

    </tbody>
</table>
@endsection
