$(document).ready(function(){
    var count_file = $('.add_file').attr('id');
    $('.q_input_last_name').on('input', function(){
        setNewNameElementIblock();
    });
    $('.q_input_name').on('input', function(){
        setNewNameElementIblock();
    });
    $('.q_input_second_name').on('input', function(){
        setNewNameElementIblock();
    });
    function setNewNameElementIblock(){
        $('.main_name_q_input input').val($('.q_input_last_name').val() + ' ' + $('.q_input_name').val() + ' ' + $('.q_input_second_name').val());
        //console.log('скрытое поле наименование - ' + $('.main_name_q_input').val());
    }
    $('.q_phone').mask('+7(999)999-99-99');
    
    setInterval(function () {
	if ($('.q_input_344>input').val()!=null) 
	{
		$('.q_input_344 .bx-ui-sls-fake').prop("title", $('.q_input_344>input').val());
		$('.q_input_344 .bx-ui-sls-fake').prop("value", $('.q_input_344>input').val());
	}
    	if ($('.q_input_568>input').val()!=null) 
	{
		$('.q_input_568 .bx-ui-sls-fake').prop("title", $('.q_input_568>input').val());
		$('.q_input_568 .bx-ui-sls-fake').prop("value", $('.q_input_568>input').val());
	}
    	if ($('.q_input_571>input').val()!=null) 
	{
		$('.q_input_571 .bx-ui-sls-fake').prop("title", $('.q_input_571>input').val());
		$('.q_input_571 .bx-ui-sls-fake').prop("value", $('.q_input_571>input').val());
	}
	//
        $('.q_input_338>input').val($('.q_input_338 .bx-ui-sls-fake').attr("title"));
        $('.q_input_343>input').val($('.q_input_343 .bx-ui-sls-fake').attr("title"));
        $('.q_input_357>input').val($('.q_input_357 .bx-ui-sls-fake').attr("title"));
	$('.q_input_344>input').val($('.q_input_344 .bx-ui-sls-fake').attr("title"));
	$('.q_input_568>input').val($('.q_input_568 .bx-ui-sls-fake').attr("title"));
	$('.q_input_571>input').val($('.q_input_571 .bx-ui-sls-fake').attr("title"));
    },1000);
    $('.add_file').click(function () {
        $('.last_file').removeClass('last_file').after("</br><input type='hidden' name='PROPERTY[366]["+count_file+"]' value=''><input class='last_file' type='file' size='30' name='PROPERTY_FILE_366_"+count_file+"'>");
        count_file++;
    });


    $(".main_type_prop").change(function(e) {
        var url = window.location.href;
        var str = "";
        $( "select option:selected" ).each(function() {
            if(str == "") {
                str += $(this).text() + " ";
            }
        });
        console.log(str);

        arr = url.split('&');
        var newurl = arr[0];

        location.href = newurl + '&TYPE=' + str;
    });

});