<?php

    require("connect.php");
    require('functions.php');

    /*if(!logged_in()){
		header("Location: home_1_with_user.php");
		die;
	}*/

        // pang kuha ng question and answer sa db
        $faqData = array();
        $query = "SELECT * FROM faqs";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $faqData[] = array(
                    'question' => $row['questions'],
                    'answer' => $row['answers']
                );
            }
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    
    <title>SiPa | FAQs</title>
    <style>
    .skiptranslate iframe  {
      visibility: hidden !important;
      } 
      body{
      top:0!important;
      }
      .vl {
        width: 10px;
        background-color: #1F6CB5;
        border-radius: 99px;
        height: 50px;
        display: -webkit-inline-box;
      }

      

      .faq-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 2rem auto; 
      }

      @keyframes fadeIn {
          from {
              opacity: 0;
          }
          to {
              opacity: 1;
          }
      }

      @keyframes slideDownFadeIn {
          from {
              max-height: 0;
              opacity: 0;
          }
          to {
              max-height: 500px;
              opacity: 1;
          }
      }

      @keyframes slideUpFadeOut {
          from {
              max-height: 500px !important;
              opacity: 1 !important;
          }
          to {
              max-height: 0 !important;
              opacity: 0 !important;
          }
      }

      .faq-item.slide-up .item-answer {
          animation: slideUpFadeOut 1s ease !important; 
      }

      .faq-item {
          background-color: white;
          border-radius: 10px; 
          overflow: hidden; 
          transition: max-height 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease; 
          box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
          animation: fadeIn 2s ease;
          display: none; /* Start with display none */
      }

      .item-question {
          background: #fff;
          font-size: 1rem;
          padding: 1rem;
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
      .question-text {
          display: inline-block;
      }

      .arrows-container {
          margin: 0.4rem;
          cursor: pointer;
      }

      .item-answer {
          display: none;
          color: whitesmoke;
          padding: 2rem;
          max-height: 0; 
          overflow: hidden; 
          transition: max-height 0.3s ease, background-color 0.3s ease; 
          border-top: 1px solid #AC471A;
      }

      .close {
          display: none;
      }

      .show-answer .item-answer {
          display: block;
          background: #fff;
          color: black;
          cursor:pointer;
          max-height: 500px; 
          padding: 2rem;
          box-shadow: none;
          background-color: #F2C1A7; 
          border-top: 1px solid #AC471A;
          animation: slideDownFadeIn 2s ease;
      }

      .show-answer .item-question {
      background-color: #F2C1A7; 
      }

      .show-answer .close {
          display: inline;
      }

      .show-answer .expand {
          display: none;
      }
      

      mark {
        background-color: #D2E0F8 !important; 
        color: inherit;
      }
    
      .form .fa-solid{
        position: absolute;
        top:20px;
        left: 20px;
        color: #9ca3af;
        }

    .form-input:focus{
        box-shadow: none !important;
        border:none;
    }
    /* Default style for anchor tags */
    .nav-link {
        font-weight: normal; /* Use the default font weight */
    }

    /* Style for active anchor tags (text will be bold) */
    .nav-link.active {
        font-weight: bold;
    }
      

    
   </style>
</head>

<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

  <div>
      <div class="container rounded-5" style="background: #D2E0F8;">
          <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
          
              <div class="col-auto"><p style="font-size: 3.5rem;">I have a</p></div>
              <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Question</p></div>
          </div>
      </div>

      <div class="container">

              <div class="row height d-flex justify-content-center align-items-center">

                <div class="col-md-6">

                    <div class="form" style="position: relative; top: -30px;">
                      <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" id="search"  class="js-search-input form-control form-input" placeholder="Search" style="height: 55px;
                          text-indent: 33px;
                          border-radius: 15px;">
                    </div>
                  
                </div>
              </div>
      </div>
  </div>

<div class="container">

        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl"></div>
            </div>
        
            <div class="col-auto">
                <h3 style="font-weight: 400;">Frequently <b>Asked Questions</b></h3>
            </div>
        </div>

        <div class="faq-container" id="FAQs-container">
            <!-- FAQS here -->
        </div>

        <?php include('forum-carousel.php') ?>

</div>
<br><br>
    <!-- footer -->
    <?php include('footer.php') ?>
    
<script>
        //pang lagay ng data sa FAQs-container from faqData(na finetch from db)
        const faqData = <?php echo json_encode($faqData); ?>;
        const faqsContainer = document.getElementById('FAQs-container');
        
              faqData.map((item) => {
                  let faqItem = document.createElement('article');
                  faqItem.classList.add('faq-item','container','my-2');
                  faqItem.style.padding ="0";
              
                  let markup = `
                      <div class="item-question"> 
                          <span class="question-text">${item.question}</span>
                          <span class="arrows-container">
                              <span class="expand"><i class="fa-solid fa-chevron-down" style="font-size:20px;"></i></span>
                              <span class="close"><i class="fa-solid fa-xmark" style="font-size:20px;"></i></span>
                          </span>
                      </div>
                      <div class="item-answer">
                          <span>${item.answer}</span>
                      </div>
                  `;
                  
                  faqItem.innerHTML = markup;
                  faqsContainer.append(faqItem);

                   // Add a setTimeout to trigger the fade-in animation
                    setTimeout(() => {
                        faqItem.style.display = 'block';
                    }, 100); // You can adjust the delay as needed
          });
        


        //add ng function para sa arrow pag niclick yun, lalabas ang kasagutan sa katanungan *elyen*
        const toggleButtons = document.querySelectorAll('.arrows-container');
          toggleButtons.forEach(button => {
              button.addEventListener('click', function(e) {
                  const faqItem = e.currentTarget.parentElement.parentElement;
                  const itemAnswer = faqItem.querySelector('.item-answer');

                  if (faqItem.classList.contains('show-answer')) {
                      // If showing answer, toggle the show-answer class and set slideUpFadeOut animation
                      faqItem.classList.remove('show-answer');
                      faqItem.classList.add('slide-up'); // Add the slide-up class
                      itemAnswer.style.animation = 'slideUpFadeOut 1s ease'; // Adjust the duration as needed
                  } else {
                      // If hiding answer, toggle the show-answer class and remove slide-up class
                      faqItem.classList.add('show-answer');
                      faqItem.classList.remove('slide-up'); // Remove the slide-up class
                      itemAnswer.style.animation = 'slideDownFadeIn 1s ease'; // Adjust the duration to match CSS
                  }
              });
          });






        //search function pag may nagmatch na word edi maffilter tas may paanimation para maangas
        const searchInput = document.getElementById('search');
        let fadeIntervals = [];

        searchInput.addEventListener('input', function() {
            const searchText = searchInput.value.toLowerCase();
            
            // Clear existing fade intervals
            fadeIntervals.forEach(interval => clearInterval(interval));
            fadeIntervals = [];
            
            // Hide all FAQ items first
            document.querySelectorAll('.faq-item').forEach((faqItem) => {
                faqItem.style.display = 'none';
                faqItem.style.opacity = '0';
            });
            
            const filteredFAQs = faqData.filter((item) => {
                const questionText = item.question.toLowerCase();
                const answerText = item.answer.toLowerCase();
                
                if (searchText) {
                    const questionMatches = questionText.includes(searchText);
                    
                    if (questionMatches) {
                        return true;
                    } else if (answerText.includes(searchText)) {
                        return true;
                    }
                    
                    return false;
                }
                
                return true;
            });

            filteredFAQs.forEach((item, index) => {
                const faqItem = document.querySelectorAll('.faq-item')[index];
                const questionText = item.question.toLowerCase();
                const answerText = item.answer.toLowerCase();
                
                if (searchText) {
                    const questionMatches = questionText.includes(searchText);
                    
                    if (questionMatches) {
                        // Show the FAQ item
                        faqItem.style.display = 'block';
                        
                        // Highlight the matching text in question
                        const highlightedQuestion = item.question.replace(new RegExp(searchText, 'gi'), (match) => `<mark>${match}</mark>`);
                        
                        // Update the HTML with highlighted text in the question
                        faqItem.querySelector('.question-text').innerHTML = highlightedQuestion;
                    } else if (answerText.includes(searchText)) {
                        // Show the FAQ item
                        faqItem.style.display = 'block';
                        
                        // Highlight the matching text in answer
                        const highlightedAnswer = item.answer.replace(new RegExp(searchText, 'gi'), (match) => `<mark>${match}</mark>`);
                        
                        // Update the HTML with highlighted text in the answer
                        faqItem.querySelector('.item-answer span').innerHTML = highlightedAnswer;
                        
                        // Automatically expand the FAQ item if answer matches
                        faqItem.classList.add('show-answer');
                    } else {
                        faqItem.style.display = 'none';
                    }
                } else {
                    // If there is no search text, reset highlighting and show all FAQs
                    faqItem.style.display = 'block';
                    faqItem.querySelector('.question-text').innerHTML = item.question;
                    faqItem.querySelector('.item-answer span').innerHTML = item.answer;
                    
                    // Collapse the FAQ item
                    faqItem.classList.remove('show-answer');
                }
                
                // Gradually adjust opacity with smooth fading effect
                let opacityValue = 0;
                const fadeInInterval = setInterval(() => {
                    opacityValue += 0.05;
                    faqItem.style.opacity = opacityValue;
                    if (opacityValue >= 1) {
                        clearInterval(fadeInInterval);
                    }
                }, 50);
                
                fadeIntervals.push(fadeInInterval);
            });
        });







</script>

</html>
