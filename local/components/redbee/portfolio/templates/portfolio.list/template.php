<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="instagram-new instagram-new-kuhnya" id="instagram-new">
    <div class="instagram-new__body">
        <div class="instagram-new__title">портфолио silver home</div>
        <div class="instagram-new__subtitle"><span>Смотрите наши новые работы в Портфолио</span></div>
        <div class="instagram-new__wrapper instagram-new__wrapper_slider">
                <?foreach ($arResult['ITEMS'] as $ITEM):?>
                <div class="instagram-new__item">
                    <a href="/portfolio/?show=<?=$ITEM['IBLOCK_SECTION_ID']?>" target="_blank">
                        <img src="<?=$ITEM['PREVIEW_PICTURE']['src']?>" alt="<?=$ITEM['NAME']?>">
                    </a>
                </div>
                <?endforeach;?>
            <div class="instagram-new__top-line kuhnya-instagram-new__top-line"></div>
            <div class="instagram-new__right-line kuhnya-instagram-new__right-line"></div>
            <div class="instagram-new__left-line kuhnya-instagram-new__left-line"></div>
            <div class="instagram-new__bottom-line kuhnya-instagram-new__bottom-line"></div>
            <div class="instagram-new__right-top-square"></div>
            <div class="instagram-new__right-bottom-square"></div>
            <div class="instagram-new__left-top-square"></div>
            <div class="instagram-new__left-bottom-square"></div>
            <div class="instagram-new__line kuhnya-instagram-new__line"></div>
        </div>
        <div class="instagram-new__link">
            <span>
                <a href="/portfolio/" target="_blank">перейти в портфолио</a>
            </span>
        </div>
    </div>
</div>
