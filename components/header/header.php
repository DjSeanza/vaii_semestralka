<header class="header flex-row p-2">
    <div class="header-left">
        <button class="button">
            <img src="<?php echo ROOT_PATH; ?>img/hamburger-menu.svg" alt="Hamburger menu">
        </button>
        <div class="logo">
            <img src="<?php echo ROOT_PATH; ?>img/logo.svg" alt="Logo">
        </div>
    </div>
    <div class="header-mid">
        <form action="">
            <div>
                <input type="text" placeholder="Search" class="p-2">
                <button class="button pl-4 pr-4">
                    <img src="<?php echo ROOT_PATH; ?>img/search-icon.svg" alt="">
                </button>
            </div>
        </form>
    </div>
    <div class="header-right">
        <button class="button" onclick='location.href="<?php echo ROOT_PATH; ?>pages/login/login.php"'>

        </button>
    </div>
</header>