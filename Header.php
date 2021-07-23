<?php

?>

<header class="header">

<!-- Top Bar -->

<div class="top_bar">
    <div class="container">
        <div class="row">
            <div class="col d-flex flex-row">

                <div class="top_bar_contact_item"><div class="top_bar_icon"><img src="images/phone.png" alt=""></div><a href="tel:+212672831364">+212672831364<a></div>
                <div class="top_bar_contact_item"><div class="top_bar_icon"><img src="images/mail.png" alt=""></div><a href="mailto:Planetshop2020@gmail.com">Planetshop2020@gmail.com</a></div>
                <div class="top_bar_contact_item"><div class="top_bar_icon"></div><a href="https://api.whatsapp.com/send?phone=+212672831364" target="_blank"><i class="fab fa-whatsapp white-text" style="color:#3ADF00;font-size:130%;margin-left:15px"> </i> Whatsapp</a></div>

                <div class="top_bar_content ml-auto">
                    <div class="top_bar_menu">
                        <ul class="standard_dropdown top_bar_dropdown" style="display: none">
                            <li>
                                <a href="#">English<i class="fas fa-chevron-down"></i></a>
                                <ul>
                                    <li><a href="#">Français</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="top_bar_user" style="display: none">
                        <div class="user_icon"><img src="images/user.svg" alt=""></div>
                        <div><a href="#">Register</a></div>
                        <div><a href="#">Sign in</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>		
</div>

<!-- Header Main -->

<div class="header_main">
    <div class="container">
        <div class="row">

            <!-- Logo -->
            <div class="col-lg-3 col-sm-3 col-3 order-1">
                <div class="logo_container">
                    <div class="logo"><a href="index.php">PlanetShop</a></div>
                </div>
            </div>

            <!-- Search -->
            <div class="col-lg-5 col-12 order-lg-2 order-3 text-lg-left text-right">
                <div class="header_search">
                    <div class="header_search_content">
                        <div class="header_search_form_container">
                            <form action="shop.php" method="get" class="header_search_form clearfix">
                                <input type="search" required="required" class="header_search_input" name="search" placeholder="Search for products...">
                                <div class="custom_dropdown">
                                    <div class="custom_dropdown_list">
                                        <span class="custom_dropdown_placeholder clc" name="cat">All Categories</span>
                                        <input class="cat_hidden" type="hidden" name="categorie" value="All Categories"/>
                                        <i class="fas fa-chevron-down"></i>
                                        <ul class="custom_list clc">
                                            
                                            <li><a class="clc" href="#">All Categories</a></li>

                                            <?php

                                            $sql = 'select c1.idC,c1.CTname from categorie c1 where idFC is null and c1.CTname <> "Sliders"';
                                            $run = mysqli_query($cn,$sql);
                                            while($raw=mysqli_fetch_array($run)){
                                                echo '<li><a class="clc" href="shop.php?categorie='.$raw[1].'">'.$raw[1].'</a></li>';
                                            }


                                            ?>
                                            
                                            
                                        </ul>
                                    </div>
                                </div>
                                <button type="submit" class="header_search_button trans_300" value="Submit"><img src="images/search.png" alt=""></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wishlist -->
            <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                    <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                        <div class="wishlist_icon"><img src="images/heart.png" alt=""></div>
                        <div class="wishlist_content">
                            <div class="wishlist_text"><a href="shop.php?Wishlist=show">Wishlist</a></div>
                            <div id="wishlist_count" class="wishlist_count">0</div>
                        </div>
                    </div>

                    <!-- Cart -->
                    <div class="cart">
                        <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                            <div class="cart_icon">
                                <img src="images/cart.png" alt="">
                                <div class="cart_count"><span id  = "countPanier">0</span></div>
                            </div>

                            <div class="cart_content">
                                <div class="cart_text"><a href="cart.php">Cart</a></div>
                                <div class="cart_price"><span id = "cart_price">0</span> DH</div>
                            </div>
                            
                        </div>


                        <div class="infoPanier">
                            <div class="listPruduit">
                                <span></span>
                                <h4>Selected Products :</h4>
                                <div id = "infoPanier">
                                    
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation -->

<nav class="main_nav">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <div class="main_nav_content d-flex flex-row">

                    <!-- Categories Menu -->

                    <div class="cat_menu_container">
                        <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                            <div class="cat_burger"><span></span><span></span><span></span></div>
                            <div class="cat_menu_text">categories</div>
                        </div>

                        <ul class="cat_menu">


                            <?php

                            $sql = 'select c1.idC,c1.CTname,(select count(*) from categorie c2 where idFC = c1.idc ) as "count" from categorie c1 where idFC is null and c1.CTname <> "Sliders"';
                            $run = mysqli_query($cn,$sql);
                            while($raw=mysqli_fetch_array($run)){

                                if($raw[2] == "0"){
                                    echo '<li><a href="shop.php?categorie='.$raw[1].'">'.$raw[1].'<i class="fas fa-chevron-right"></i></a></li>';
                                }else {
                                    echo '<li class="hassubs"><a href="#">'.$raw[1].'<i class="fas fa-chevron-right"></i></a><ul>';

                                    $sqlLigne = 'select idC,CTname from categorie c where idFC = '.$raw[0].'';
                                    $runLigne = mysqli_query($cn,$sqlLigne);
                                    while($rawLigne=mysqli_fetch_array($runLigne)){

                                        echo '<li><a href="shop.php?categorie='.$rawLigne[1].'">'.$rawLigne[1].'<i class="fas fa-chevron-right"></i></a></li>';

                                    }
                                    echo '</ul>';
                                }
                            }


                            ?>


                        </ul>
                    </div>

                    <!-- Main Nav Menu -->

                    <div class="main_nav_menu ml-auto">
                        <ul class="standard_dropdown main_nav_dropdown">
                            <li><a href="index.php">Home<i class="fas fa-chevron-down"></i></a></li>

                            <li><a href="shop.php">Shoping<i class="fas fa-chevron-down"></i></a></li>
                            
                            <li class="hassubs">
                                <a href="">Pages<i class="fas fa-chevron-down"></i></a>
                                <ul>
                                    <li><a href="shop.php">Shop<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="cart.php">Cart<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="shop.php?Wishlist=show">Wishlist<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="about.php?reg=help">Help<i class="fas fa-chevron-down"></i></a></li>
                                </ul>
                            </li>
                            
                            <li><a href="about.php">About Store<i class="fas fa-chevron-down"></i></a></li>
                            <li><a href="contact.php">Contact<i class="fas fa-chevron-down"></i></a></li>
                        </ul>
                    </div>

                    <!-- Menu Trigger -->

                    <div class="menu_trigger_container ml-auto">
                        <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                            <div class="menu_burger">
                                <div class="menu_trigger_text">menu</div>
                                <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Menu -->

<div class="page_menu">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <div class="page_menu_content">
                    
                    <div class="page_menu_search">
                        <form action="shop.php" method="get">
                            <input type="search" name="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
                        </form>
                    </div>
                    <ul class="page_menu_nav">
                        <li class="page_menu_item has-children" style="display: none">
                            <a href="#">Language<i class="fa fa-angle-down"></i></a>
                            <ul class="page_menu_selection">
                                <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                <li><a href="#">Français<i class="fa fa-angle-down"></i></a></li>
                            </ul>
                        </li>



   
                        <li class="page_menu_item"><a href="index.php">Home<i class="fa fa-angle-down"></i></a></li>

                        <li class="page_menu_item"><a href="shop.php">Shoping<i class="fa fa-angle-down"></i></a></li>

                        <li class="page_menu_item has-children">
                            <a href="#">Pages<i class="fa fa-angle-down"></i></a>
                            <ul class="page_menu_selection">
                                <li><a href="shop.php">Shop<i class="fa fa-angle-down"></i></a></li>
                                <li><a href="cart.php">Cart<i class="fa fa-angle-down"></i></a></li>
                                <li><a href="shop.php?Wishlist=show">Wishlist<i class="fa fa-angle-down"></i></a></li>
                                <li><a href="about.php?reg=help">Help<i class="fa fa-angle-down"></i></a></li>
                            </ul>
                        </li>

                        <li class="page_menu_item"><a href="about.php">About Store<i class="fa fa-angle-down"></i></a></li>
                        <li class="page_menu_item"><a href="contact.php">Contact<i class="fa fa-angle-down"></i></a></li>
                        
                    </ul>
                    

                    <div class="menu_contact">
                        <div class="menu_contact_item"><div class="menu_contact_icon"><img src="images/phone_white.png" alt=""></div><a href="tel:+212672831364">+212672831364<a></div>
                        <div class="menu_contact_item"><div class="menu_contact_icon"><img src="images/mail_white.png" alt=""></div><a href="mailto:Planetshop2020@gmail.com" style="margin-right:14px">Planetshop2020@gmail.com</a></div>
                        <div class="menu_contact_item"><div class="menu_contact_icon"></div><a href="https://api.whatsapp.com/send?phone=+212672831364" target="_blank"><i class="fab fa-whatsapp white-text" style="color:#3ADF00;font-size:130%;margin-left:-14px"> </i> Whatsapp</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</header>


