<aside id="left-panel" class="sidebar">
    <div class="menu-container">
        <ul class="navigation metismenu" id="menu">
            <li class="parent {!! \Request::is('cpanel')? 'mm-active':null !!}">
                <a href="/cpanel/" aria-expanded="false"><i class="fa fa-home" ></i> <span>Home</span></a>
            </li>
            <li class="parent" {!! \Request::is('cpanel/payments')?'mm-active':null !!}>
                <a href="#" aria-expanded="false"><i class="fa fa-" ></i> <span>Платежи</span></a>
            </li>
            <li class="parent {!! \Request::is('cpanel/osmd','cpanel/osmd/*','cpanel/building','cpanel/building/*','cpanel/flats','cpanel/flats/*','cpanel/owner','cpanel/owner/*')? 'mm-active':null !!}">
                <a href="#" aria-expanded="false"><span class="fa arrow"></span><i class="fa fa-home" ></i> <span>Списки</span></a>
                <ul class="mm-collapse sub-navigation" aria-expanded="false">
                    <li class="{!! \Request::is('cpanel/osmd','cpanel/osmd/*')? 'mm-active':null !!}">
                        <a href="/cpanel/osmd" aria-expanded="false"><span class="hf-nav-item">ОСМД</span></a>
                    </li>
                    <li class="{!! \Request::is('cpanel/building','cpanel/building/*')? 'mm-active':null !!}">
                        <a href="/cpanel/building" aria-expanded="false"><span class="hf-nav-item">Дома</span></a>
                    </li>
                    <li class="{!! \Request::is('cpanel/flats','cpanel/flats/*')? 'mm-active':null !!}">
                        <a href="/cpanel/flats" aria-expanded="false"><span class="hf-nav-item">Квартиры</span></a>
                    </li>
                    <li class="{!! \Request::is('cpanel/owner','cpanel/owner/*')? 'mm-active':null !!}">
                        <a href="/cpanel/owner" aria-expanded="false"><span class="hf-nav-item">Владельцы</span></a>
                    </li>

                </ul>
            </li>
            <li class="parent {!! \Request::is('cpanel/receipt','cpanel/receipt/*')? 'mm-active':null !!}">
                <a href="/cpanel/receipt" aria-expanded="false"><i class="fas fa-file-invoice" ></i> <span>Квитанции</span></a>
            </li>
            <li class="parent {!! \Request::is('cpanel/tarif','cpanel/tarif/*','cpanel/bank','cpanel/bank/*')?'mm-active':null !!}" >
                <a href="#" aria-expanded="false"><span class="fa arrow"></span><i class="fa fa-cogs"></i><span>Настройки</span></a>
                <ul>
                    <li>
                        <a href="/cpanel/tarif" aria-expanded="false"><span class="hf-nav-item"><i class="fa fa-dollar-sign"></i>Тариф</span></a>
                    </li>
                    <li>
                        <a href="/cpanel/bank" aria-expanded="false"><i class="fa fa-dollar-sign" ></i> <span>Банки</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>