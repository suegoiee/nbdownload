$(function () {
    $(".btn-batch").on('click', function(){
        var id = [];
        $(".downloadBatch").each( function(key){
            if($( this ).is(":checked")){
                id.push($( this ).val());
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("#csrf").val()
            }
        });
        $.ajax({
            type: "POST",
            url: $("#downloadListLocal-api").val(),
            data: {
                action:$(this).val(),
                id:id
            },
            success:function(msg){
                //console.log(msg);
                location.reload();
            },
            error:function(msg){
                console.log(msg);
            }
        });
    });
    $('.select2').select2()
});