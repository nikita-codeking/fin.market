$(document).ready(function(){
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
    $('.q_phone').mask('+7 (999) 999-99-99');
});