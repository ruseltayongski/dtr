//tracking history of the document
$("a[href='#track']").on('click',function(){
    $('.track_history').html(loadingState);
    var route_no = $(this).data('route');
    var url = $(this).data('link');

    $('#track_route_no').val('Loading...');
    setTimeout(function(){
        $('#track_route_no').val(route_no);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('.track_history').html(data);
            }
        });
    },1000);
});