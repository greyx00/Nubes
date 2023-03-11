<?php

function paintings($name, $price, $img, $size, $technique)
{

    $element = "
            <div class=\"component\">
                <form action=\"shop.php\" method=\"post\">
                    <div class=\"container\">
                        <div class=\"shop-box\">
                            <div class = \"group\">
                                <a href='painting.php?name=" . $name . "' class=\"view\" target=\"_self\"><img src=\"../images/$img\" alt=\"Immagine articolo\" class=\"img-fluid card-img-top\" width=150px></a>
                            </div>
                            <div class=\"card-body\">
                                <h5 class=\"card-title\">$name</h5>
                                <h5><span class=\"price\">€$price</span></h5>
                                <input type='hidden' name='name' value='$name'>
                                <input type='hidden' name='quantity' value='1'>
                                <h5><span class=\"price\">$size</span></h5>
                                <h5><span class=\"price\">$technique</span></h5>
                                <button type=\"submit\" class=\"btt\" name=\"buy\" id=\"buy\">Aggiungi al Carrello <i class=\"fas fa-shopping-cart\"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            ";
    echo $element;
}

function cartPaints($img, $name, $price)
{
    $element = "
        <form action=\"cart.php?action=remove&name=$name\" method=\"post\" class=\"cart-items\">
            <div class=\"border-rounded\">
                <div class=\"row\">
                    <div class=\"img\">
                    <a href='product.php?name=" . $name . "' class=\"view\" target=\"_self\"><img src=\"../images/$img\" alt=\"Immagine articolo\" class=\"img-fluid card-img-top\" width=150px></a>
                    </div>
                    <div class=\"productname\">
                        <h5 class=\"name\" id=\"name\">$name</h5>
                        <h5 class=\"price\" id=\"price\">€$price</h5>
                    </div>
                    <button type=\"submit\" class=\"remove\" name=\"remove\" id=\"remove\">Rimuovi</button>
                </div>
            </div>
        </form>
        ";
    echo  $element;
}
