

(function (){
    $('[data-toggle="favourites"]').on('click',function (e){
       e.preventDefault();
         var that = $(this)
        if(that.hasClass('active')){
             $.ajax({
                 url:'/favourites/' + $(this).data('id'),
                 method:'delete',
                 data:{
                     _token:_crfToken
                 }
             }).done(function (response){
                 that.removeClass('active');
                 Swal.fire({
                     icon: 'success',
                     title: 'Done...',
                     text: response.message,
                 })

             })
            return;
        }


       $.post('/favourites',{
           product_id:$(this).data('id'),
           _token:_crfToken
       },function (response){
          that.addClass('active');
           Swal.fire({
               icon: 'success',
               title: 'Done...',
               text: response.message,
           })
       })
    });

    $('[data-toggle="product-rating"]').on('change',function (e){
        e.preventDefault();
        $.post('/ratings/product',{
            product_id:$(this).data('id'),
            rating:$(this).val(),
            _token:_crfToken
        },function (response){
           alert(response.rating)
        })
    });


})(jQuery);
