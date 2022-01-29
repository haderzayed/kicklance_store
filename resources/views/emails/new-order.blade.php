
<html>
<head>
    <title>Mail</title>
<body>
<p>Hello {{$name}}</p>
<p>uou have new (order # {{$order->id}})</p>
<p><a href="{{url(route('products.index'))}}">check your orders</a></p>
<img src="{{$message->embed(public_path('img/brand1.png'))}}" style="width: 100px; height: 100px">
</body>
</html>
