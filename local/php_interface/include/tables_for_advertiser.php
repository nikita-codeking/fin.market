<?php
//require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
namespace Codeking\Advertiser;
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\Entity\Base;

class CountryTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'codeking_advertiser_country';
    }
    
    public static function getMap()
    {
        return array(
			new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
			)),
            new Entity\StringField('NAME', array(
                'required' => true,
            )),
            new Entity\IntegerField('Sputnik'),
            new Entity\IntegerField('Tripster')
        );
    }
}

class CityTable extends Entity\DataManager
{
	public static function getTableName()
    {
        return 'codeking_advertiser_city';
    }
	public static function getMap()
    {
        return array(
			new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
			)),
            new Entity\StringField('NAME', array(
                'required' => true,
            )),
            new Entity\IntegerField('Sputnik'),
            new Entity\IntegerField('Tripster'),
			new Entity\StringField('Surprise_Me'),
			new Entity\IntegerField('COUNTRY_ID'),
			(new Reference(
                    'COUNTRY',
                    CountryTable::class,
                    Join::on('this.COUNTRY_ID', 'ref.ID')
                ))
                ->configureJoinType('left')
        );
    }
}

function initTables()
{
	Base::getInstance(CountryTable::class)->createDbTable();
	Base::getInstance(CityTable::class)->createDbTable();
}
