$(document).ready(function() {
    $('.move1').appendTo('#content');
    $('.move2').appendTo('#content');
    $('#content>.top_inner_block_wrapper:first-child').remove();
    $('#content>.wrapper_inner:first-child').remove();
});