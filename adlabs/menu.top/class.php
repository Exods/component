<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;
use \Bitrix\Main\Data\Cache;


if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CBitrixComponent::includeComponentClass("adlabs:menu.top");  

class Mainmenu extends CBitrixComponent
{
    protected $errors = array(); 
    
    public function onIncludeComponentLang()
    {
        Loc::loadMessages(__FILE__);
    }
    
    public function onPrepareComponentParams($arParams)
    {
        if(!isset($arParams["CACHE_TIME"])){
            $arParams["CACHE_TIME"] = 36000000;
        }
        return $arParams;
    }
    
    protected function checkModules()
    {
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('CPS_MODULE_NOT_INSTALLED', array('#NAME#' => 'iblock')));
    }
    
    private function getSections()
    {



        $resultSections = array();
        $resSections = CIBlockSection::GetList(
            array("SORT"=>"ASC"),
            array("IBLOCK_ID"=>$this->arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "CODE"=>$CODE), false,
            array("IBLOCK_ID","ID","NAME", "DESCRIPTION", "PICTURE", "DETAIL_PICTURE"), false 
        );
        
        while($obSec = $resSections->GetNext()) {
            $resultSections[$obSec["ID"]] = array(
                "ID"           => $obSec["ID"],
                "SORT"         => $obSec["SORT"],
                "NAME"         => $obSec["NAME"],
                "LINK"         => trim($obSec["DESCRIPTION"]),
                "PICTURE_ID"   => $obSec["PICTURE"],
                "ICON_ID"      => $obSec["DETAIL_PICTURE"], 
                "ITEMS"        => array()
            );
        }

        return $resultSections;
    }
    
    private function getElements()
    {
        $resultElements = array();
        $resElements = CIBlockElement::GetList(
            array("SORT"=>"ASC"),
            array('IBLOCK_ID'=>$this->arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS"=>"Y"), false, false,
            array("IBLOCK_ID", "ID", 'NAME', 'IBLOCK_SECTION_ID', 'SORT', 'PROPERTY_*')
            );
        
        while($obElem = $resElements->GetNextElement()){
            
            $arFields = $obElem->GetFields();
            $arProps  = $obElem->GetProperties();
            
            $resultElements[] = array(
                "ID"         => $arFields["ID"],
                "SORT"       => $arFields["SORT"],
                "NAME"       => $arFields["NAME"],
                "SECTION_ID" => $arFields["IBLOCK_SECTION_ID"],
                "LINK"       => $arProps["LINK"]["VALUE"],
                "PICTURE"    => $arProps["PICTURE"]["VALUE"]
            );
            
        }
        return $resultElements;
    }
    private function getAction(){
        $IBLOCK_ACTION = 13;
        $elements = array();
        $resElements = CIBlockElement::GetList(
            array("SORT"=>"ASC"),
            array('IBLOCK_ID'=>$IBLOCK_ACTION), false, false,
            array("IBLOCK_ID", "ID",'PREVIEW_PICTURE', 'NAME', 'SORT','DETAIL_PAGE_URL')
        );
        $i=0;
        while($obElem = $resElements->GetNext()){
            $elements[$i]["ID"] =$obElem['ID'];
            $elements[$i]["SORT"] =$obElem['SORT'];
            $elements[$i]["NAME"] =$obElem['NAME'];
            $elements[$i]["LINK"] =$obElem['DETAIL_PAGE_URL'];
            $elements[$i]["PICTURE"] =$obElem['PREVIEW_PICTURE'];
            $i++;
        }

        return $elements;
    }
    
    protected function getResult()
    {
        $cache = Cache::createInstance(); // получаем экземпл€р класса
        if ($cache->initCache(1440, "adlabs_menu_top_cache_9")) { // провер€ем кеш и задаЄм настройки
            $vars = $cache->getVars(); // достаем переменные из кеша
            $arSections = $vars['adlabs_menu_top_cache_9'];
        }
        elseif ($cache->startDataCache()) {
            // некоторые действи€...

            $arParams = $this->arParams;
        if ($this->errors) {
            throw new SystemException(current($this->errors));
        }
        
        $arSections = $this->getSections();
        $arElements = $this->getElements();
        foreach($arElements as $ITEM){
            if(!empty($ITEM["SECTION_ID"])){
                $arSections[$ITEM["SECTION_ID"]]["ITEMS"][] = $ITEM;
            }

        }
            $cache->endDataCache(array("adlabs_menu_top_cache_9" => $arSections)); // записываем в кеш
        }

        $this->arResult["ITEMS"] = $arSections;
        
    }
    
    public function executeComponent()
    {
        try
        {
            $this->checkModules();
            $this->getResult();
            $this->includeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }
    }
};