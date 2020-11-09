<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js" integrity="sha512-BKbSR+cfyxLdMAsE0naLReFSLg8/pjbgfxHh/k/kUC82Hy7r6HtR5hLhobaln2gcTvzkyyehrdREdjpsQwy2Jw==" crossorigin="anonymous"></script>
<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous"></script>
<script src="/lib/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/lib/jquery-ui.css">
<?//php see($arResult["CITIES"]);?>
<div id="app-wrap">
	<h2>Экскурсии</h2>
	<div id="search-field">
		<select data-placeholder="Поиск" id="chose-select" placeholder="Поиск">
			<?/*php foreach($arResult["COUNTRIES"] as $country):*/ ?>
				<?php foreach($arResult["CITIES"] as $city):?>
			<?/*php if($city["COUNTRY_ID"] == $country["ID"]): */?>
			<option value="<?=$city["Sputnik"]?>|<?=$city["Tripster"]?>|<?=$city["Surprise_Me"]?>|<?=$city["NAME"]?>"><?=$city["NAME"]?></option>
			<?/*php endif;*/?>
				<?php endforeach;?>
			<?/*php endforeach;*/?>
		</select>
	</div>
	<div id="api-app">
		<div id="block-1">
			<div id="main_block"><p>{{message}}</p><button id="search" @click="search()">Поиск</button></div>
			<fieldset>
				<legend>Длительность программы</legend>
				<label>Любая <input type=radio v-model="durationtype" name="durationtype" value="all"></label>
				<label>Несколько часов <input v-model="durationtype" type="radio" name="durationtype" value="hours"></label>
				<label>Весь день <input type="radio" v-model="durationtype" name="durationtype" value="day"></label>
				<label>Несколько дней <input type="radio" v-model="durationtype" name="durationtype" value="several"></label>
			</fieldset>
			<fieldset><legend>Стоимость</legend>
				<div id="polz-price"></div><span id="price_field">от 0 до 0 руб</span>
			</fieldset>
			<fieldset><legend>Агентство</legend>
				<p>Спутник8:<input :disabled="tripsterfilter || weatlasfilter || surprisemefilter || mobile_adv || is_new || child_friendly || tagsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview" type="checkbox" v-model="sputnikfilter"></p>
				<p>Tripster:<input :disabled="sputnikfilter || weatlasfilter || surprisemefilter || mobile_adv || catsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview" type="checkbox" v-model="tripsterfilter"></p>
				<p>Surprise Me:<input type="checkbox" :disabled="private || group || weatlasfilter || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0" v-model="surprisemefilter"></p>
				<p>Weatlas:<input type="checkbox" :disabled="mobile_adv || private || group || surprisemefilter || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview" v-model="weatlasfilter"></p>
			</fieldset>
			<fieldset>
				<legend>Рейтинг</legend>
				<div id="polz-reit"></div><span id="rating_field"></span>
			</fieldset>
			<!--<fieldset>
			<legend>Продолжительность</legend>
				<div id="polz-dur"></div><span id="duration_field"></span>
			</fieldset>-->
			<fieldset><label><input v-model="is_new" type="checkbox" name="is_new" value="Y" :disabled="weatlasfilter || sputnikfilter || surprisemefilter || mobile_adv || catsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview">Новые</label><label><input v-model="child_friendly" type="checkbox" name="child_friendly" value="Y" :disabled="weatlasfilter || sputnikfilter || surprisemefilter || mobile_adv || catsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview">С детьми</label></fieldset>
			<fieldset><legend>Формат проведения</legend><label><input v-model="group" :disabled="private || weatlasfilter || surprisemefilter || type_image || type_video || type_audio || type_streetview" type="checkbox" name="group" value="Y">Груповая</label><label><input v-model="private" :disabled="group || weatlasfilter || surprisemefilter || type_image || type_video || type_audio || type_streetview" type="checkbox" name="private" value="Y">Приватная</label><label><input v-model="mobile_adv" :disabled="weatlasfilter || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0 || private || group" type="checkbox" name="mobile_adv" value="Y">Мобильный гид</label></fieldset>
			<fieldset>
				<legend>Формат участия</legend>
				<label><input :disabled="offline" v-model="online" type="checkbox" name="online" value="Y">Онлайн</label><label><input :disabled="online" v-model="offline" type="checkbox" name="offline" value="Y">Офлайн</label>
			</fieldset>
			<fieldset>
				<legend>Тип контента</legend>
				<label><input :disabled="private || group || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0" v-model="type_image" type="checkbox" name="type_image" value="Y">image</label>
				<label><input :disabled="private || group || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0" v-model="type_video" type="checkbox" name="type_video" value="Y">video</label>
				<label><input :disabled="private || group || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0" v-model="type_audio" type="checkbox" name="type_audio" value="Y">adio</label>
				<label><input :disabled="private || group || tripsterfilter || sputnikfilter || is_new || child_friendly || tagsvarchecked.length > 0 || catsvarchecked.length > 0" v-model="type_streetview" type="checkbox" name="type_streetview" value="Y">streetview</label>
			</fieldset>
			<fieldset>
				<legend>Теги</legend>
				<label v-for="tagcheck in tagscheck"><input :disabled="weatlasfilter || sputnikfilter || surprisemefilter || mobile_adv || catsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview" v-model="tagsvarchecked" type="checkbox" name="tags" :value="tagcheck">{{tagcheck}}</label>
			</fieldset>
			<fieldset>
				<legend>Категории</legend>
				<label v-for="category in categoriescheck"><input :disabled="weatlasfilter || tripsterfilter || surprisemefilter || mobile_adv || is_new || child_friendly || tagsvarchecked.length > 0 || type_image || type_video || type_audio || type_streetview" v-model="catsvarchecked" type="checkbox" name="cats" :value="category">{{category}}</label>
			</fieldset>
		</div>
		<div id="block-2">
			<div id="adv_filter_stats_wrapper">
				<div id="price_filter_indicator" v-if="pricefilteractive">Стоимость от {{pricefilterstart}} до {{pricefilterend}} руб <span class="cross" @click="closeprice">X</span></div><div id="durationprog_filter_indicator" v-if="durationtype!='all'">Длительность программы <br><span v-if="durationtype=='hours'">несколько часов</span><span v-if="durationtype=='day'">весь день</span><span v-if="durationtype=='several'">несколько дней</span> <span class="cross" @click="durationtype='all'">X</span></div><div id="duration_filter_indicator" v-if="ratingfilteractive">Рейтинг от {{ratingfilterstart}} до {{ratingfilterend}} <span class="cross" @click="closerating">X</span></div>
				<div v-if="child_friendly" id="child_filter_indicator">С детьми <span class="cross" @click="child_friendly = !child_friendly">X</span></div><div id="is_new_filter_indicator"  v-if="is_new">Новые <span class="cross" @click="is_new = !is_new">X</span></div><div id="tripster_filter_indicator" v-if="tripsterfilter">Агенство<br> Трипстер <span class="cross" @click="tripsterfilter = !tripsterfilter">X</span></div><div id="sputnik_filter_indicator" v-if="sputnikfilter">Агенство<br> Спутник8 <span class="cross" @click="sputnikfilter = !sputnikfilter">X</span></div><div id="surpriseme_filter_indicator" v-if="surprisemefilter">Агенство<br> Surprise Me <span class="cross" @click="surprisemefilter = !surprisemefilter">X</span></div><div id="weatlas_filter_indicator" v-if="weatlasfilter">Агенство<br> Weatlas <span class="cross" @click="weatlasfilter = !weatlasfilter">X</span></div>
				<div v-if="group" id="group_filter_indicator">Груповая <span class="cross" @click="group = !group">X</span></div><div v-if="private" id="private_filter_indicator">Приватная <span class="cross" @click="private= !private">X</span></div><div id="online_filter_indicator" v-if="online">Онлайн <span class="cross" @click="online= !online">X</span></div><div id="offline_filter_indicator" v-if="offline">Офлайн <span class="cross" @click="offline= !offline">X</span></div>
				<div class="cats_filter_indicator" v-for="(catname, index) in catsvarchecked"><p>{{catname}}</p> <span class="cross" @click="catsvarchecked.splice(index,1)">X</span></div><div class="tags_filter_indicator" v-for="(tagname, index) in tagsvarchecked"><p>{{tagname}}</p> <span class="cross" @click="tagsvarchecked.splice(index, 1);">X</span></div><div id="mobile_adv_filter_indicator" v-if="mobile_adv">Мобильный гид <span class="cross" @click="mobile_adv= !mobile_adv">X</span></div>
				<div v-if="type_image">Тип контента:image <span class="cross" @click="type_image = !type_image">X</span></div><div v-if="type_video">Тип контента: video <span class="cross" @click="type_video = !type_video">X</span></div><div v-if="type_audio">Тип контента: audio <span class="cross" @click="type_audio = !type_audio">X</span></div><div v-if="type_streetview">Тип контента: streetview <span class="cross" @click="type_streetview = !type_streetview">X</span></div>
			</div>
			<div id="count">Всего: {{advlength}}</div>
			<div id="show_types">Типы отображения: <span :class="{checked:visibletype == 'rect'}" @click="checkvisible('rect')">плитка</span> <span :class="{checked:visibletype == 'list'}" @click="checkvisible('list')">список</span></div>
			<div id="sort">Сортировка: <label>Нет<input v-model="sort" type="radio" value="none"></label> <label>По цене<input v-model="sort" type="radio" value="price"></label> <label>По рейтингу<input v-model="sort" type="radio" value="rating"></label></div>
		<transition name="fade">
		<div v-if="visibletype=='rect'" id="excursion_wrapper">

			<div class="excursion_item" v-for="advert in alladverts">
				<div class="i_name" @click="detail(advert, advert.advertiser)"><p class="pointer">{{advert.result_title}}</p></div>
				<div class="i_img_wrap" v-if="advert.result_img">
					<img :src="advert.result_img">
				</div>
				<div class="i_desc" v-if="advert.result_description">
					<p>{{advert.result_description}}</p>
					<button @click="showtext" class="show_all" ref="el">Показать все</button>
				</div>
				<hr>
				<div class="i_props">
					<p>Цена:{{advert.result_price}}</p>
					<p>Место встречи:{{advert.result_meet_place}}</p>
					<p>Продолжительность:{{advert.duration}}</p>
					<p>Advertiser:{{advert.advertiser}}</p>
				</div>
				<div class="button_wrapper">
					<button class="comp" @click="addtocomparison(advert)">В сравнение</button><button class="comp" @click="detail(advert, advert.advertiser)">Подробнее</button><button class="comp"><a :href="advert.result_url" target="_blank">Оформить</a></button>
				</div>
			</div>

		</div>
		</transition>
		<transition name="fade">
		<div v-if="visibletype=='list'" id="excursion_wrapper-2">

			<div class="excursion_item-2" v-for="advert in alladverts">
				<div class="i_img_wrap-2" v-if="advert.result_img">
					<img :src="advert.result_img">
				</div>
				<div class="i_desc-2" v-if="advert.result_description">
					<div class="i_name-2" @click="detail(advert, advert.advertiser)"><p class="pointer">{{advert.result_title}}</p></div>
						<p>{{advert.result_description}}</p>
						<button @click="showtext" class="show_all" ref="el">Показать все</button>
					</div>
					<hr>
					<div class="i_props-2">
						<p>Цена:{{advert.result_price}}</p>
						<p>Место встречи:{{advert.result_meet_place}}</p>
						<p>Продолжительность:{{advert.duration}}</p>
						<p>Advertiser:{{advert.advertiser}}</p>
					</div>
					<div class="button_wrapper-2">
					<button class="comp" @click="addtocomparison(advert)">В сравнение</button><button class="comp" @click="detail(advert, advert.advertiser)">Подробнее</button><button class="comp"><a :href="advert.result_url" target="_blank">Оформить</a></button>
				</div>
			</div>

		</div>
		</transition>
		<div class="hide" @click="close()" id="popup_wrap">
		</div>
		<div class="hide" id="popup-form">
			<button @click="close()">Закрыть</button>
			<nav id="popup_menu">
				<a href="#schedule">Расписание</a> <a href="#guide">Гид</a> <a href="#reviews">Отзывы</a> <a href="#likethis">Похожие</a>
			</nav>
			<h2 id="adv_name"></h2>
			<button v-if="!show_data" @click="show_this_data">Показать данные API</button><button v-else @click="close_this_data">Скрыть данные API</button>
			<table id="popup" v-show="show_data">
			</table>
			<h2 class="left" id="schedule">Расписание</h2>
			<button v-if="!show_schedule" @click="show_this_schedule">Показать</button><button v-else @click="close_this_schedule">Скрыть</button>
			<div id="schedule_wrapper" v-if="show_schedule">
				<div v-if="selected_apiname == 'Tripster'" class="date" v-for="(sched, ind)  in selected_schedule.schedule">{{ind}} <p>Время:</p>
					<p v-if="time.type == 'range'" class="time" v-for="time in sched">от {{time.time_start}} до {{time.time_end}}</p>
					<p v-if="time.type == 'slot'" class="time" v-for="time in sched">{{time.time}}</p>
				</div>
				<div v-if="selected_apiname == 'Sputnik8'">
					<p v-for="time in selected_schedule">{{time.schedule.name}}</p>
				</div>
			</div>
			<h2 class="left" id="guide">Гид</h2>
			<button v-if="!show_guide" @click="show_this_guide">Показать</button><button v-else @click="close_this_guide">Скрыть</button>
			<div id="guide_wrapper" v-if="show_guide">
				<div v-if="selected_apiname=='Tripster'">
					<img :src="selected_guide.avatar.medium">
					<p>Имя: <a :href="selected_guide.url" target="_blank">{{selected_guide["first_name"]}}</a></p>
					<p>Рейтинг: {{selected_guide.rating}}</p>
				</div>
				<div v-if="selected_apiname == 'Surprise Me'">
					<img :src="selected_guide.avatar">
					<p>Имя: <a :href="selected_guide.url" target="_blank">{{selected_guide["first_name"]}}</a></p>
					<p>Рейтинг: {{selected_guide.rating}}</p>
				</div>
			</div>
			<h2 class="left" id="reviews">Отзывы</h2>
			<button v-if="!show_reviews" @click="show_this_reviews">Показать</button><button v-else @click="close_this_reviews">Скрыть</button>
			<div id="reviews_wrapper" v-if="show_reviews">
				<div v-if="selected_apiname == 'Surprise Me'">
					<div v-for="review in selected_reviews"><div v-if="review.avatar"><img :src="review.avatar"></div>{{review.name}}: {{review.text}} Дата:{{review.date}} Рейтинг: {{review.rating}}</div>
				</div>
			</div>
			<h2 class="left" id="likethis">Похожие</h2>
			<button v-if="!show_likethis" @click="showlikethis">Показать</button><button v-else @click="close_likethis">Скрыть</button>
			<div v-if="show_likethis">
				<p v-for="likethisad1 in likethisadverts.Tripster"><a>{{likethisad1.title}}</a></p>
				<p v-for="likethisad2 in likethisadverts.Sputnik8"><a>{{likethisad2.title}}</a></p>
			</div>
		</div>
		<h2>Сравнение</h2>
		<table id="comparison">
			<th>title</th><th>duration</th><th>price</th><th>rating</th><th>delete</th>
			<tr v-for="(compel, index) in  comparison">
				<td v-if="compel.title">{{compel.title}}</td><td v-else>{{compel.name}}</td><td>{{compel.duration}}</td><td v-if="compel.Price">{{compel.Price}} {{compel.Currency}}</td><td v-else-if="compel.price['value_string']">{{compel.price['value_string']}}</td><td v-else-if="compel.price">{{compel.price}}</td><td>{{compel.rating}}</td><td><button @click="deletecomparison(index)">Delete</button></td>
			</tr>
		</table>
		</div>
	</div>
</div>
<script>
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
    $(function(){
				$("#price_field").text("от 0 до 0 руб");
				$("#rating_field").text( "от 0 до 0");
				/*$("#duration_field").text("от 0 до 0 часов");*/
				$("#polz-price").slider({
					animate: "slow",
					min: 0,
					max: 0,
					range: true,
					step:1,
					values: [ 0, 0 ],
					slide:function(event,ui){
						$("#price_field").text("от "+ ui.values[ 0 ] + " до "+ ui.values[ 1 ] + " руб");
						app.pricefilterstart = ui.values[ 0 ];
						app.pricefilterend = ui.values[ 1 ];
					},
					change:function(event, ui){
						$("#price_field").text("от "+ ui.values[ 0 ] + " до "+ ui.values[ 1 ] + " руб");
						app.pricefilterstart = ui.values[ 0 ];
						app.pricefilterend = ui.values[ 1 ];
					}
				});
				$("#polz-reit").slider({
				animate: "slow",
				min: 0,
				max: 0,
				range: true,
				step:1,    
				values: [ 0, 0 ],
				slide : function(event, ui) {    
					$("#rating_field").text( "от " + ui.values[ 0 ] + " до " + ui.values[ 1 ] );
					app.ratingfilterstart = ui.values[ 0 ];
					app.ratingfilterend = ui.values[ 1 ];      
				},
				change:function(event, ui){
					$("#rating_field").text( "от " + ui.values[ 0 ] + " до " + ui.values[ 1 ] );
					app.ratingfilterstart = ui.values[ 0 ];
					app.ratingfilterend = ui.values[ 1 ]; 
				}
				});
				/*$("#polz-dur").slider({
        animate: "slow",
				min: 0,
				max: 0,
				range: true,
				step:0.25,    
				values: [ 0, 0 ],
				slide : function(event, ui) {    
					$("#duration_field").text( "от " + ui.values[ 0 ] + " до " + ui.values[ 1 ] + " часов" );
					app.durationfilterstart = ui.values[ 0 ];
					app.durationfilterend = ui.values[ 1 ];       
				},
				change:function(event, ui){
					$("#duration_field").text( "от " + ui.values[ 0 ] + " до " + ui.values[ 1 ] + " часов" );
					app.durationfilterstart = ui.values[ 0 ];
					app.durationfilterend = ui.values[ 1 ];
				}
				});*/
				$("#chose-select").chosen();
    });
    var app = new Vue({
        el: '#api-app',
			data: {
			ratingfilteractive:false,
			pricefilteractive:false,
			//durationfilteractive:false,
			citysearch:"0|0||",
			pricefilterstart:0,
			pricefilterend:0,
			curs_euro:89.66,
			curs_dollar:76.82,
			curs_grvn:2.72,
			sputnikfilter:false,
			tripsterfilter:false,
			surprisemefilter:false,
			weatlasfilter:false,
			ratingfilterstart:0,
			ratingfilterend:0,
			visibletype:"",
			//durationfilterstart:0,
			//durationfilterend:0,
			comparison:[],
			likethisadverts:{
				Sputnik8:[],
				Tripster:[],
				Surprise_Me:[],
				Weatlas:[]
			},
			selected_id:0,
			selected_title:'',
//			selected_rating:0,
			selected_schedule:{},
			selected_apiname:'',
			selected_guide:[],
			selected_reviews:[],
			catsvarchecked:[],
			tagsvarchecked:[],
			private:false,
			group:false,
			child_friendly:false,
			is_new:false,
			online:false,
			offline:false,
			mobile_adv:false,
			message: 'Жду параметры!',
			type_image:false,
			type_video:false,
			type_audio:false,
			type_streetview:false,
			show_schedule:false,
			show_guide:false,
			show_reviews:false,
			show_data:false,
			show_likethis:false,
			durationtype:'all',
			sort:'none',
			adverts:{
				Sputnik8:[],
				Tripster:[],
				Surprise_Me:[],
				Weatlas:[]
			}
		},
		methods: {
			closerating:function(){
				this.ratingfilterstart = this.minrating;
				this.ratingfilterend = this.maxrating;
				$("#polz-reit").slider('option', 'values', [ this.minrating, this.maxrating ]);
			},
			closeduration:function(){
				this.durationfilterstart = this.minduration;
				this.durationfilterend = this.maxduration;
				$("#polz-dur").slider('option', 'values', [ this.minduration, this.maxduration ]);
			},
			closeprice:function(){
				this.pricefilterstart = this.minprice;
				this.pricefilterend = this.maxprice;
				$("#polz-price").slider("option", "values", [ this.minprice, this.maxprice ]);
			},
			showtext:function(e){
				if($(e.target).html()=="Показать все"){
					$(e.target).data("h", $(e.target).siblings("p").css("height"));
					$(e.target).siblings("p").css("height","auto");
					$(e.target).html("Cвернуть");
				}else{
					$(e.target).siblings("p").css("height", $(e.target).data("h"));
					$(e.target).html("Показать все");
				}
			},
			checkvisible:function(type){
				this.visibletype = type;
			},
			/*checkCheckboxDataTr:function(e){
				if($(e.target).is(':checked')){
					app.mobile_adv = false;
				}
			},
			checkCheckboxDataSp:function(e){
				if($(e.target).is(':checked')){
					app.child_friendly = false;
					app.is_new = false;
					app.mobile_adv = false;
				}
			},
			checkCheckboxDataSm:function(e){
				if($(e.target).is(':checked')){
					app.child_friendly = false;
					app.is_new = false;
					app.private = false;
					app.group = false;
				}
			},
			checkCheckboxDataWe:function(e){
				if($(e.target).is(':checked')){
					app.child_friendly = false;
					app.is_new = false;
					app.private = false;
					app.group = false;
					app.mobile_adv = false;
				}
			},*/
			search: function() {
				let searchIds = $("#chose-select").val();
				app.message = "Загрузка, идет поиск";
				$.ajax({
					method: "POST",
					url: "<?=$this->GetFolder()?>/ajax/excursion.php",
					data: {city_excursion:searchIds}
				})
				.done(function(response) {
					app.adverts = JSON.parse(response);
					app.visibletype = 'rect';
					app.pricefilterstart = app.minprice;
					app.pricefilterend = app.maxprice;
					app.ratingfilterstart = app.minrating;
					app.ratingfilterend = app.maxrating;
					app.durationfilterstart = app.minduration;
					app.durationfilterend = app.maxduration;
					$("#polz-price").slider('option', 'min', app.minprice);
					$("#polz-price").slider('option', 'max', app.maxprice);
					$("#polz-price").slider("option", "values", [ app.minprice, app.maxprice ]);
					$("#price_field").text("от " + app.minprice + " до "+ app.maxprice + " руб");
					$("#polz-reit").slider('option', 'min', app.minrating);
					$("#polz-reit").slider('option', 'max', app.maxrating);
					$("#rating_field").text( "от " + app.minrating + " до " + app.maxrating );
					$("#polz-reit").slider('option', 'values', [ app.minrating, app.maxrating ]);
					$("#rating_field").text("от " + app.minrating + " до "+ app.maxrating);
					/*$("#polz-dur").slider('option', 'min', app.minduration);
					$("#polz-dur").slider('option', 'max', app.maxduration);
					$("#polz-dur").slider('option', 'values', [ app.minduration, app.maxduration ]);
					$("#duration_field").text("от " + app.minduration +"  до "+ app.maxduration + " часов");*/
					app.citysearch = searchIds;
					app.message = "Поиск завершен!";
				});
			},
			showlikethis:function(){
				this.show_likethis = true;
				let city_ids = this.citysearch.split("|");
				if(this.selected_apiname == 'Tripster' && this.likethisadverts["Tripster"].length == 0){
					$.ajax({
						method: "POST",
						url: "<?=$this->GetFolder()?>/ajax/likethis.php",
						data: {advertiser:this.selected_apiname,city:city_ids[1],query:this.selected_title}
					}).done(function(response) {
						if(response != ''){
							app.likethisadverts["Tripster"] = JSON.parse(response);
							app.likethisadverts["Tripster"] = app.likethisadverts["Tripster"].filter(adv => {return adv.title != app.selected_title});
						} else {
							app.likethisadverts["Tripster"] = [];
						}
					});
				}
			},
			close_likethis:function(){
				this.show_likethis = false;
			},	
			show_this_reviews:function(){
				this.show_reviews = true;
			},
			close_this_reviews:function(){
				this.show_reviews = false;
			},
			show_this_guide:function(){
				this.show_guide = true;
			},
			close_this_guide:function(){
				this.show_guide = false;
			},
			show_this_schedule:function(){ 
				this.show_schedule = true;
				if(this.selected_apiname == 'Tripster' && this.selected_schedule == '') {
					$.ajax({
						method: "POST",
						url: "<?=$this->GetFolder()?>/ajax/schedule.php",
						data: {advertiser:app.selected_apiname,adv_id:app.selected_id}
					}).done(function(response) {
						if(response != ''){
							app.selected_schedule = JSON.parse(response);
						} else {
							app.selected_schedule = {};
						}
					});
				}
			},
			close_this_schedule:function(){
				this.show_schedule = false;
			},
			show_this_data:function(){
				this.show_data = true;
			},
			close_this_data:function(){
				this.show_data = false;
			},
			detail:function(data, apiname) {
				this.show_likethis = false;
				this.show_data = false;
				this.selected_schedule = '';
				this.selected_reviews = [];
				this.selected_guide = {};
				this.show_schedule = false;
				this.show_guide = false;
				this.show_reviews = false;
				this.likethisadverts = {
				Sputnik8:[],
				Tripster:[],
				Surprise_Me:[],
				Weatlas:[]
				}
				let city_ids = this.citysearch.split("|");
				$('#popup_wrap, #popup-form').removeClass("hide");
				let popupTable = document.getElementById("popup");
				$('#adv_name').html(apiname);
				$(popupTable).html('');
				printExcursion(popupTable, data);
				//this.selected_rating = data.rating;
				this.selected_title = data.title;
				this.selected_id = data.id;
				this.selected_apiname = apiname;
				if(this.selected_apiname == 'Tripster') {
					this.selected_guide = data.guide;
				} else if(apiname == "Sputnik8"){
					this.selected_schedule = data["order_options"];
				} else if(apiname == "Surprise Me"){
					this.selected_guide = data.author;
					if(data.reviews != false){
						this.selected_reviews = data.reviews;
					} else {
						this.selected_reviews = [];
					}
				}
			},
			close:function() {
				$('#popup_wrap, #popup-form').addClass("hide");
			},
			addtocomparison:function(adv) {
				let compdata;
				this.comparison.push(adv);
				compdata = JSON.stringify(this.comparison);
				localStorage.setItem("comparison", compdata);
			},
			deletecomparison:function(ind) {
				let compdata;
				this.comparison.splice(ind, 1);
				compdata = JSON.stringify(this.comparison);
				localStorage.setItem("comparison", compdata);
			}
		},
		computed:{
			alladverts:function(){
				let trip = [];
				let sput = [];
				let surp = [];
				let weat = [];
				let resArr = [];
				if(this.catsvarchecked.length == 0 && !this.weatlasfilter && !this.sputnikfilter && !this.surprisemefilter && !this.mobile_adv && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview){
					trip = this.advertsfiltered["Tripster"];
				}
				if(!this.is_new && !this.child_friendly && this.tagsvarchecked.length == 0 && !this.weatlasfilter && !this.tripsterfilter && !this.surprisemefilter && !this.mobile_adv && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview){
					sput = this.advertsfiltered["Sputnik8"];
				}
				if(!this.private && !this.group && !this.weatlasfilter && !this.sputnikfilter && !this.tripsterfilter && !this.is_new && !this.child_friendly && this.tagsvarchecked.length == 0 && this.catsvarchecked.length == 0){
					surp = this.advertsfiltered["Surprise_Me"];
				}
				if(!this.mobile_adv && !this.private && !this.group && !this.surprisemefilter && !this.tripsterfilter && !this.sputnikfilter && !this.is_new && !this.child_friendly && this.tagsvarchecked.length == 0 && this.catsvarchecked.length == 0 && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview){
					weat = this.advertsfiltered["Weatlas"];
				}
				trip.forEach(adv => {
					let pvalue;
					adv.advertiser = "Tripster";
					if(adv.price.currency == "EUR"){
						pvalue = adv.price.value * this.curs_euro;
					} else if(adv.price.currency == "USD"){
						pvalue = adv.price.value * this.curs_dollar;
					} else if(adv.price.currency == "UAH"){
						pvalue = adv.price.value * this.curs_grvn;
					} else if(adv.price.currency == "RUB"){
						pvalue = adv.price.value;
					}
					adv.result_price = Math.round(pvalue) + ' руб';
					adv.result_title = adv.title;
					adv.result_img = adv.photos[0].thumbnail;
					adv.result_description = adv.tagline;
					adv.result_url = 'https://tp.media/r?marker=200556&p=652&u=' + adv.url;
					adv.result_meet_place = adv['meeting_point'].text;
				});
				sput.forEach(adv => {
					let pvalue;
					adv.advertiser = "Sputnik8";
					pvalue = adv['order_options'][0]['order_lines'][0]["all_prices"]["RUB"];
					if(pvalue == 0){
							pvalue = adv['order_options'][1]['order_lines'][0]["all_prices"]["RUB"];
					}
					adv.result_price = Math.round(pvalue) + ' руб';
					adv.result_title = adv.title;
					if(adv.cover_photo != null){
						adv.result_img = adv.cover_photo.big;
					} else {
						adv.result_img = '';
					}
					adv.result_description = adv.description;
					adv.result_url = 'https://tp.media/r?marker=200556&p=656&u=' + adv.url;
					adv.result_meet_place = adv['begin_place'].address;
				});
				surp.forEach(adv => {
					let pvalue;
					adv.advertiser = "Surprise_Me";
					if(adv.currency.code == "EUR"){
						pvalue = adv.price * this.curs_euro;
					} else if(adv.currency.code == "USD"){
						pvalue = adv.price * this.curs_dollar;
					} else if(adv.currency.code == "UAH"){
						pvalue = adv.price * this.curs_grvn;
					} else if(adv.currency.code == "RUB"){
						pvalue = adv.price;
					}
					adv.result_price = Math.round(pvalue) + ' руб';
					adv.result_title = adv.name;
					adv.result_img = adv.preview_image;
					adv.result_description = adv.caption;
					adv.result_url = 'https://tp.media/r?marker=200556&p=4487&u=https://surprizeme.ru/ru/store/' + adv.slug + '/?sub_id=200556';
					adv.result_meet_place = adv.start_location;
				});
				weat.forEach(adv => {
					let pvalue;
					adv.advertiser = "Weatlas"
					if(adv.Currency == "EUR"){
						pvalue = adv.Price * this.curs_euro;
					} else if(adv.Currency == "USD"){
						pvalue = adv.Price * this.curs_dollar;
					} else if(adv.Currency == "UAH"){
						pvalue = adv.Price * this.curs_grvn;
					} else if(adv.Currency == "RUB"){
						pvalue = adv.Price;
					}
					adv.result_price = Math.round(pvalue) + ' руб';
					adv.result_title = adv.name;
					adv.result_img = adv.photos.photo[0].standart;
					adv.result_description = adv.shortDescr;
					adv.result_url = 'https://tp.media/r?marker=200556&p=654&u='+adv.links.order;
					adv.result_meet_place = "";
				});
				resArr = [...trip,...sput,...surp,...weat];
				if(this.sort == 'price'){
					resArr = resArr.sort(function (a, b){
						a.result_price = a.result_price.replace(' руб','');
						b.result_price = b.result_price.replace(' руб','');
 						return (a.result_price - b.result_price);
					});
				} else if(this.sort == 'rating'){
					resArr = resArr.sort(function (a, b){
 						return (a.rating - b.rating);
					});
				}
				return resArr;
			},
			advlength:function(){
				let trip =0,sp = 0,sm = 0,we = 0;
				if(this.catsvarchecked.length == 0  && !this.weatlasfilter && !this.sputnikfilter && !this.surprisemefilter && !this.mobile_adv && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview){
					trip = this.advertsfiltered.Tripster.length;
				}
				if(!this.is_new && !this.child_friendly && !this.weatlasfilter && this.tagsvarchecked.length == 0 && !this.tripsterfilter && !this.surprisemefilter && !this.mobile_adv && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview){
					sp = this.advertsfiltered.Sputnik8.length;
				}
				if(!this.private && !this.group && !this.weatlasfilter && !this.sputnikfilter && !this.tripsterfilter && !this.is_new && !this.child_friendly && this.tagsvarchecked.length == 0 && this.catsvarchecked.length == 0){
					sm = this.advertsfiltered["Surprise_Me"].length;
				}
				if(!this.mobile_adv && !this.private && !this.group && !this.surprisemefilter && !this.tripsterfilter && !this.sputnikfilter && !this.is_new && !this.child_friendly && this.tagsvarchecked.length == 0 && this.catsvarchecked.length == 0 && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview){
					we = this.advertsfiltered["Weatlas"].length;
				}
				return trip + sp + sm + we;
			},
			minrating:function(){
				let minr = this.maxrating;
					this.adverts["Tripster"].forEach(adv => {
						if(adv.rating < minr){
							minr = adv.rating;
						}
					});
					this.adverts["Sputnik8"].forEach(adv => {
						if(adv.rating < minr){
							minr = adv.rating;
						}
					});
					this.adverts["Surprise_Me"].forEach(adv => {
						if(adv.rating == null){
							adv.rating = 0;
						}
						if(adv.rating < minr){
							minr = adv.rating;
						}
					});
					if(this.adverts["Weatlas"].length > 0){
						if(5 < minr){
							minr = 5;
						}
					}
				return minr;
			},
			maxrating:function(){
				let maxr = 0;
					this.adverts["Tripster"].forEach(adv => {
						if(adv.rating > maxr){
							maxr = adv.rating;
						}
					});
					this.adverts["Sputnik8"].forEach(adv => {
						if(adv.rating > maxr){
							maxr = adv.rating;
						}
					});
					this.adverts["Surprise_Me"].forEach(adv => {
						if(adv.rating == null){
							adv.rating = 0;
						}
						if(adv.rating > maxr){
							maxr = adv.rating;
						}
					});
					if(this.adverts["Weatlas"].length > 0){
						if(5 > maxr){
							maxr = 5;
						}
					}
				return maxr;
			},
				/*minduration:function(){
				let mind = this.maxduration;
					this.adverts["Tripster"].forEach(adv => {
						if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) < mind){
							mind = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
						}
					});
					this.adverts["Sputnik8"].forEach(adv => {
						if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) < mind){
							mind = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
						}
					});
					this.adverts['Surprise_Me'].forEach(adv => {
						if(adv.duration.replace("-","–").indexOf("–") > -1){
							let advresarr = adv.duration.replace("-","–").replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							if(advresarr[0] < mind){mind = advresarr[0];}
						} else {
							if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) < mind){
								mind = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."));
							}
						}
					});
					this.adverts['Weatlas'].forEach(adv => {
						if(adv.duration.indexOf("–") > -1){
							let advresarr = adv.duration.replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							if(advresarr[0] < mind){mind = advresarr[0];}
						} else if(adv.duration.indexOf('дня') > -1 || adv.duration.indexOf('день') > -1 || adv.duration.indexOf("ночь") > -1){
							let advval = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) * 12;
							if(advval < mind) {
								mind = advval;
							}
						} else if(adv.duration.indexOf("+") > -1){
							let advresarr = adv.duration.replace(",",".").split("+").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							if((advresarr[0] + advresarr[1]) < mind){mind = advresarr[0] + advresarr[1];}
						} else if(adv.duration.indexOf("минут") > -1){
							let advresarr, res;
							if(adv.duration.indexOf("час") > -1 || adv.duration.indexOf("часа") > -1 || adv.duration.indexOf("часов")){
								advresarr = adv.duration.replace("10 минут",'+'+1/6).replace("20 минут",'+'+1/3).replace("30 минут",'+'+0.5).replace("40 минут",'+'+2/3).replace('50 минут','+'+5/6).split('+').map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
								res = advresarr[0] + advresarr[1];
							} else {
								res = adv.duration.replace("10 минут",1/6).replace("20 минут",1/3).replace("30 минут",0.5).replace("40 минут",2/3).replace('50 минут',5/6);
							}
							if(res < mind){
								mind = res;
							}
						} else {
							if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) < mind){
								mind = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."));
							}
						}
					});
				return mind;
			},*/
			/*maxduration:function(){
				let maxd = 0;
					this.adverts["Tripster"].forEach(adv => {
						if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) > maxd){
							maxd = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
						}
					});
					this.adverts["Sputnik8"].forEach(adv => {
						if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) > maxd){
							maxd = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
						}
					});
					this.adverts['Surprise_Me'].forEach(adv =>{
						if(adv.duration.indexOf("–") > -1){
							let advresarr = adv.duration.replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							if(advresarr[1] > maxd){maxd = advresarr[1];}
						} else {
							if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) > maxd){
								maxd = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."));
							}
						}
					});
					this.adverts["Weatlas"].forEach(adv => {
						if(adv.duration.replace("-","–").indexOf("–") > -1){
							let advresarr = adv.duration.replace("-","–").replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							if(advresarr[1] > maxd){maxd = advresarr[1];}
						} else if(adv.duration.indexOf('дня') > -1 || adv.duration.indexOf('день') > -1 || adv.duration.indexOf("ночь") > -1){
							let advval = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) * 24;
							if(advval > maxd) {
								maxd = advval;
							}
						} else if(adv.duration.indexOf("+") > -1){
							let advresarr = adv.duration.replace(",",".").split("+").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							if((advresarr[0] + advresarr[1]) > maxd){maxd = advresarr[0] + advresarr[1];}
						} else if(adv.duration.indexOf("минут") > -1){
							let advresarr, res;
							if(adv.duration.indexOf("час") > -1 || adv.duration.indexOf("часа") > -1 || adv.duration.indexOf("часов")){
								advresarr = adv.duration.replace("10 минут",'+'+1/6).replace("20 минут",'+'+1/3).replace("30 минут",'+'+0.5).replace("40 минут",'+'+2/3).replace('50 минут','+'+5/6).split('+').map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
								res = advresarr[0] + advresarr[1];
							} else {
								res = adv.duration.replace("10 минут",1/6).replace("20 минут",1/3).replace("30 минут",0.5).replace("40 минут",2/3).replace('50 минут',5/6);
							}
							if(res > maxd){
								maxd = res;
							}
						}	else {
							if(+/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) > maxd){
								maxd = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."));
							}
						}
					});
				return maxd;
			},*/
			minprice:function(){
				let minp = this.maxprice;
					this.adverts["Tripster"].forEach(adv => {
						if(adv.price.currency == "EUR"){
							pvalue = adv.price.value * this.curs_euro;
						} else if(adv.price.currency == "USD"){
							pvalue = adv.price.value * this.curs_dollar;
						} else if(adv.price.currency == "UAH"){
							pvalue = adv.price.value * this.curs_grvn;
						} else if(adv.price.currency == "RUB"){
							pvalue = adv.price.value;
						}
						if(pvalue < minp){
							minp = pvalue;
						}
					});
					this.adverts["Sputnik8"].forEach(adv => {
						pvalue = adv['order_options'][0]['order_lines'][0]["all_prices"]["RUB"];
						if(pvalue == 0){
							pvalue = adv['order_options'][1]['order_lines'][0]["all_prices"]["RUB"];
						}
						if(pvalue < minp){
							minp = pvalue;
						}
					});
					this.adverts["Surprise_Me"].forEach(adv => {
						if(adv.currency.code == "EUR"){
							pvalue = adv.price * this.curs_euro;
						} else if(adv.currency.code == "USD"){
							pvalue = adv.price * this.curs_dollar;
						} else if(adv.currency.code == "UAH"){
							pvalue = adv.price * this.curs_grvn;
						} else if(adv.currency.code == "RUB"){
							pvalue = adv.price;
						}
						if(pvalue < minp){
							minp = pvalue;
						}
					});
					this.adverts["Weatlas"].forEach(adv => {
						if(adv.Currency == "EUR"){
							pvalue = adv.Price * this.curs_euro;
						} else if(adv.Currency == "USD"){
							pvalue = adv.Price * this.curs_dollar;
						} else if(adv.Currency == "UAH"){
							pvalue = adv.Price * this.curs_grvn;
						} else if(adv.Currency == "RUB"){
							pvalue = adv.Price;
						}
						if(pvalue < minp){
							minp = pvalue;
						}
					});
				return Math.round(minp);
			},
			maxprice:function(){
				let maxp = 0;
				let pvalue = 0;
					this.adverts["Tripster"].forEach(adv => {
						if(adv.price.currency == "EUR"){
							pvalue = adv.price.value * this.curs_euro;
						} else if(adv.price.currency == "USD"){
							pvalue = adv.price.value * this.curs_dollar;
						} else if(adv.price.currency == "UAH"){
							pvalue = adv.price.value * this.curs_grvn;
						} else if(adv.price.currency == "RUB"){
							pvalue = adv.price.value;
						}
						if(pvalue > maxp){
							maxp = pvalue;
						}
					});
					this.adverts["Sputnik8"].forEach(adv => {
						pvalue = adv['order_options'][0]['order_lines'][0]["all_prices"]["RUB"];
						if(pvalue == 0){
							pvalue = adv['order_options'][1]['order_lines'][0]["all_prices"]["RUB"];
						}
						if(pvalue > maxp){
							maxp = pvalue;
						}
					});
					this.adverts['Surprise_Me'].forEach (adv => {
						if(adv.currency.code == "EUR"){
							pvalue = adv.price * this.curs_euro;
						} else if(adv.currency.code == "USD"){
							pvalue = adv.price * this.curs_dollar;
						} else if(adv.currency.code == "UAH"){
							pvalue = adv.price * this.curs_grvn;
						} else if(adv.currency.code == "RUB"){
							pvalue = adv.price;
						}
						if(pvalue > maxp){
							maxp = pvalue;
						}
					});
				//}
				this.adverts["Weatlas"].forEach(adv => {
					if(adv.Currency == "EUR"){
							pvalue = adv.Price * this.curs_euro;
						} else if(adv.Currency == "USD"){
							pvalue = adv.Price * this.curs_dollar;
						} else if(adv.Currency == "UAH"){
							pvalue = adv.Price * this.curs_grvn;
						} else if(adv.Currency == "RUB"){
							pvalue = adv.Price;
						}
					if(pvalue > maxp){
						maxp = pvalue;
					}
				});
				return Math.round(maxp);
			},
			advertsfiltered:function() {
				this.pricefilteractive = false;
				//this.durationfilteractive = false;
				this.ratingfilteractive = false;
				this.adverts["Weatlas"].forEach(adv => {
					adv.rating = 5;
				});
				this.adverts["Sputnik8"].forEach(adv => {
					if(String(adv.title).indexOf('Online') > -1 || String(adv.title).indexOf('Онлайн') > -1 || String(adv.title).indexOf('online') > -1 || String(adv.description).indexOf('online') > -1 || String(adv.description).indexOf('Online') > -1 || String(adv['begin_place'].address).indexOf('online') > -1 || String(adv['begin_place'].address).indexOf('Online') > -1 || String(adv.title).indexOf('Zoom') > -1 || String(adv.title).indexOf('zoom') > -1 || String(adv.description).indexOf('zoom') > -1 || String(adv.description).indexOf('Zoom') > -1 || String(adv['begin_place'].address).indexOf('zoom') > -1 || String(adv['begin_place'].address).indexOf('Zoom') > -1){
						adv.online = "Да";
					} else{
						adv.online = "Нет";
					}
				});
				this.adverts["Tripster"].forEach(adv => {
					if(String(adv.title).indexOf('Online') > -1 || String(adv.title).indexOf('Онлайн') > -1 || String(adv.title).indexOf('online') > -1 || String(adv.tagline).indexOf('online') > -1 || String(adv.tagline).indexOf('Online') > -1 || String(adv['meeting_point'].text).indexOf('online') > -1 || String(adv['meeting_point'].text).indexOf('Online') > -1 || String(adv.title).indexOf('Zoom') > -1 || String(adv.title).indexOf('zoom') > -1 || String(adv.tagline).indexOf('zoom') > -1 || String(adv.tagline).indexOf('Zoom') > -1 || String(adv['meeting_point'].text).indexOf('zoom') > -1 || String(adv['meeting_point'].text).indexOf('Zoom') > -1){
						adv.online = "Да";
					} else {
						adv.online = "Нет";
					}
				});
				this.adverts["Surprise_Me"].forEach(adv => {
					if(adv.is_online){
						adv.online = "Да";
					} else {
						adv.online = "Нет";
					}
				});
				this.adverts["Weatlas"].forEach(adv => {
					if(String(adv.name).indexOf('Online') > -1 || String(adv.name).indexOf('Онлайн') > -1 || String(adv.name).indexOf('online') > -1 || String(adv.shortDescr).indexOf('online') > -1 || String(adv.shortDescr).indexOf('Online') > -1 || String(adv.name).indexOf('Zoom') > -1 || String(adv.name).indexOf('zoom') > -1 || String(adv.shortDescr).indexOf('zoom') > -1 || String(adv.shortDescr).indexOf('Zoom') > -1){
						adv.online = "Да";
					} else {
						adv.online = "Нет";
					}
				});
				if(this.durationtype == 'all' && !this.type_image && !this.type_video && !this.type_audio && !this.type_streetview && !this.mobile_adv && !this.surprisemefilter && !this.weatlasfilter && !this.sputnikfilter && !this.tripsterfilter && !this.offline && !this.online && (this.pricefilterstart == this.minprice && this.pricefilterend == this.maxprice) && (this.ratingfilterstart == this.minrating && this.ratingfilterend == this.maxrating) && this.is_new == false && this.child_friendly == false && this.group == false && this.private == false && this.tagsvarchecked.length == 0 && this.catsvarchecked.length == 0){
					return this.adverts;
				}
				let resfilter = Object.assign({}, this.adverts);
				if(this.durationtype == 'hours'){
					resfilter.Tripster = resfilter.Tripster.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) >= 0 && +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) <= 4);
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) >= 0 && +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) <= 4);
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => {
						let filterflag = false;
						if(adv.duration.indexOf("–") > -1){
							let advresarr = adv.duration.replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i >= 0  && i <= 4){
									filterflag = true;
								}
							}
							return filterflag;
						} else 	{
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
							return advdurres >= 0 && advdurres <= 4;
						}
					});
					resfilter['Weatlas'] = resfilter['Weatlas'].filter(adv => {
						if(adv.duration.replace("-","–").indexOf("–") > -1) {
							let filterflag = false;
							let advresarr = adv.duration.replace("-","–").replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i >= 0 && i <= 4){
									filterflag = true;
								}
							}
							return filterflag;
						} else if(adv.duration.indexOf('дня') > -1 || adv.duration.indexOf('день') > -1 || adv.duration.indexOf("ночь") > -1) {
							let advval = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) * 12;
							return advval >= 0 && advval <= 4;
						} else if(adv.duration.indexOf("+") > -1){
							let advresarr = adv.duration.replace(",",".").split("+").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							return (advresarr[0] + advresarr[1]) >= 0 && (advresarr[0] + advresarr[1]) <= 4;
						} else if(adv.duration.indexOf("минут") > -1) { 
							let advresarr, res;
							if(adv.duration.indexOf("час") > -1 || adv.duration.indexOf("часа") > -1 || adv.duration.indexOf("часов")){
								advresarr = adv.duration.replace("10 минут",'+'+1/6).replace("20 минут",'+'+1/3).replace("30 минут",'+'+0.5).replace("40 минут",'+'+2/3).replace('50 минут','+'+5/6).split('+').map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
								res = advresarr[0] + advresarr[1];
							} else {
								res = adv.duration.replace("10 минут",1/6).replace("20 минут",1/3).replace("30 минут",0.5).replace("40 минут",2/3).replace('50 минут',5/6);
							}
							return res >= 0 && res <= 4;
						} else {
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."))
							return advdurres >= 0  && advdurres <= 4;
						}
					});
				} else if(this.durationtype == 'day'){
					resfilter.Tripster = resfilter.Tripster.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) > 4 && +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) <= 12);
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) > 4 && +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) <= 12);
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => {
						let filterflag = false;
						if(adv.duration.indexOf("–") > -1){
							let advresarr = adv.duration.replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i > 4  && i <= 12){
									filterflag = true;
								}
							}
							return filterflag;
						} else 	{
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
							return advdurres > 4 && advdurres <= 12;
						}
					});
					resfilter['Weatlas'] = resfilter['Weatlas'].filter(adv => {
						if(adv.duration.replace("-","–").indexOf("–") > -1) {
							let filterflag = false;
							let advresarr = adv.duration.replace("-","–").replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i > 4 && i <= 12){
									filterflag = true;
								}
							}
							return filterflag;
						} else if(adv.duration.indexOf('дня') > -1 || adv.duration.indexOf('день') > -1 || adv.duration.indexOf("ночь") > -1) {
							let advval = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) * 12;
							return advval > 4 && advval <= 12;
						} else if(adv.duration.indexOf("+") > -1){
							let advresarr = adv.duration.replace(",",".").split("+").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							return (advresarr[0] + advresarr[1]) > 4 && (advresarr[0] + advresarr[1]) <= 12;
						} else if(adv.duration.indexOf("минут") > -1) { 
							let advresarr, res;
							if(adv.duration.indexOf("час") > -1 || adv.duration.indexOf("часа") > -1 || adv.duration.indexOf("часов")){
								advresarr = adv.duration.replace("10 минут",'+'+1/6).replace("20 минут",'+'+1/3).replace("30 минут",'+'+0.5).replace("40 минут",'+'+2/3).replace('50 минут','+'+5/6).split('+').map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
								res = advresarr[0] + advresarr[1];
							} else {
								res = adv.duration.replace("10 минут",1/6).replace("20 минут",1/3).replace("30 минут",0.5).replace("40 минут",2/3).replace('50 минут',5/6);
							}
							return res > 4 && res <= 12;
						} else {
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."))
							return advdurres > 4  && advdurres <= 12;
						}
					});
				} else if(this.durationtype == 'several') {
					resfilter.Tripster = resfilter.Tripster.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) > 12);
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) > 12);
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => {
						let filterflag = false;
						if(adv.duration.indexOf("–") > -1){
							let advresarr = adv.duration.replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i > 12){
									filterflag = true;
								}
							}
							return filterflag;
						} else 	{
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
							return advdurres > 12;
						}
					});
					resfilter['Weatlas'] = resfilter['Weatlas'].filter(adv => {
						if(adv.duration.replace("-","–").indexOf("–") > -1) {
							let filterflag = false;
							let advresarr = adv.duration.replace("-","–").replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i > 12){
									filterflag = true;
								}
							}
							return filterflag;
						} else if(adv.duration.indexOf('дня') > -1 || adv.duration.indexOf('день') > -1 || adv.duration.indexOf("ночь") > -1) {
							let advval = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) * 12;
							return advval > 12;
						} else if(adv.duration.indexOf("+") > -1){
							let advresarr = adv.duration.replace(",",".").split("+").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							return (advresarr[0] + advresarr[1]) > 12;
						} else if(adv.duration.indexOf("минут") > -1) { 
							let advresarr, res;
							if(adv.duration.indexOf("час") > -1 || adv.duration.indexOf("часа") > -1 || adv.duration.indexOf("часов")){
								advresarr = adv.duration.replace("10 минут",'+'+1/6).replace("20 минут",'+'+1/3).replace("30 минут",'+'+0.5).replace("40 минут",'+'+2/3).replace('50 минут','+'+5/6).split('+').map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
								res = advresarr[0] + advresarr[1];
							} else {
								res = adv.duration.replace("10 минут",1/6).replace("20 минут",1/3).replace("30 минут",0.5).replace("40 минут",2/3).replace('50 минут',5/6);
							}
							return res > 12;
						} else {
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."))
							return advdurres > 12;
						}
					});
				}
				if(this.type_image){
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.content_types.image == true);
				}
				if(this.type_video){
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.content_types.video == true);
				}
				if(this.type_audio){
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.content_types.audio == true);
				}
				if(this.type_streetview){
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.content_types.streetview == true);
				}
				if(this.offline){
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.online == 'Нет');
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => adv.online == 'Нет');
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.online == 'Нет');
					resfilter["Weatlas"] = resfilter["Weatlas"].filter(adv => adv.online == 'Нет');
				}
				if(this.online){
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.online == 'Да');
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => adv.online == 'Да');
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.online == 'Да');
					resfilter["Weatlas"] = resfilter["Weatlas"].filter(adv => adv.online == 'Да');
				}
				if(this.pricefilterstart != this.minprice || this.pricefilterend != this.maxprice){
					resfilter.Tripster = resfilter.Tripster.filter(adv => {
						let pvalue = 0;
						if(adv.price.currency == "EUR"){
							pvalue = adv.price.value * this.curs_euro;
						} else if(adv.price.currency == "USD"){
							pvalue = adv.price.value * this.curs_dollar;
						} else if(adv.price.currency == "UAH"){
							pvalue = adv.price.value * this.curs_grvn;
						} else if(adv.price.currency == "RUB"){
							pvalue = adv.price.value;
						}
						return Math.round(pvalue) >= this.pricefilterstart && Math.round(pvalue) <= this.pricefilterend;
					});
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => Math.round(adv['order_options'][0]['order_lines'][0]["all_prices"]["RUB"]) >= this.pricefilterstart && Math.round(adv['order_options'][0]['order_lines'][0]["all_prices"]["RUB"]) <= this.pricefilterend);
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => {
						let pvalue = 0;
						if(adv.currency.code == "EUR"){
							pvalue = adv.price * this.curs_euro;
						} else if(adv.currency.code == "USD"){
							pvalue = adv.price * this.curs_dollar;
						} else if(adv.currency.code == "UAH"){
							pvalue = adv.price * this.curs_grvn;
						} else if(adv.currency.code == "RUB"){
							pvalue = adv.price;
						}
						return Math.round(pvalue) >= this.pricefilterstart && Math.round(pvalue) <= this.pricefilterend;
					});
					resfilter['Weatlas'] = resfilter['Weatlas'].filter(adv => {
						if(adv.Currency == "EUR"){
							pvalue = adv.Price * this.curs_euro;
						} else if(adv.Currency == "USD"){
							pvalue = adv.Price * this.curs_dollar;
						} else if(adv.Currency == "UAH"){
							pvalue = adv.Price * this.curs_grvn;
						} else if(adv.Currency == "RUB"){
							pvalue = adv.Price;
						}
						return Math.round(pvalue) >= this.pricefilterstart && Math.round(pvalue) <= this.pricefilterend;
					});
					this.pricefilteractive = true;
				}
				/*if(this.durationfilterstart != this.minduration || this.durationfilterend != this.maxduration){
					resfilter.Tripster = resfilter.Tripster.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) >= this.durationfilterstart && +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) <= this.durationfilterend);
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) >= this.durationfilterstart && +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration) <= this.durationfilterend);
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => {
						let filterflag = false;
						if(adv.duration.indexOf("–") > -1){
							let advresarr = adv.duration.replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i >= this.durationfilterstart  && i <= this.durationfilterend){
									filterflag = true;
								}
							}
							return filterflag;
						} else 	{
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration);
							return advdurres >= this.durationfilterstart  && advdurres <= this.durationfilterend;
						}
					});
					resfilter['Weatlas'] = resfilter['Weatlas'].filter(adv => {
						if(adv.duration.replace("-","–").indexOf("–") > -1) {
							let filterflag = false;
							let advresarr = adv.duration.replace("-","–").replace(",",".").split("–").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							for(let i = advresarr[0];i <= advresarr[1];i += 0.25){
								if(i >= this.durationfilterstart  && i <= this.durationfilterend){
									filterflag = true;
								}
							}
							return filterflag;
						} else if(adv.duration.indexOf('дня') > -1 || adv.duration.indexOf('день') > -1 || adv.duration.indexOf("ночь") > -1) {
							let advval = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",",".")) * 12;
							return advval >= this.durationfilterstart && advval <= this.durationfilterend;
						} else if(adv.duration.indexOf("+") > -1){
							let advresarr = adv.duration.replace(",",".").split("+").map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
							return (advresarr[0] + advresarr[1]) >= this.durationfilterstart && (advresarr[0] + advresarr[1]) <= this.durationfilterend;
						} else if(adv.duration.indexOf("минут") > -1) { 
							let advresarr, res;
							if(adv.duration.indexOf("час") > -1 || adv.duration.indexOf("часа") > -1 || adv.duration.indexOf("часов")){
								advresarr = adv.duration.replace("10 минут",'+'+1/6).replace("20 минут",'+'+1/3).replace("30 минут",'+'+0.5).replace("40 минут",'+'+2/3).replace('50 минут','+'+5/6).split('+').map(advdur => {return +/[0-9]+\.[0-9]+|\d+/.exec(advdur)});
								res = advresarr[0] + advresarr[1];
							} else {
								res = adv.duration.replace("10 минут",1/6).replace("20 минут",1/3).replace("30 минут",0.5).replace("40 минут",2/3).replace('50 минут',5/6);
							}
							return res >= this.durationfilterstart && res <= this.durationfilterend;
						} else {
							let advdurres = +/[0-9]+\.[0-9]+|\d+/.exec(adv.duration.replace(",","."))
							return advdurres >= this.durationfilterstart  && advdurres <= this.durationfilterend;
						}
					});
					this.durationfilteractive = true;
				}*/
				if(this.ratingfilterstart != this.minrating || this.ratingfilterend != this.maxrating){
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.rating >= this.ratingfilterstart && adv.rating <= this.ratingfilterend);
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => adv.rating >= this.ratingfilterstart && adv.rating <= this.ratingfilterend);
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.rating >= this.ratingfilterstart && adv.rating <= this.ratingfilterend);
					resfilter['Weatlas'] = resfilter['Weatlas'].filter(adv => adv.rating >= this.ratingfilterstart && adv.rating <= this.ratingfilterend);
					this.ratingfilteractive = true;
				}
				if(this.is_new){
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.is_new == true);
					//this.tripsterfilter = true;
				}
				if(this.mobile_adv){
					resfilter['Surprise_Me'] = resfilter['Surprise_Me'].filter(adv => adv.types.audioguide == true);
					//this.surprisemefilter = true;
				}
				if(this.child_friendly) {
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.child_friendly == true);
					//this.tripsterfilter = true;
				}
				if(this.group) {
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.type == 'group');
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => adv.product_type == 'shared');
				}
				if(this.private) {
					resfilter.Tripster = resfilter.Tripster.filter(adv => adv.type == 'private');
					resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => adv.product_type == 'private');
				}
				if(this.tagsvarchecked.length > 0) {
					for(let i = 0;i < this.tagsvarchecked.length;i++){
						//this.tripsterfilter = true;
						resfilter.Tripster = resfilter.Tripster.filter(adv => {
							let flag = false;
							adv.tags.forEach(advtag => {
								if(advtag.name == this.tagsvarchecked[i]) {
									flag = true;
								}
							});
							return flag;
						});
					}
				}
				if(this.catsvarchecked.length > 0) {
					for(let i = 0;i < this.catsvarchecked.length;i++){
						//this.sputnikfilter = true;
						resfilter.Sputnik8 = resfilter.Sputnik8.filter(adv => {
							let flag = false;
							adv.categories.forEach(cattag => {
								if(cattag.name == this.catsvarchecked[i]){
									flag = true;
								}
							});
							return flag;
						});
					}
				}
				return resfilter;
			},
			tagscheck:function() {
				let alltags = [];
				this.adverts.Tripster.forEach(adv => {
					 adv.tags.forEach(tag => {
						alltags.push(tag.name)
					});
				});
				return Array.from(new Set(alltags));
			},
			categoriescheck:function() {
				let allcats = [];
				this.adverts.Sputnik8.forEach(adv =>{
					adv.categories.forEach(cat => {
						allcats.push(cat.name);
					});
				});
				return Array.from(new Set(allcats));
			}
		},
		created:function() {
			let compdata = localStorage.getItem('comparison');
			if(compdata != null) {
				this.comparison = JSON.parse(compdata);
			}
		}
	});
</script>