 @extends('layouts.admin')
@section('page-title',$product->name)

@section('content')
<h3>Tags</h3>
    <ul>
        @foreach($product->tags as $tag)
            <li>{{$tag->name}}</li>
        @endforeach
    </ul>
 @endsection
