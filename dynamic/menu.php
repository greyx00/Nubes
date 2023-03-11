<header>
    <!--
            <a class="image" href=../homepage/homepage.php><img class="image" src="../images/logo.jpg" alt="logo" height="65"></a>
            <a class="image" href=../homepage/homepage.php><img class="icon-image" src="../images/icona.jpg" alt="logo" height="65"></a>
            -->
    <nav class="nav">
        <a class="nav-image" href=../home/home.php>
            <picture>
                <source media="(min-width: 650px)" srcset="../images/logo.jpg" height="65">
                <source media="(min-width: 466px)" srcset="../images/logo.jpg" height="65">
                <img src="../images/icona.jpg" alt="Logo" height="65">
            </picture>
        </a>
        <ul class="nav-menu" id="menu_header">
            <li class="nav-item"><a href="../art/art.php" class="nav-link" target="_self">ART</a></li>
            <li class="nav-item"><a href="../shop/shop.php" class="nav-link" target="_self">SHOP</a></li>

            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] == 'admin') {
                    print("<li class=\"nav-item\"><a href=\"../admin/add_paint.php\" class=\"nav-link\" id=\"login\" target=\"_self\">AGGIUNGI DIPINTO</a></li>");
                    print("<li class=\"nav-item\"><a href=\"../admin/allusers.php\" class=\"nav-link\" id=\"login\" target=\"_self\">LISTA UTENTI</a></li>");
                }
            }
            if (!isset($_SESSION['user']))
                print("<li class=\"nav-item\"><a href=\"../login/login.php\" class=\"nav-link\" id=\"login\" target=\"_self\">LOGIN</a></li>");

            elseif (isset($_SESSION['user'])) {
                print("<li class=\"nav-item\"><a href=\"../profile/show_profile.php\" class=\"nav-link\" id=\"profile\" target=\"_self\">PROFILO</a></li></span>");
                print("<li class=\"nav-item\"><a href=\"../logout/logout.php\" class=\"nav-link\" id=\"logout\" target=\"_self\">LOGOUT</a></li></span>");
                print("<li class=\"nav-item\"><a href=\"../shop/cart.php\" class=\"nav-link\"> <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"bi bi-cart2\" viewBox=\"0 0 16 16\"><path d=\"M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z\"/>
                            </svg></a></li>");
            }
            ?>
        </ul>
        <div class="nav-bar">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </nav>
</header>
<script>
    const navbar = document.querySelector(".nav-bar");
    const navmenu = document.querySelector(".nav-menu");

    navbar.addEventListener("click", () => {
        navbar.classList.toggle("active");
        navmenu.classList.toggle("active");
    })

    document.querySelector(".nav-link").forEach(m => n.addEventListener("click", () => {
        navbar.classList.remove("active");
        navmenu.classList.remove("active");
    }))
</script>