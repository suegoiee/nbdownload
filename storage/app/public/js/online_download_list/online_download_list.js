
        var search_model_result = [];

        $(".search-model").on('keypress',function(e) {
            if(e.which == 13) {
                event.preventDefault();
                var id = $(this).attr('model-id');
                var selected_list = [];
                $.ajax({
                    type: "GET",
                    url: $("#downloadOnlineList-api").val(),
                    data:{
                        keyword : $(this).val()
                    },
                    success:function(msg){
                        search_model_result = msg;
                        $("#model_pool-"+id).empty();
                        msg.forEach(function(value) {
                            $("#model_pool-"+id).append('<option value='+value['download_id']+'>'+value['download_title'] +'</option>');
                        });
                    },
                    error:function(msg){
                        console.log(msg);
                    }
                });
            }
        });
        $(".btn-add-model-product").on("click", function(){
            let id = $(this).val();
            let download_id = $($("#model_pool-"+id+" option:selected")[0]).val();
            let search_model_relation = $.grep(search_model_result, function(n, i){ return n.download_id == download_id; })[0]['has_many_product'];
            let selected_list = [];
            $("#seleted_product-"+id+' option:selected').each(function(key, value){
                selected_list.push($(value).val());
            });
            console.log(search_model_relation, selected_list);
            $("#product_pool-"+id).empty();
            search_model_relation.forEach(function(value){
                if(jQuery.inArray(value['product_id'].toString(), selected_list) == -1){
                    $("#product_pool-"+id).append('<option value='+value['product_id']+'>'+value['product_title'] +'( '+ value['product_model_name'] +' )' +'</option>');
                }
            });
        });


        $(".search-product").on('keypress',function(e) {
            if(e.which == 13) {
                event.preventDefault();
                var id = $(this).attr('model-id');
                var selected_list = [];
                $("#seleted_product-"+id+' option:selected').each(function(key, value){
                    selected_list.push($(value).val());
                });
                $.ajax({
                    type: "GET",
                    url: $("#productList-api").val(),
                    data:{
                        keyword : $(this).val()
                    },
                    success:function(msg){
                        $("#product_pool-"+id).empty();
                        msg.forEach(function(value) {
                            if(jQuery.inArray(value['product_id'].toString(), selected_list) == -1){
                                $("#product_pool-"+id).append('<option value='+value['product_id']+'>'+value['product_title'] +'( '+ value['product_model_name'] +' )' +'</option>');
                            }
                        });
                    },
                    error:function(msg){
                        console.log(msg);
                    }
                });
            }
        });
        $(".btn-add-selected").on("click", function(){
            var id = $(this).val();
            $('#product_pool-'+id+' option:selected').each(function(value){
                $("#seleted_relation-"+id).append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
                $("#seleted_product-"+id).append('<option value='+$(this).val()+' selected>'+$(this).html()+'</option>');
                $(this).remove();
            });
        });
        $(".btn-add-all").on("click", function(){
            var id = $(this).val();
            $('#product_pool-'+id).children().each(function(value){
                $("#seleted_relation-"+id).append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
                $("#seleted_product-"+id).append('<option value='+$(this).val()+' selected>'+$(this).html()+'</option>');
            });
            $('#product_pool-'+id).empty();
        });
        
        $(".btn-remove-selected").on("click", function(){
            var id = $(this).val();
            $('#seleted_relation-'+id+' option:selected').each(function(value){
                var seleted_relation = $(this);
                $("#product_pool-"+id).append('<option value='+seleted_relation.val()+'>'+seleted_relation.html()+'</option>');
                $(this).remove();
                $('#seleted_product-'+id).children().each(function(seleted_value){
                    if($(this).val() == seleted_relation.val()){
                        $(this).remove();
                    }
                });
            });
        });
        $(".btn-remove-all").on("click", function(){
            var id = $(this).val();
            $('#seleted_relation-'+id).children().each(function(value){
                $("#product_pool-"+id).append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
            });
            $('#seleted_relation-'+id).empty();
            $('#seleted_product-'+id).empty();
        });


        $(".btn-search-model").on('click',function(e) {
            event.preventDefault();
            var id = $(this).closest(".input-group").find('.search-model').attr('model-id');
            var selected_list = [];
            $.ajax({
                type: "GET",
                url: $("#downloadOnlineList-api").val(),
                data:{
                    keyword : $(this).closest(".input-group").find('.search-model').val()
                },
                success:function(msg){
                    search_model_result = msg;
                    $("#model_pool-"+id).empty();
                    msg.forEach(function(value) {
                        $("#model_pool-"+id).append('<option value='+value['download_id']+'>'+value['download_title'] +'</option>');
                    });
                },
                error:function(msg){
                    console.log(msg);
                }
            });
        });

        $(".btn-search-product").on('click',function(e) {
            event.preventDefault();
            var id = $(this).closest(".input-group").find('.search-product').attr('model-id');
            var selected_list = [];
            $("#seleted_product-"+id+' option:selected').each(function(key, value){
                selected_list.push($(value).val());
            });
            $.ajax({
                type: "GET",
                url: $("#productList-api").val(),
                data:{
                    keyword : $(this).closest(".input-group").find('.search-product').val()
                },
                success:function(msg){
                    $("#product_pool-"+id).empty();
                    msg.forEach(function(value) {
                        if(jQuery.inArray(value['product_id'].toString(), selected_list) == -1){
                            $("#product_pool-"+id).append('<option value='+value['product_id']+'>'+value['product_title'] +'( '+ value['product_model_name'] +' )' +'</option>');
                        }
                    });
                },
                error:function(msg){
                    console.log(msg);
                }
            });
        });