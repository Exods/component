<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use \Bitrix\Main\Data\Cache;

class Portfolio extends CBitrixComponent
{
    protected $errors = array();
    protected $DIR ;

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

    private function getPortfolio(){
        $res = CIBlockElement::GetList(
            [],
            ['IBLOCK_ID'=>$this->arParams['IBLOCK_ID'],'ID'=>$this->arParams['LINK_PORTFOLIO']],
            false,
            false,
            ['IBLOCK_ID','ID','NAME','CODE','DETAIL_PAGE_URL','PREVIEW_PICTURE' ]
        );

        while($result = $res->GetNext()) {
            $arResult[$result['ID']]['PREVIEW_PICTURE'] = CFile::ResizeImageGet($result['PREVIEW_PICTURE'], array('width'=>270, 'height'=>270), BX_RESIZE_IMAGE_EXACT , false);
            $arResult[$result['ID']]['NAME'] = $result['NAME'];
            $arResult[$result['ID']]['IBLOCK_SECTION_ID'] = $result['IBLOCK_SECTION_ID'];
        }
        return $arResult;
    }
    protected function setKeyCache()
    {
        $this->DIR = serialize($this->arResult['ID']);
    }
    protected function getResult()
    {
        $this->setKeyCache();
        $cache = Cache::createInstance();
        if ($cache->initCache(0, "redbee_portfolio_{$this->DIR}")) {
            $vars = $cache->getVars();
            $arSections = $vars["redbee_portfolio_{$this->DIR}"];
        }
        elseif ($cache->startDataCache()) {

            $arParams = $this->arParams;

            if ($this->errors) {
                throw new SystemException(current($this->errors));
            }
            $ITEMS = $this->getPortfolio();
            $cache->endDataCache(array("redbee_portfolio_{$this->DIR}" => $ITEMS));
        }

        $this->arResult["ITEMS"] = $ITEMS;

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