BX.namespace("BX.Iblock.Catalog");

BX.Iblock.Catalog.CompareClass = (function()
{
	var CompareClass = function(wrapObjId)
	{
		this.wrapObjId = wrapObjId;
	};

	CompareClass.prototype.MakeAjaxAction = function(url, refresh)
	{
		BX.showWait(BX(this.wrapObjId));
		BX.ajax.post(
			url,
			{
				ajax_action: 'Y'
			},
			BX.proxy(function(result)
			{
				BX(this.wrapObjId).innerHTML = result;
				if(typeof refresh !== undefined){
					getActualBasket('','Compare');
					if($('#compare_fly').length){
						jsAjaxUtil.InsertDataToNode(arNextOptions['SITE_DIR'] + 'ajax/show_compare_preview_fly.php', 'compare_fly', false);
					}

				}
				BX.closeWait();
			}, this)
		);
	};

	return CompareClass;
})();

$( document ).ready(function() {
    var scrollRight;
    var scrollLeft;
    $(".scroll_right").on("mouseover" , function() {
        scrollRight = setInterval(function(){
                var scr = $(".bx_compare");
                var pos = $(scr).prop("scrollLeft") + 5;
                scr.scrollLeft(pos);
            },
            50);

    });
    $(".scroll_right").on("mouseout" , function() {
        clearInterval(scrollRight);
    });
    $(".scroll_left").on("mouseover" , function() {
        scrollRight = setInterval(function(){
                var scr = $(".bx_compare");
                var pos = $(scr).prop("scrollLeft") - 5;
                scr.scrollLeft(pos);
            },
            50);

    });
    $(".scroll_left").on("mouseout" , function() {
        clearInterval(scrollRight);
    });

});
function clickProperty(e){
    console.log(e);

    BX.ajax.loadJSON(
        "compare.php",
        {'TYPE': 'SORT', 'PROP': e},
        function (data){
        	console.log(data);
            location.reload();
        },
        function (data){

        }
    );
}