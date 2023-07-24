<?php 
    include("connect.php"); 
    require('functions.php');
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPa | Right for Me</title>
    <style>
   .skiptranslate iframe  {
    visibility: hidden !important;
    } 
    body{
    top:0!important;
    }

    input:disabled + label {
  color: lightgray;
    }
   </style>
   

</head>
<body>
    <!-- navigation bar with logo -->
    <div class="navigation-bar" id="navigation-container">
        <img src="#">
        <ul>
            <li><a href="home_1_with_user.php">Home</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li>
                <div class="dropdown">
                    <button class="dropbtn">Dropdown<i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </div>
            </li>
            <li><a href="#">Sign in</a></li>
            <div class="profile_pic">
                <a href="profile.php" id="avatar_name" href="#name">
                    <img id="avatar" src="<?php //echo $_SESSION["image"]; ?>" alt="avatar">
                </a>
            </div>
        </ul>
    </div>

    <div class="title-quiz-result" id="title-quiz-result">
        <h1>Contraception Method Result</h1>
    </div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recommendations from the POST data
    $recommendationsJson = $_POST['recommendations'];
  
    // Convert the JSON string back to a PHP array
    $recommendations = json_decode($recommendationsJson, true);

     // Start a flex container to display items horizontally
     //try lang to sa css para makita yung pagdisplay ng pahorizontal..pwede mo pa iedit hehe 
  echo '<div style="display: flex; flex-wrap: wrap;">';
  
    // Now, you can use the $recommendations array as needed
    // For example, you can loop through the recommended contraceptive methods:
    // Loop through the recommendations and fetch the corresponding contraceptive method information
  foreach ($recommendations as $method) {

    $methodSafe = mysqli_real_escape_string($conn, $method);

    // Remove spaces from the method name and convert to lowercase
    $methodSafeFormatted = strtolower(str_replace(' ', '', $methodSafe));

    // Query the database to fetch the contraceptive method information
    $query = "SELECT * FROM birth_controls WHERE LOWER(REPLACE(birth_control_name, ' ', '')) = '$methodSafeFormatted'";
    $result = mysqli_query($conn, $query);

    // Check if the method exists in the birth_controls table
    if (mysqli_num_rows($result) > 0) {

        // Fetch all rows corresponding to the contraceptive method (in case there are multiple matches)
      while ($row = mysqli_fetch_assoc($result)) {
        // Display the contraceptive method information

            //paalis nalang tong css na i2 if gagawan mo na pu ng css
        echo '<div style="flex: 0 0 300px; margin: 10px; border: 1px solid #ccc; padding: 10px;">';
        echo "<h2>{$row['birth_control_name']}</h2>";
        echo "<img src='{$row['birth_control_img']}' alt='{$row['birth_control_name']}' style='width: 100px; height: 100px;'><br>";
        echo "<p>{$row['birth_control_desc']}</p>";
        echo "</div>";
      }
    } else {
      // Handle the case where the method name is not found in the birth_controls table
      echo "<p>Contraceptive method '$method' not found.</p>";
    }
  }echo "</div>";
};

?>

    <div>
        <form id= "back_btn" action="right_for_me_quiz.php" method="post">
            <input type="submit" value="Back" name="submit_back">
        </form>
    </div>
    
    <div>
        <p>Contraceptive method reminder via<p>
            <h3>SMS</h3>
    </div>

    <div>
        <p>Would you like to receive SMS reminders to take your selected contraceptive method as recommended?<p>
        <form id= "sms_reminder_btn" action="#" method="post">
        <input type="submit" value="Remind Me!" name="submit_remind">
        </form>
    </div>

    

<!-- footer -->


<footer>
        <div>
            
            <img src="" alt="">

            <a href="#">Home</a>
            <a href="#">FAQs</a>
            <a href="#">Services</a>
            <a href="#">Contraceptive Method</a>
            <a href="#">Videos</a>
            <a href="#">Period Calculator</a>
            <a href="#">Community Forum</a>
            <a href="#">About STDs</a>

            <p>Our Partner</p>
            <img src="" alt="">

            <h3>+63 912 345 6789</h3>
            <!-- icon -->
            <!-- icon -->
        </div>
        
        <div>
            <!-- Translation Code here -->
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


            <!-- Translation Code End here -->
            <a href="">Privacy Policy</a>
            <a href="">Terms of Use</a>
        </div>
</footer>

</body>

<script>
          
</script>

</html>

