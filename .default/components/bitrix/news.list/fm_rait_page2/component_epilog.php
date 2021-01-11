<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<script>
    $(function(){
        let stateobj = {};
        ///let flag = '<?//=(!empty($_GET['tags'])) ? "Y" : "N";?>';
        //if (flag == 'Y') {
        //	$("#ajax-menu").load("/articles/ #ajax-menu > *");
        //}
        zenColours();
        $(".sidearea a").on("click", function(e){
            let url = $(this).attr("href");
            zenColours();
            $( "#ajax-cont" ).load( url + " #ajax-cont > *" );
            history.pushState(stateobj, "page", url);
            //console.log(url);
            e.preventDefault();
            zenColours();
            return false;
        });
        $(window).on("popstate", function(){
            //console.log(window.location);
            let url = window.location;
            $( "#ajax-cont" ).load( url + " #ajax-cont > *" );
            zenColours();
        });
    });
</script>