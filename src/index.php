<?php
/**
 * Created by IntelliJ IDEA.
 * User: toml
 * Date: 6/9/17
 * Time: 4:16 PM
 */

require 'config.php';
?>

<html>
<head>
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

</head>
<body>

<form method="POST" action="" id="adyen-encrypted-form">
    <input value="4111111111111111" type="text" size="20" autocomplete="off" id="number" data-encrypted-name="number" />
    <input value="mr test" type="text" size="20" autocomplete="off" id="holderName" data-encrypted-name="holderName" />
    <input value="08" type="text" size="2" maxlength="2" autocomplete="off" id="expiryMonth" data-encrypted-name="expiryMonth" />
    <input value="2018" type="text" size="4" maxlength="4" autocomplete="off" id="expiryYear" data-encrypted-name="expiryYear" />
    <input value="737" type="text" size="4" maxlength="4" autocomplete="off" id="cvc" data-encrypted-name="cvc" />
    <input type="submit" value="Pay" />
</form>

<textarea id="enc"></textarea>


<script type="text/javascript" src="adyen.encrypt.nodom.min.js"></script>
<script type="text/javascript">
var key =  "<?php echo $key ?>"
</script>
<script type="text/javascript">
    (function() {
        $('#adyen-encrypted-form').on('submit', function(e) {
            e.preventDefault();
            var options = {}; // See adyen.encrypt.nodom.html for details

            var cseInstance = adyen.encrypt.createEncryption(key, options);

            encryptMyData();

            function encryptMyData() {

                var postData = {};

                var today = new Date();

                var cardData = {
                    number : $('#number').val(),
                    cvc : $('#cvc').val(),
                    holderName : $('#holderName').val(),
                    expiryMonth : $('#expiryMonth').val(),
                    expiryYear : $('#expiryYear').val(),
                    generationtime : today.toISOString()
                };

                postData['adyen-encrypted-data'] = cseInstance.encrypt(cardData);

                console.log(postData)

                $('#enc').text(postData['adyen-encrypted-data']);

                // AJAX call or different handling of the post data.
            }
        })

    })();
</script>

</body>
</html>