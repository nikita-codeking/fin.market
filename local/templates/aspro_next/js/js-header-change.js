//#netwiz start многострочный заголовок
function pagetitleSpanAdd() {
    var pagetitle = document.getElementById("pagetitle").textContent;
    var pageUrl = window.location.pathname;

    console.log('text');

    function headerTextFormat() {
        pagetitle = pagetitle.replace('Поможем', '<span class="smalltext">ПОМОЖЕМ</span>');
        pagetitle = pagetitle.replace('ПОМОЖЕМ', '<span class="smalltext">ПОМОЖЕМ</span>');
        pagetitle = pagetitle.replace('подобрать', '<b>ПОДОБРАТЬ</b>');
        pagetitle = pagetitle.replace('ПОДОБРАТЬ', '<b>ПОДОБРАТЬ</b>');
        pagetitle = pagetitle.replace('СРАВНИТЬ', '<b>СРАВНИТЬ</b>');
        pagetitle = pagetitle.replace('сравнить', '<b>СРАВНИТЬ</b>');
        pagetitle = pagetitle.replace('где ВЫГОДНЕЕ условия на', '<br><span class="smallesttext">где</span> <b>ВЫГОДНЕЕ</b> <span class="smallesttext">условия на</span>');
        pagetitle = pagetitle.replace('где ВЫГОДНЕЙ ТАРИФЫ НА', '<br><span class="smallesttext">где</span> <b>ВЫГОДНЕЙ</b> <span class="smallesttext">ТАРИФЫ НА</span>');
        pagetitle = pagetitle.replace('условия, где ВЫГОДНЕЙ', '<br><span class="smallesttext">условия, где</span> <b>ВЫГОДНЕЙ</b>');
        pagetitle = pagetitle.replace('условия, где ВЫГОДНЕЕ', '<br><span class="smallesttext">условия, где</span> <b>ВЫГОДНЕЕ</b>');
        pagetitle = pagetitle.replace('где ВЫГОДНЕЕ ТАРИФЫ НА', '<br><span class="smallesttext">где</span> <b>ВЫГОДНЕЕ</b> <span class="smallesttext">ТАРИФЫ НА</span>');
        pagetitle = pagetitle.replace('Кредитные карты', '<span class="largetext">Кредитные карты</span><span class="smalltext regfix">');
        pagetitle = pagetitle.replace('Карты рассрочки', '<span class="largetext">Карты рассрочки</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Дебетовые карты', '<span class="largetext">Дебетовые карты</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Кредиты наличными', '<span class="largetext">Кредиты наличными</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Займы', '<span class="largetext">Займы</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Автокредиты', '<span class="largetext">Автокредиты</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Рефинансирование', '<span class="largetext">Рефинансирование</span><span class="smalltext">');
        pagetitle = pagetitle.replace('КАСКО', '<span class="largetext">КАСКО</span><span class="smalltext">');
        pagetitle = pagetitle.replace('ОСАГО', '<span class="largetext">ОСАГО</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Страхование туристов', '<span class="largetext">Страхование туристов</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Медицинское страхование', '<span class="largetext">Медицинское страхование</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Страхование имущества', '<span class="largetext">Страхование имущества</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Ипотечное страхование', '<span class="largetext">Ипотечное страхование</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Спортивное страхование', '<span class="largetext">Спортивное страхование</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Расчётно-кассовое обслуживание', '<span class="largetext">Расчётно-кассовое обслуживание</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Расчётные счета', '<span class="largetext">Расчётные счета</span><span class="smalltext">');
        pagetitle = pagetitle.replace('Ипотека', '<span class="largetext">Ипотека</span><span class="smalltext">');
    }
    if (
        pageUrl.indexOf('/catalog/karty/kreditnye_karty') != -1 && pagetitle.indexOf('Кредитные карты') != -1 ||
        pageUrl.indexOf('/catalog/karty/karty_rassrochki') != -1 && pagetitle.indexOf('Карты рассрочки') != -1 ||
        pageUrl.indexOf('/catalog/karty/debetovye_karty') != -1 && pagetitle.indexOf('Дебетовые карты') != -1 ||
        pageUrl.indexOf('/catalog/kredity/kredity_nalichnymi') != -1 && pagetitle.indexOf('Кредиты наличными') != -1 ||
        pageUrl.indexOf('/catalog/kredity/zaymy') != -1 && pagetitle.indexOf('Займы') != -1 ||
        pageUrl.indexOf('/catalog/kredity/avtokredity') != -1 && pagetitle.indexOf('Автокредиты') != -1 ||
        pageUrl.indexOf('/catalog/kredity/refinansirovanie') != -1 && pagetitle.indexOf('Рефинансирование') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/kasko') != -1 && pagetitle.indexOf('КАСКО') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/osago') != -1 && pagetitle.indexOf('ОСАГО') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/strakhovanie_puteshestvennikov') != -1 && pagetitle.indexOf('Страхование туристов') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/meditsinskoe_strakhovanie') != -1 && pagetitle.indexOf('Медицинское страхование') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/strakhovanie_imushchestva') != -1 && pagetitle.indexOf('Страхование имущества') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/ipotechnoe_strakhovanie') != -1 && pagetitle.indexOf('Ипотечное страхование') != -1 ||
        pageUrl.indexOf('/catalog/strakhovanie/sportivnoe_strakhovanie') != -1 && pagetitle.indexOf('Спортивное страхование') != -1 ||
        pageUrl.indexOf('/catalog/dlya_biznesa/raschetnye_scheta') != -1 && pagetitle.indexOf('Расчётные счета') != -1 ||
        pageUrl.indexOf('/catalog/dlya_biznesa/raschetnye_scheta') != -1 && pagetitle.indexOf('Расчётно-кассовое обслуживание') != -1 ||
        pageUrl.indexOf('/catalog/kredity/ipoteka') != -1 && pagetitle.indexOf('Ипотека') != -1
    ) {
        document.getElementById('pagetitle').classList.add("customtext");
        headerTextFormat();
        document.getElementById('pagetitle').innerHTML = pagetitle;
    }
}
pagetitleSpanAdd();
//#netwiz end многострочный заголовок