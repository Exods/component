<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$countSections = count($arResult["ITEMS"]);
if ($countSections > 0):?>
<?IF(0):?>

    <style scoped>
        @media (max-width: 991px) {
        <?
        $i = 1;
        foreach($arResult["ITEMS"] as $key => $SECTION):?>

        <?$arIMG = CFile::ResizeImageGet($SECTION["ICON_ID"], array("width"=>250, "height"=>250), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);?>
        <?if($SECTION["LINK"] == "/action/"):?>
            .navbar ul.nav li.actio > a {
                background: url("<?=$arIMG["src"]?>") no-repeat 10px 7px;
                background-size: 25px;
            }

        <?else:?>
            .navbar ul.nav li.item<?=$i?> > a {
                background: url("<?=$arIMG["src"]?>") no-repeat 10px 7px;
                background-size: 25px;
            }

        <?endif;?>
        <?
        $i++;
        endforeach;
        ?>
        }

        #dopmenu9 .owl-item {
            margin: 30px;
        }

        #dopmenu9 .owl-item img {
            display: block;
            width: 100%;
            height: 220px;
        }

        .action_wrap {
            display: flex;
            justify-content: space-around;

        }
    </style>

    <?ENDIF;?>

    <div class="navbar navbar-inverse navbar-fixed-top_bec" role="navigation">
        <div class="container">
            <div class="but_cat_mob">
                Каталог товаров<span></span>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?
                    $i = 1;
                    foreach ($arResult["ITEMS"] as $key => $SECTION):?>
                        <?
                        $rel = ' data-rel="' . $i . '"';
//                        $rel = '';
                        /*if($SECTION["LINK"] == "/action/"){
                                        $rel = '';
                        }*/
                        if ($SECTION["LINK"] == "/action/sogrevayushchie_skidki_do_25_na_raznye_kategorii_tovarov/") {
                            $rel = '';
                        }

                        $sectionClass = 'class="item' . $i . ' ff_menu"';
                        if ($i == 1) {
                            $sectionClass = 'class="item' . $i . ' ff_menu first"';
                        }
                        if ($i == $countSections) {
                            $sectionClass = 'class="item' . $i . ' ff_menu last"';
                            /* if($SECTION["LINK"] == "/action/"){
                                $sectionClass = 'class="actio last"';
                            }
                            if($SECTION["LINK"] == "/action/sogrevayushchie_skidki_do_25_na_raznye_kategorii_tovarov/"){
                                $sectionClass = 'class="actio last"';
                        }*/
                        }
                        ?>
                        <li <?= $sectionClass ?><?= $rel ?>>
                            <?$percent = '<img class="percent-solid" src="'.SITE_TEMPLATE_PATH.'/assets/images/percent-solid.svg" alt="percent">'?>
                            <a href="<?= $SECTION["LINK"] ?>"><?= $SECTION["NAME"] ?><?=($SECTION["LINK"]=='/action/')?$percent:''?></a>
                            <?
                            $countItems = count($SECTION["ITEMS"]);
                            if ($countItems > 0):?>
                                <ul>
                                    <?
                                    $j = 0;
                                    foreach ($SECTION["ITEMS"] as $ITEM):
                                        if($SECTION["LINK"] != "/action/"){
                                        $classLink = "";
                                        if ($j == 0) {
                                            $classLink = ' class="first"';
                                        }
                                        if ($j == $countItems - 1) {
                                            $classLink = ' class="last"';
                                        }
                                        ?>
                                        <li><a<?= $class ?> href="<?= $ITEM["LINK"] ?>"><?= $ITEM["NAME"] ?></a></li>
                                        <?
                                        $j++;
                                        }
                                    endforeach; ?>
                                </ul>
                            <?endif; ?>
                        </li>
                        <?
                        $i++;
                    endforeach; ?>
                </ul>
            </div>
        </div>

        <?
        $i = 1;
        foreach ($arResult["ITEMS"] as $key => $SECTION):?>
            <? if ($SECTION["LINK"] == '/action/'):?>
                <? if (0)://old_version
                    ?>
                    <div class="dop_menu" id="dopmenu<?= $i ?>">
                        <div class="container">
                            <div class="action_wrap small-carousel__carousel_">
                                <!--                   <div class="phone col-md-12 line">-->

                                <?

                                $countItemsAction = count($SECTION["ITEMS"]);
                                if ($countItemsAction > 0):?>
                                    <?
                                    $j = 0;
                                    foreach ($SECTION["ITEMS"] as $ITEM):?>
                                        <?
                                        if ($ITEM["PICTURE"]) {
                                            $classLI = '';
                                            if ($j == 0) {
                                                $classLI = ' class="first"';
                                            }
                                            if ($j == $countItemsAction - 1) {
                                                $classLI = ' class="last"';
                                            }
                                            ?>
                                            <div class="phone">
                                                <a href="<?= $ITEM["LINK"] ?>">

                                                    <? $arIMG = CFile::ResizeImageGet($ITEM["PICTURE"], array("width" => 355, "height" => 200, BX_RESIZE_IMAGE_EXACT, false, false, false, 90)) ?>
                                                    <img class="lazy" src="<?= $arIMG["src"] ?>"
                                                         alt="<?= $SECTION["NAME"] ?>"
                                                         >
                                                </a>
                                            </div>
                                            <?
                                            $j++;
                                        }
                                    endforeach; ?>
                                <?endif; ?>
                            </div>
                        </div>
                        <!--                   <div class="phone /*col-md-5*/" style="float:right;">-->
                        <!--                       <a href="--><?//=$SECTION["LINK"]
                        ?><!--">-->
                        <!--                           --><?//$arIMG = CFile::ResizeImageGet($SECTION["PICTURE_ID"], array("width"=>570, "height"=>410), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);
                        ?>
                        <!--                           <img class="lazy" src="--><?//=$arIMG["src"]
                        ?><!--" alt="--><?//=$SECTION["NAME"]
                        ?><!--" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">-->
                        <!--                       </a>-->
                        <!--                   </div>-->
                        <!--               </div>-->
                    </div>
                <?endif; ?>
                <?//////////////////////NEW_VER///////////////////////////////////
                ?>

                <div class="dop_menu" id="dopmenu<?= $i ?>">
                    <div class="container">
                        <div class="col-12">
                            <div class=" " >
                                <? $checkDates = "Y"; //Для актуальных акций проверяем текущую дату
                                if (htmlspecialchars($_POST["current"]) == "old-shares") //Если смотрим историю акций
                                {
                                    $GLOBALS['arrFilter'] = array(">ACTIVE_TO" => date("d.m.Y H:i:s"));//
                                    $checkDates = "N";
                                }
                                ?>
                                <?php
                                //Добавляем в фильтр регионы
                                //global $CitySwitch;
                                //$GLOBALS['arrFilter'][] = array("LOGIC" => "OR", array('PROPERTY_REGIONS' => false), array('PROPERTY_REGIONS' => $CitySwitch->getIDs()));;
                                ?>
                                <?IF(1):?>
                                
<!--                                --><?//$componentName= ($APPLICATION->GetCurDir()=='/test_dev/test_action/')?'devbars:news.list':'bitrix:news.list'?>
                                <?$APPLICATION->IncludeComponent(
                                 'devbars:news.list',
                                "shares_action",
                                Array(
                                "DISPLAY_DATE" => "Y",
                                "DISPLAY_NAME" => "Y",
                                "DISPLAY_PICTURE" => "Y",
                                "DISPLAY_PREVIEW_TEXT" => "Y",
                                "AJAX_MODE" => "N",
                                "IBLOCK_TYPE" => "moscow",
                                "IBLOCK_ID" => ACTION_IBLOCK_ID,
                                "NEWS_COUNT" => 20,
                                "SORT_BY1" => "SORT",
                                "SORT_ORDER1" => "ASC",
                                "SORT_BY2" => "ACTIVE_FROM",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "arrFilter",
                                "FIELD_CODE" => Array("ACTIVE_TO"),
                                "PROPERTY_CODE" => Array("DESCRIPTION"),
                                "CHECK_DATES" => $checkDates,
                                "DETAIL_URL" => "",
                                "PREVIEW_TRUNCATE_LEN" => "",
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "SET_TITLE" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_META_KEYWORDS" => "Y",
                                "SET_META_DESCRIPTION" => "Y",
                                "SET_LAST_MODIFIED" => "Y",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                                "PARENT_SECTION" => "",
                                "PARENT_SECTION_CODE" => "",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "CACHE_TYPE" => "A",
                                "CACHE_TIME" => "3600",
                                "CACHE_FILTER" => "Y",
                                "CACHE_GROUPS" => "Y",
                                "DISPLAY_TOP_PAGER" => "Y",
                                "DISPLAY_BOTTOM_PAGER" => "Y",
                                "PAGER_TITLE" => "",
                                "PAGER_SHOW_ALWAYS" => "Y",
                                "PAGER_TEMPLATE" => "",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "Y",
                                "PAGER_BASE_LINK_ENABLE" => "Y",
                                "SET_STATUS_404" => "N",
                                "SHOW_404" => "N",
                                "MESSAGE_404" => "",
                                "PAGER_BASE_LINK" => "",
                                "PAGER_PARAMS_NAME" => "arrPager",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_ADDITIONAL" => ""
                                )
                                );?>
                                <?ENDIF;?>
                            </div>
                        </div>
                    </div>

                </div>


                <?///////////////////////////////////////////////////////////////////
                ?>
            <? else:?>
                <div class="dop_menu" id="dopmenu<?= $i ?>">
                    <div class="container">
                        <div class="phone col-md-6 line">
                            <? if (0):?>
                                <div class="zg">Разделы каталога</div>
                            <?endif; ?>
                            <?
                            $countItems = count($SECTION["ITEMS"]);
                            if ($countItems > 0):?>
                                <ul class="ul_img">
                                    <?
                                    $j = 0;
                                    foreach ($SECTION["ITEMS"] as $ITEM):?>
                                        <?
                                        $classLI = '';
                                        if ($j == 0) {
                                            $classLI = ' class="first"';
                                        }
                                        if ($j == $countItems - 1) {
                                            $classLI = ' class="last"';
                                        }
                                        ?>
                                        <li<?= $classLI ?>>
                                            <a href="<?= $ITEM["LINK"] ?>"><span><?= $ITEM["NAME"] ?></span></a>
                                        </li>
                                        <?
                                        $j++;
                                    endforeach; ?>
                                </ul>
                            <?endif; ?>
                        </div>
                        <div class="phone col-md-5" style="float:right;">
                            <a href="<?= $SECTION["LINK"] ?>">
                                <? $arIMG = CFile::ResizeImageGet($SECTION["PICTURE_ID"], array("width" => 500, "height" => 270), BX_RESIZE_IMAGE_EXACT, false, false, false, 90); ?>
                                <img class="lazy" src="<?= $arIMG["src"] ?>" alt="<?= $SECTION["NAME"] ?>"
                                     >
                            </a>
                        </div>
                    </div>
                </div>
                <?
                $i++;
            endif;
        endforeach; ?>
    </div>
<? endif; ?>
<script>
    $(document).ready(function () {
        $(document).ready(function () {
            $(".action_menu_").owlCarousel({
                items: 2,
                rtl:true,
                navigation: true,

                itemsDesktop: [1583, 2],
                itemsTablet: [991, 1],
                itemsMobile: [300, 1],
                dots: true,
                loop: true,
            });
        });
    })
</script>
<style >
    @media (max-width: 991px) {
    <?
    $i = 1;
    foreach($arResult["ITEMS"] as $key => $SECTION):?>

    <?$arIMG = CFile::ResizeImageGet($SECTION["ICON_ID"], array("width"=>250, "height"=>250), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);?>
    <?if($SECTION["LINK"] == "/action/"):?>
        .navbar ul.nav li.actio > a {
            background: url("<?=$arIMG["src"]?>") no-repeat 10px 7px;
            background-size: 25px;
        }

    <?else:?>
        .navbar ul.nav li.item<?=$i?> > a {
            background: url("<?=$arIMG["src"]?>") no-repeat 10px 7px;
            background-size: 25px;
        }

    <?endif;?>
    <?
    $i++;
    endforeach;
    ?>
    }

    #dopmenu9 .owl-item {
        margin: 30px;
    }

    #dopmenu9 .owl-item img {
        display: block;
        width: 100%;
        height: 220px;
    }

    .action_wrap {
        display: flex;
        justify-content: space-around;

    }
</style>
