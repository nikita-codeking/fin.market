$(document).ready(function() {
    $('.step1_credit_assist .work_step>div').click(function () {
        $('.param_credit_assist .type_ca').html($(this).parent().attr("id"));
        $('.step1_credit_assist').fadeOut(300);
        setTimeout(function () {
            $('.step2_credit_assist').fadeIn(300);
        },300);
    });
    /*$('.step2_credit_assist .productid>div').click(function () {
        $('.param_credit_assist .product_ca').html($(this).parent().attr("id"));
        $('.step2_credit_assist').fadeOut(300);
        setTimeout(function () {
            $('.step3_credit_assist').fadeIn(300);
        },300);
    });*/
    $( ".productid .check>input" ).click(function () {
        //console.log(1);
        $('.param_credit_assist .product_ca').html("");
        var txtID = "";
        $( ".productid .check>input:checked" ).each(function () {
            //console.log($(this).attr("alt"));
            if(txtID.length == 0){
                txtID = $(this).attr("alt");
            }else{
                txtID = txtID + "|" + $(this).attr("alt");
            }
        });
        $('.param_credit_assist .product_ca').html(txtID);
    });

    $(".quest_select_ca").change(function() {
        location.href = $(this).val()+"&type_ca="+$(document).find('.param_credit_assist .type_ca').text()+"&product_ca="+$(document).find('.param_credit_assist .product_ca').text();
	$("#error_pr").text("");
    });
    $('.assist_button').click(function () {
        if(this.id == 1){
            if($(".step2_credit_assist").css("display") != "none"){
                $('.step2_credit_assist').fadeOut(300);
                setTimeout(function () {
                    $('.step1_credit_assist').fadeIn(300);
                },300);
            }else if($(".step3_credit_assist").css("display") != "none"){
                $('.step3_credit_assist').fadeOut(300);
                setTimeout(function () {
                    $('.step2_credit_assist').fadeIn(300);
                },300);
            }
        }else if(this.id == 2){
            if($(".step1_credit_assist").css("display") != "none"){
                if($(".type_ca").text() != "") {
                    $('.step1_credit_assist').fadeOut(300);
                    setTimeout(function () {
                        $('.step2_credit_assist').fadeIn(300);
                    }, 300);
                }
            }else if($(".step2_credit_assist").css("display") != "none"){
                //if($(".product_ca").text() != "") {
                    $('.step2_credit_assist').fadeOut(300);
                    setTimeout(function () {
                        $('.step3_credit_assist').fadeIn(300);
                    }, 300);
                //}
            }
        }else if(this.id == 3){
            	$('.productid .check>input').prop('checked', true);
		$('.param_credit_assist .product_ca').html("");
		        var txtID = "";
		        $( ".productid .check>input:checked" ).each(function () {
		            //console.log($(this).attr("alt"));
		            if(txtID.length == 0){
		                txtID = $(this).attr("alt");
		            }else{
		                txtID = txtID + "|" + $(this).attr("alt");
		            }
		        });
		        $('.param_credit_assist .product_ca').html(txtID);	    

        }
    });
});