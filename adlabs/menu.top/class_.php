<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;

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
                "LINK"       => $arProps["LINK"]["VALUE"]
            );
            
        }
        return $resultElements;
    }
    
    protected function getResult()
    {
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