<?php defined('APP') or die('direct script access denied!'); ?>

<div class="links">
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
    <button id="myBtn2" style="
        background: transparent;
        color: white;
        border: none;
    ">
        Privacy Policy
    </button>
    <button id="myBtn3" style="
        background: transparent;
        color: white;
        border: none;
    ">
        Terms of Use
    </button>

    <?php include('privacy-policy.php') ?>
    <?php include('terms-and-conditions.php') ?>
</div>