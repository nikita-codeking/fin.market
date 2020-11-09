<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
include 'functions.php';?>
<?php
	use Bitrix\Main\Page\Asset;
	Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
    Asset::getInstance()->addCss('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css');
    Asset::getInstance()->addCss('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css');
    Asset::getInstance()->addJs('https://code.jquery.com/jquery-3.5.1.slim.min.js');
    Asset::getInstance()->addJs('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js');
    Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js');
?>
<form>
    <div class="form-group">
        <label for="country">Страна:</label>
        <select class="selectpicker" id="country" data-live-search="true" title="Страна">
        </select>
    </div>
    <div class="form-group" >
       <!--<label for="city">Город:</label>-->
        <select class="selectpicker" id="city" data-live-search="true" data-show-subtext="true" title="Город">
            <option data-tokens="Введите город" data-subtext="Введите город" value="Введите город">Введите город</option>
        </select>
        <button class="btn btn-outline-secondary"  id="btn-search" type="button">Искать</button>
    </div>
    <div class="form-group">
        <!--<label for="search">Поиск:</label>-->
        <div class="input-group mb-3 col-4">
            <input style="display:none;" id="search" type="text" class="form-control" placeholder="Найти" aria-label="Найти" aria-describedby="basic-addon2">
            <!--<div class="input-group-append">
                <button class="btn btn-outline-secondary" id="btn-search" type="button">Искать</button>
            </div>-->
        </div>
    </div>


</form>

    <h1 id="msg_work"></h1>
    <table id="excursion">

    </table>
<script>
var db;

BX.ready(function () {

    var Countries;
    var Citiesdata;
    var citySelect;
    
    BX.ajax({
	url: '<?=$componentPath;?>/templates/.default/ajax/country.php',
        method: 'POST',
        dataType: 'json',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: true,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function(data){
            Countries = data;
            var option;
            var country;
            for(var key in data) {
                option = document.createElement('option');
                option.text = key;
                option.value = key;

                $('#country').append('<option value="'+key+'">'+key+'</option>');
            }
            $('#country').selectpicker('refresh');
        },
        onfailure: function(){

        }
    });
    $('#country').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        $('#city').val('');
        $('#city').find('option').remove();
        $('#city').selectpicker('refresh');
        BX.ajax({
            url: '<?=$componentPath;?>/templates/.default/ajax/cities.php',
            data: {'cities' : JSON.stringify(Countries[this.value])},
            method: 'POST',
            dataType: 'json',
            timeout: 30,
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            onsuccess: function(data){
                Citiesdata = data;
                var option;
                var city;
                for(var key in data) {
                    option = document.createElement('option');
                    option.text = key;
                    option.value = key;

                    $('#city').append('<option data-tokens="'+key+'" data-subtext="'+key+'" value="'+key+'">' + key+'</option>');
                }
                $('#city').selectpicker('refresh');
            },
            onfailure: function(){

            }
        });
    });

    $('#city').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        citySelect = Citiesdata[this.value];
    });

    $('#btn-search').click(function () {

        if($('#city').val() && $('#country').val()) {
            $('#msg_work').html('<p style="text-align: center;">Ищу</p>');
            $("#excursion tr").remove();
            BX.ajax({
                url: '<?=$componentPath;?>/templates/.default/ajax/excursion.php',
                data: {'excursion': JSON.stringify(citySelect), 'search': JSON.stringify($('#search').val())},
                method: 'POST',
                dataType: 'json',
                timeout: 30,
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function (data) {
                    db = data;
                    $("#msg_work").html('');
                    var tableExcursion = $('#excursion');
                    var thr = document.createElement('tr');
                    thr.innerHTML += '<th>id</th>';
                    thr.innerHTML += '<th>title</th>';
                    thr.innerHTML += '<th>description</th>';
                    thr.innerHTML += '<th>country</th>';
                    thr.innerHTML += '<th>city</th>';
                    thr.innerHTML += '<th>price</th>';
                    thr.innerHTML += '<th>meeting_point</th>';
                    thr.innerHTML += '<th>duration</th>';
                    thr.innerHTML += '<th>advertiser</th>';
                    thr.innerHTML += '<th>online</th>';
		    thr.innerHTML += '<th>zoom</th>';
                    tableExcursion.append(thr);

                    var index = 0;
                    var row = 0;
                    for (var advertiser in data) {
                        for (var i = 0; i < data[advertiser].length; i++) { 
                            var tr = document.createElement('tr');
                            if (advertiser === 'Tripster') {
				let resultOnline = 'No';
				let resultZoom = 'No';
				if(data[advertiser][i]['title'].indexOf('Онлайн') > -1 || data[advertiser][i]['title'].indexOf('online') > -1 || data[advertiser][i]['tagline'].indexOf('online') > -1 || data[advertiser][i]['tagline'].indexOf('Online') > -1 || data[advertiser][i]['meeting_point']['text'].indexOf('online') > -1 || data[advertiser][i]['meeting_point']['text'].indexOf('Online') > -1) {
					resultOnline = "Yes";
				}
				if(data[advertiser][i]['title'].indexOf('Zoom') > -1 || data[advertiser][i]['title'].indexOf('zoom') > -1 || data[advertiser][i]['tagline'].indexOf('zoom') > -1 || data[advertiser][i]['tagline'].indexOf('Zoom') > -1 || data[advertiser][i]['meeting_point']['text'].indexOf('zoom') > -1 || data[advertiser][i]['meeting_point']['text'].indexOf('Zoom') > -1) {
					resultZoom = "Yes";
				}
                                tr.innerHTML += '<td>' + index++ + '</td>';
                                tr.innerHTML += '<td><a id = "' + advertiser + '-' + row++ + '" class="open-popup" data-toggle="modal" href="#" onclick="popupGetExcursion(this, db);">' + data[advertiser][i]['title'] + '</a></td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['tagline'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['city']['country']['name_ru'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['city']['name_ru'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['price']['value_string'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['meeting_point']['text'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['duration'] + '</td>';
                                tr.innerHTML += '<td>' + advertiser + '</td>';
				tr.innerHTML += '<td>' + resultOnline +'</td>';
				tr.innerHTML += '<td>' + resultZoom +'</td>';
                            }
                            if (advertiser === 'Sputnik8') {
				let resultOnline = 'No';
				let resultZoom = 'No';
				if(data[advertiser][i]['title'].indexOf('Онлайн') > -1 || data[advertiser][i]['title'].indexOf('online') > -1 || data[advertiser][i]['description'].indexOf('online') > -1 || data[advertiser][i]['description'].indexOf('Online') > -1 || data[advertiser][i]['begin_place']['address'].indexOf('online') > -1 || data[advertiser][i]['begin_place']['address'].indexOf('Online') > -1) {
					resultOnline = "Yes";
				}
				if(data[advertiser][i]['title'].indexOf('Zoom') > -1 || data[advertiser][i]['title'].indexOf('zoom') > -1 || data[advertiser][i]['description'].indexOf('zoom') > -1 || data[advertiser][i]['description'].indexOf('Zoom') > -1 || data[advertiser][i]['begin_place']['address'].indexOf('zoom') > -1 || data[advertiser][i]['begin_place']['address'].indexOf('Zoom') > -1) {
					resultZoom = "Yes";
				}
                                tr.innerHTML += '<td>' + index++ + '</td>';
                                tr.innerHTML += '<td><a id = "' + advertiser + '-' + row++ + '" class="open-popup" data-toggle="modal" href="#" onclick="popupGetExcursion(this, db);">' + data[advertiser][i]['title'] + '</a></td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['description'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['country_slug'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['city_slug'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['price'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['begin_place']['address'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['duration'] + '</td>';
                                tr.innerHTML += '<td>' + advertiser + '</td>';
				tr.innerHTML += '<td>' + resultOnline +'</td>';
				tr.innerHTML += '<td>' + resultZoom +'</td>';
                            }
                            tableExcursion.append(tr);
                        }
                        row = 0;
                    }
                },
                onfailure: function () {
                    $("#msg_work").val('');
                }
            });
        } else {
            $('#msg_work').html('<p style="text-align: center;">Страна и город должны быть заполнены!</p>');
        }
    });

});

function popupGetExcursion(obj, data) {
    var index = obj.id.split('-'); 
    $("#excursionModalLongTitle").html(index[0]);
    $("#excursionModalCenter").modal("show");
    $("#popup-table tr").remove();
    var tablePopup = $('#popup-table');
    printExcursion(tablePopup, data[index[0]][index[1]]);
}

function printExcursion(table, obj, arrayDataExcursion = []) {
    var tr;
    for (var key in obj) {
        if(typeof obj[key] === 'object' && obj[key] !== null) {
            arrayDataExcursion.push('<i>' + key + '</i> - ');
            printExcursion(table, obj[key], arrayDataExcursion);
        } else if(Array.isArray(obj[key])) {
            for(var index = 0; index < obj[key].length; index++) {
                printExcursion(table, obj[key][index], arrayDataExcursion);
            }
        } else {
            tr = document.createElement('tr');
            tr.innerHTML += '<td style="border: 1px #000 solid; border-collapse: collapse;"><b>' + arrayDataExcursion.join('') + key + ':</b></td>';
            tr.innerHTML += '<td style="border: 1px #000 solid; border-collapse: collapse;">' + obj[key] + '</td>';
            table.append(tr);
        }
    }
    if(arrayDataExcursion.length) {
        arrayDataExcursion.pop();
    }
}
</script>
<!-- Modal -->
<div class="modal fade bd-excursion-modal-lg" id="excursionModalCenter" tabindex="-1" role="dialog" aria-labelledby="excursionModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="excursionModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="popup-table" style="border: 1px #000 solid; border-collapse: collapse; width: 100%;">

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
