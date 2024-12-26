<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tunivers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/templatestyle.css">
    <script type="text/javascript" src="assets/js/templatej.js"></script>
    <script type="text/javascript" src="assets/js/templateanimations.js"></script>
    <style>
        .textContent {
            background-color: black; /* Black background for text box */
            color: white; /* White text color */
            padding: 20px; /* Padding inside the text box */
            border-radius: 10px; /* Rounded corners */
            max-width: 500px; /* Limit the width of the text content */
            margin: auto;
        }

        .textInner h4 {
            font-size: 24px; /* Increase heading size */
            margin-bottom: 10px;
        }

        .textInner p {
            font-size: 16px; /* Adjust paragraph text size */
            margin-bottom: 10px;
        }

        .iframeContainer iframe {
            margin-left: -600px; /* Move iframe slightly to the left */
        }
    </style>
</head>
<body class="mainIndex">
    
<!--navbar-->   
<div id="container">
    <div id="header">
        <ul class="navButtons">
            <li class="whatsnew" data-linkto="whatsnew">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="138.75px" height="33px" viewBox="236 380.25 138.75 33" enable-background="new 236 380.25 138.75 33" xml:space="preserve"><path fill="#ffffff" d="M263 413.25h111.75l-27-33H236L263 413.25z"/></svg>
                <div class="tabImg launcherSprites-whatsNew"></div>
                <p class="whatsnewtitle">Explore</p>
            </li>
            <li class="primeaccess" data-linkto="primeaccess">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="138.75px" height="33px" viewBox="236 380.25 138.75 33" enable-background="new 236 380.25 138.75 33" xml:space="preserve"><path fill="#ffffff" d="M263 413.25h111.75l-27-33H236L263 413.25z"/></svg>
                <div class="tabImg launcherSprites-primeAccess"></div>
                <p class="patitle">Travel Booking</p>
            </li>
            <li class="buildnotes" data-linkto="buildnotes">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="138.75px" height="33px" viewBox="236 380.25 138.75 33" enable-background="new 236 380.25 138.75 33" xml:space="preserve"><path fill="#ffffff" d="M263 413.25h111.75l-27-33H236L263 413.25z"/></svg>
                <div class="tabImg launcherSprites-buildNotes"></div>
                <?php if ($isLoggedIn): ?>
                    <p class="buildnotestitle"><a href="View/FrontOffice/auth/myaccount.php">My Account</a></p>
                <?php else: ?>
                    <p class="buildnotestitle"><a href="View/FrontOffice/auth/register.php">Sign Up</a></p>
                <?php endif; ?>
            </li>
        </ul>
        <div class="btnCtn">
            <div class="logo"></div>
        </div>
    </div>

    <section id="firstLoad">
        <!-- background video loop -->
        <video id="bgVideo" src="assets/webm/Background.mp4" autoplay loop muted></video>

        <div class="titleBlock">
            <!-- static logo -->
            <!-- <img id="logoImg" src="./images/LauncherLogo_PC_white.png"/> -->
            <img id="logoImg" src="assets/images/LauncherLogo_PC_Koumei.png"/>

            <!-- animated logo -->
            <!-- <video id="logoVideo" src="./webm/Logo.webm" autoplay loop muted></video> -->

            <!-- update tite, translated by app -->
            <p id="logoText">Preserve the Past, Empower the Future</p>
        </div>
    </section>
    <style>#buildnotes iframe {
    position: relative;
    top: 50px;   /* Moves the iframe 20px down */
    left: 20px;  /* Moves the iframe 50px to the right */
    
    }
</style>
<!-- Dynamic Content Based on Login State -->
<?php if ($isLoggedIn): ?>
    <!-- Content for Logged-In Users -->
    <section id="buildnotes">
        <div class="content">
            <div class="iframeContainer">
                <iframe 
                    src="View/FrontOffice/auth/myaccount.php" 
                    frameborder="0" 
                    height="570px" 
                    width="1040px" 
                    id="UserIframe">
                </iframe>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Content for Guests -->
    <section id="buildnotes">
        <div class="content">
            <div class="iframeContainer">
                <iframe 
                    src="View/FrontOffice/auth/register.php" 
                    frameborder="0" 
                    height="570px" 
                    width="1040px" 
                    id="UserIframe">
                </iframe>
            </div>
        </div>
    </section>
<?php endif; ?>
</div>

<!-- Fullscreen Overlay (If Needed) -->
<div id="iframeOverlay" style="display: none;">
    <button id="closeOverlayBtn" onclick="closeOverlay()">Close</button>
    <iframe id="fullscreenIframe" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
</div>

</body>
</html>



    <section id="whatsnew">
        <div class="border"></div>

        <div class="content">
            <div id="whatsnewSlides" class="totalSlides4">
                <div class="whatsnewslide slide1 init" data-slideNum="1">
                    <div class="slideImage"><div class="slideImageInner"></div></div>
                    
                    <div class="slideContent">
                        <div class="contentWrapper">
                            
                    
                            <!-- Iframe -->
                            <div class="iframeContainer">
                                <iframe src="view/frontoffice/historical/historical_timeline.html" frameborder="0" height="330px" width="470px" id="historyIframe"></iframe>
                                
                            </div>
                            <!-- Text content on the left -->
                            <div class="textContent">
                                <div class="textPanel"></div>
                    
                                <div class="textInner">
                                    <h4 class="patitle">History Timeline</h4>
                    
                                    <p class="pa1">
                                        Explore key milestones in Tunisia’s history that have influenced not only the region but the world. 
                                    </p>
                    
                                    <p class="pa2">
                                        Dive deeper into the fascinating journey that has made Tunisia the vibrant nation it is today!
                                    </p>
                                    <span>
                                        <br>
                                    </span>
                                    <div class="whatsnewbuttoncontainer">
                                        <a id="EmberHeirloom" class="whatsnewbutton" onclick="openOverlay()">
                                            <span class="buyNow">Explore</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="whatsnewslide slide2 init" data-slideNum="2">
                    <div class="bordermini"></div>
                    <div class="slideImage"><div class="slideImageInner"></div></div>
                    <div class="slideContent">
                        <div class="contentWrapper">
                            
                    
                            <!-- Iframe -->
                            <div class="iframeContainer">
                                <iframe src="view/frontoffice/monument/monument.html" frameborder="0" height="330px" width="500px" id="historyIframe"></iframe>
                                
                            </div>
                            <!-- Text content on the left -->
                            <div class="textContent">
                                <div class="textPanel"></div>
                    
                                <div class="textInner">
                                    <h4 class="patitle">Monuments</h4>
                    
                                    <p class="pa1">
                                        Embark on a journey through Tunisia's breathtaking monuments, where centuries of history, art, and architecture come alive.  
                                    </p>
                                    <br>
                                    <p class="pa2">
                                        Start exploring and let each monument reveal the essence of Tunisia’s rich past and vibrant present!
                                    </p>
                                    <span>
                                        <br>
                                    </span>
                                    <div class="whatsnewbuttoncontainer">
                                        <a id="EmberHeirloom" class="whatsnewbutton" onclick="openOverlay()">
                                            <span class="buyNow">Discover</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="whatsnewslide slide3 init" data-slideNum="3">
                    <div class="bordermini"></div>
                    <div class="slideImage"><div class="slideImageInner"></div></div>
                    <div class="slideContent">
                        <div class="contentWrapper">
                            
                             <!-- Text content on the left -->
                             <div class="textContent">
                                <div class="textPanel"></div>
                    
                                <div class="textInner">
                                    <h4 class="patitle">Museums</h4>
                    
                                    <p class="pa1">
                                        Step into the captivating world of Tunisia’s museums, where art, history, and culture converge to reveal the essence of this remarkable country.  
                                    </p>
                                    <br>
                                    <p class="pa2">
                                        Begin your journey through Tunisia’s museums and immerse yourself in the stories that shaped a nation!
                                    </p>
                                    <span>
                                        <br>
                                    </span>
                                    <div class="whatsnewbuttoncontainer">
                                        <a id="EmberHeirloom" class="whatsnewbutton" onclick="openOverlay()">
                                            <span class="buyNow">Virtual tour</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Iframe -->
                            <div class="iframeContainer">
                                <iframe src="view/frontoffice/museum/index.php" frameborder="0" height="330px" width="470px" id="historyIframe"></iframe>
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="whatsnewslide slide4 init" data-slideNum="4">
                    <div class="bordermini"></div>
                    <div class="slideImage"><div class="slideImageInner"></div></div>
                    <div class="slideContent">
                        <div class="contentWrapper">
                            
                             <!-- Text content on the left -->
                             <div class="textContent">
                                <div class="textPanel"></div>
                    
                                <div class="textInner">
                                    <h4 class="patitle">Store</h4>
                    
                                    <p class="pa1">
                                        Whether you’re looking for authentic crafts or contemporary designs, each item tells its own story of culture and craftsmanship.  
                                    </p>
                                    <br>
                                    <p class="pa2">
                                        Begin your shopping journey and bring a piece of Tunisia home!
                                    </p>
                                    <span>
                                        <br>
                                    </span>
                                    <div class="whatsnewbuttoncontainer">
                                        <a id="EmberHeirloom" class="whatsnewbutton" onclick="openOverlay()">
                                            <span class="buyNow">Shop</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Iframe -->
                            <div class="iframeContainer">
                                <iframe src="view/frontoffice/shop/index.php" frameborder="0" height="330px" width="470px" id="historyIframe"></iframe>
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="primeaccess">
    <div class="border"></div>
    <div class="content">
        <div class="background"></div> <!-- Background remains -->
        <div class="contentWrapper">
            <!-- Iframe Container -->
            <div class="iframeContainer">
                <iframe src="View/FrontOffice/Booking/index.php" frameborder="0" height="330px" width="470px" id="primeAccessIframe"></iframe>
            </div>

            <!-- Text Content -->
            <div class="textContent">
                <div class="textPanel"></div>

                <div class="textInner">
                    <h4 class="patitle">Travel</h4>

                    <p class="pa1">
                        Embark on a journey through the heart of Tunisia's rich cultural heritage.<br>From ancient ruins to vibrant markets, our travel booking service connects you to experiences that celebrate the past while embracing the present.
                    </p>

                    <p class="pa2">
                        Preserve the legacy, live the culture, and create unforgettable memories in Tunisia. Start your adventure today!.
                    </p>
                    <a id="paLink" class="whatsnewbutton1" onclick="openOverlayWithContent('View/FrontOffice/Booking/index.php')">
                        <div id="buyPA">
                            <span>Book Your Trip</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
    
    
    <a id="ExploreMorePrimeAccess" class="whatsnewbutton1" onclick="openOverlayWithContent('view/frontoffice/Booking/Project/FrontOffice/index.html')">
        <span class="buyNow1">Book Your Trip</span>
    </a>
    
    

    <div id="firstLoadHotspot" class="fourSlides"></div>


</div>

<!-- Fullscreen overlay container -->
<div id="iframeOverlay" style="display: none;">
    <button id="closeOverlayBtn" id="historyButton" class="history-theme-btn" onclick="closeOverlay()">Close</button>
    <iframe id="fullscreenIframe" src="page1.html" frameborder="0" style="width: 100%; height: 100%;"></iframe>
  </div>
</body>
</html>