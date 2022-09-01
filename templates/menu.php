<div class="menu">
    <div class="contmenu">
        <div class="stolbmenu">
            <input type="checkbox" class="checkbox" id="catalog" />
            <label for="catalog">КАТАЛОГ</label>
            <div class="menuv">
                <?php
                $catalog = @mysql_query("SELECT * FROM catalog ORDER BY num",$db);
                $myrow = @mysql_fetch_array($catalog);
                if($myrow){
                    do{
                        echo '<a href="catalog?catalog='.$myrow["url"].'">'.$myrow["name"].'</a>';
                    }
                    while($myrow = @mysql_fetch_array($catalog));
                }
                ?>
            </div>
        </div>
        <div class="stolbmenu">
            <input type="checkbox" class="checkbox" id="brend" />
            <label for="brend">НАШИ БРЕНДЫ</label>
            <div class="menuv">
                <?php
                $catalog = @mysql_query("SELECT * FROM brends ORDER BY num",$db);
                $myrow = @mysql_fetch_array($catalog);
                if($myrow){
                    do{
                        echo '<a href="catalog?brend='.$myrow["url"].'">'.$myrow["name"].'</a>';
                    }
                    while($myrow = @mysql_fetch_array($catalog));
                }
                ?>
            </div>
            <a href="catalog?sale=sale" class="sal">SALE</a>
        </div>
        <div class="stolbmenu">
            <a href="info?info=opl">ОПЛАТА</a>
            <a href="info?info=dost">ДОСТАВКА</a>
            <a href="info?info=voz">ВОЗВРАТ</a>
            <a href="faq">FAQ</a>
            <a href="reviews">ОТЗЫВЫ</a>
        </div>
        <div class="stolbmenu">
            <a href="lookbook">LOOKBOOK</a>
            <a href="about">О НАС</a>
            <a href="contacts">КОНТАКТЫ</a>
        </div>
    </div>
</div>