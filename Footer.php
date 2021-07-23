

<!-- Site footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-4">

                <!-- Content -->
                <h6 class="title font-weight-bold">PlanetShop</h6>
                <p>This store is your new portal for online shopping in an easy and simple way.
We provide you with various high quality products to choose the best from them at a competitive price that you will not find anywhere else.</p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2">

                <!-- Links -->
                <h6 class="font-weight-bold">Shop</h6>
                <hr class="deep-purple accent-2 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">


                <?php

                    $sql = 'select c1.idC,c1.CTname from categorie c1 where idFC is null and c1.CTname <> "Sliders" limit 4';
					$run = mysqli_query($cn,$sql);

                    while($raw=mysqli_fetch_array($run)){
                        echo '<p><a href="shop.php?categorie='.$raw[1].'">'.$raw[1].'</a></p>';
                    }

                ?>
                                

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-3 col-xl-3">

            <!-- Links -->
                <h6 class="font-weight-bold">About Store</h6>
                <hr class="deep-purple accent-2 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><a href="about.php?reg=about">About</a></p>
                <p><a href="about.php?reg=pm">Payment Methods</a></p>
                <p><a href="about.php?reg=sh">Shipping and handling</a></p>
                <p><a href="about.php?reg=help">Help</a></p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mb-md-0">

                <!-- Links -->
                <h6 class="font-weight-bold">Contact</h6>
                <hr class="deep-purple accent-2 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><i class="fas fa-home mr-3"></i> Souk Mellilia N 183 Oujda 60000</p>
                <p><i class="fas fa-envelope mr-3"></i> Planetshop2020@gmail.com</p>
                <p><i class="fas fa-phone mr-3"></i> +212 672 831 364</p>
                <p><i class="fab fa-whatsapp mr-3"></i> +212 672 831 364</p>

            </div>
            <!-- Grid column -->
        </div>

        <hr>

    </div>
    
    <div class="container social">

        <!-- Grid row-->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-8 col-lg-7 mx-auto">
                <h6 class="">Get connected with us on social networks!</h6>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-5 text-center text-md-right mx-auto">
                <!-- whatsapp -->
                <a href="https://api.whatsapp.com/send?phone=+212672831364" target="_blank"><i class="fab fa-whatsapp white-text mr-4"> </i></a>
                <!-- Facebook -->
                <a href="https://www.facebook.com/planetshoponline/" target="_blank"><i class="fab fa-facebook-f white-text mr-4"> </i></a>
                <!-- Twitter -->
                <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter white-text mr-4"> </i> </a>
                <!--Linkedin -->
                <a href="https://www.youtube.com/channel/UCZOPS6vFOSfeiC9DrY325tg" target="_blank"><i class="fab fa-youtube white-text mr-4"> </i></a>
                <!--Instagram-->
                <a href="https://www.instagram.com/abdelhak.techn/" target="_blank"><i class="fab fa-instagram white-text"> </i></a>
            </div>
        <!-- Grid column -->
        </div>
    <!-- Grid row-->
    </div>
    
    
    <div class="tt-copy">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="tt-copy-left">Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved.</div>
                </div>
                <div class="col-sm-6">
                    <div class="tt-copy-right">
                    Created by: <span><a href="https://walidjennani.000webhostapp.com/#portfolio" target="_blank">walid jennani</a></span> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

</footer>
