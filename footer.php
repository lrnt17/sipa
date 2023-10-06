    <!-- footer -->
    <style>
        a{
            text-decoration:none;
            color:#383838;
        }
        @media (min-width: 768px) {
            .text-center{
                text-align: left !important;
            }
        }
    </style>
    <footer>
        <div class="container p-3 rounded-top-4" style="background:#D2E0F8;">
        <div class="my-4"><pre> </pre></div>
            <div class="row mb-4 ps-3">

                <div class="col-12 col-sm-auto mx-auto text-center">
                    <img class="rounded-circle mb-3" src="logo-colored.png" alt="SiPa" width="55" height="55" >    
                </div>

                <div class="col-12 col-md-auto mx-auto text-md-left text-center ">
                    <div class="row my-2">
                        <a class="js-link" href="home_1_with_user.php"><span translate="no" style="font-weight:normal;">Home</span></a>
                    </div>
                    <div class="row my-2">
                        <a class="js-link" href="faqs.php">FAQs</a>
                    </div>
                    <div class="row my-2">
                        <a class="js-link" href="right_for_me_1.php">Right for me</a>
                    </div>
                    <div class="row my-2">
                        <a class="js-link" href="gmap.php">Health care provider</a>
                    </div>
                </div>
                <div class="col-12 col-md-auto mx-auto text-center">
                     <div class="row my-2">
                        <a class="js-link" href="community-videos.php">Videos</a>
                    </div>
                    <div class="row my-2">
                        <a class="js-link" href="period_calcu.php"><span translate="no" style="font-weight:normal;">Period</span>  Calculator</a>
                    </div>
                    <div class="row my-2">
                        <a class="js-link" href="community-topics.php">Community Forum</a>
                    </div>
                    <div class="row my-2">
                        <a class="js-link" href="about-std.php">About STDs</a>
                    </div>
                </div>
                <div class="col-12 col-md-auto mx-auto text-center">
                    <div class="row my-2">
                        <p>Our Partner</p>
                    </div>
                    <div class="row">
                        <a href="">
                            <img class="rounded-circle mb-3" src="rhu_logo.png" alt="RHU" width="60" height="60" > 
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-auto mx-auto text-center">
                    <div class="row">
                        <h6 class="my-2">+63 912 345 6789</h6>
                    </div>
                    
                    <div class="row my-2" id="references-div">
                        <a href="list-of-rrls.php" style="font-weight:400;"><i class="fa-solid fa-rectangle-list"></i> References</a>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center justify-content-md-end me-4">
                <div class="col-auto">
                    <span>
                    <div class="translate" id="google_translate_element"></div>

                        <script type="text/javascript">
                            function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'en,tl',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                autoDisplay: false,
                                multilanguagePage: true
                            }, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </span>
                </div>
                <div class="col-auto">
                    <button id="myBtn2" style="
                        background: transparent;
                        color: black;
                        border: none;
                    ">
                        Privacy Policy
                    </button>
                </div>
                <div class="col-auto">
                    <button id="myBtn3" style="
                        background: transparent;
                        color: black;
                        border: none;
                    ">
                        Terms of Use
                    </button>
                </div>
            </div>
        </div>
    </footer>
    

    <?php include('privacy-policy.php') ?>
    <?php include('terms-and-conditions.php') ?>