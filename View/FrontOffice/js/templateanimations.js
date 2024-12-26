$(document).ready(function(){
    var prevSlide = 0;
    var gamePadClick = false;
    var idleTimeout;
    var inTransition = false;
    var transitionTimeout;
        

    var startTime = Date.now();
    var elapsedTime = 0;
    var interval = setInterval(function() {
        elapsedTime = Date.now() - startTime;
    }, 100);
    
    

    $('.navButtons .buildnotes,.navButtons .primeaccess,.navButtons .whatsnew').click(function(e){
        if(!inTransition){
            inTransition = true;
            clearTimeout(transitionTimeout);
            transitionTimeout = setTimeout(function(){
                inTransition = false;
            },605);
            $('.navButtons li').removeClass('active');
            $(this).addClass('active');
            var targetDiv = $('#'+$(this).attr('data-linkto'));
            if(!targetDiv.hasClass('active')){
                $('.navButtons .buildnotes,.navButtons .primeaccess,.navButtons .whatsnew').find('.tabImg').removeClass('active');
                $(this).find('.tabImg').addClass('active');
                $('.navButtons .buildnotes,.navButtons .primeaccess,.navButtons .whatsnew').not(this).each(function(){
                    $(this).find('svg').attr('class','');
                    $(this).find('p').removeClass('orange');
                });

                $('section#primeaccess, section#whatsnew, section#buildnotes').each(function(){
                    var that = $(this);
                    if(that.hasClass('active')){
                        that.css('z-index',3);
                        setTimeout(function(){
                            that.removeClass('active');
                            that.hide();
                            if(that.find('video').length){
                                that.find('video')[0].pause();
                            }
                            gamePadClick = false;
                        },605);
                        return false;
                    }
                });
                
                targetDiv.show();
                targetDiv.css('z-index',4);
                targetDiv.addClass('active').removeClass('inactive');
                if(targetDiv.find('video')[0]){
                    targetDiv.find('video')[0].play();
                }

                if(!$('#firstLoadHotspot').is(':visible')){
                    setTimeout(function(){
                        $('#firstLoad').find('video')[0].pause();
                        $('#firstLoadHotspot').fadeIn();
                        gamePadClick = false;
                    },300);
                }

                if($(this).hasClass('whatsnew')){                
                    prevSlide = 0;
                    if($('#whatsnewSlides').hasClass('totalSlides4')){
                        $('#firstLoadHotspot').addClass('fourSlides');
                    }
                } else {
                    setTimeout(function(){
                        $('#whatsnewSlides .whatsnewslide .slideImage').removeClass('anim').show();
                        $('#whatsnewSlides .whatsnewslide,.slideTitle').addClass('init').removeClass('open active0 active1 active2 active3 active4 from0 from1 from2 from3 from4 closed');
                    },605);
                }
                $('#whatsnewSlides .whatsnewslide .behindOverlay').hide();
               
                
            }
        }
    });

    $('#firstLoadHotspot').click(function(e){
        if($(this).is(':visible')){
            // setTimeout(function(){
            //     startIdle();
            // },500);
            $('#firstLoad').removeClass('left').addClass('right');
            $('.navButtons .primeaccess,.navButtons .whatsnew,.navButtons .buildnotes').find('.tabImg').removeClass('active');
            
            $('#firstLoad').find('video')[0].play();
            setTimeout(function(){
                $('#whatsnewSlides .whatsnewslide,#whatsnewSlides .slideTitle').addClass('init').removeClass('open active0 active1 active2 active3 from0 from1 from2 from3 closed');
                $('#whatsnewSlides .whatsnewslide .behindOverlay').hide();
                $('#whatsnewSlides .whatsnewslide .slideImage').removeClass('anim').removeAttr('style');
            },1000);

            $('.navButtons svg').attr('class','');
            $('.navButtons li p').removeClass('orange');

            $('section#primeaccess.active, section#whatsnew.active, section#buildnotes.active').removeClass('active').addClass('inactive').removeAttr('style');
            setTimeout(function(){
                $('section#primeaccess, section#whatsnew, section#buildnotes').removeClass('inactive');
            },1000);
            $(this).fadeOut(100);
            $('.navButtons li').removeClass('active');
        }
    });
    
    $('#whatsnewSlides .whatsnewslide').click(function(e){
        var textFadeSpeed = 800;
        if(!$(this).hasClass('open')){
            
            if($(this).hasClass('init')){
                $('#whatsnewSlides .whatsnewslide,.slideTitle').removeClass('init');
            }
            var num = $(this).attr('data-slideNum');
            $('#whatsnewSlides .whatsnewslide,.slideTitle').removeClass('open active0 active1 active2 active3 active4 from0 from1 from2 from3 from4 closed');
            $(this).addClass('open');
            $('#whatsnewSlides .whatsnewslide .slideImage').removeClass('anim').hide();
            $(this).find('.behindOverlay').fadeIn(500);
            $('#whatsnewSlides .whatsnewslide,.slideTitle').addClass('active'+num+' from'+prevSlide);
            $('#whatsnewSlides .whatsnewslide').not(this).addClass('closed');
            $('#whatsnewSlides .whatsnewslide').not(this).find('.behindOverlay').fadeOut(500);
            prevSlide = num;
            setTimeout(function(){
                gamePadClick = false;
                $('#whatsnewSlides .whatsnewslide.open .slideImage').show();
                // $('#whatsnewSlides .whatsnewslide.open .slideImage').addClass('anim');
            },600);

            setTimeout(function(){
                $('#whatsnewSlides .whatsnewslide.open .slideImage').addClass('anim');
            },650);
            // $('#whatsnewSlides .whatsnewslide.open .slideImage').show().addClass('anim');

        }
    });
    
    

});
function openOverlay() {
    const originalIframe = document.querySelector('.whatsnewslide.open .slideContent iframe');
    const overlay = document.getElementById('iframeOverlay');
    const fullscreenIframe = document.getElementById('fullscreenIframe');

    // Set the src of the overlay iframe to match the original iframe's content
    if (originalIframe) {
        fullscreenIframe.src = originalIframe.src;
    }

    // Show the overlay
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling

    // Re-trigger the animation (in case it's opened again)
    overlay.style.animation = 'none'; // Reset animation
    setTimeout(() => {
        overlay.style.animation = ''; // Reapply animation
    }, 10);
}


function closeOverlay() {
    const overlay = document.getElementById('iframeOverlay');
    const fullscreenIframe = document.getElementById('fullscreenIframe');

    // Trigger the closing animation by adding a class
    overlay.classList.add('hidden');

    // Wait for the animation to complete before hiding the overlay
    setTimeout(() => {
        overlay.style.display = 'none';
        overlay.classList.remove('hidden'); // Reset for next time
        fullscreenIframe.src = ''; // Clear the src to stop loading while hidden
        document.body.style.overflow = ''; // Restore body scrolling
    }, 300); // Match the duration of the animation (0.3s)
}
function openPrimeAccessOverlay() {
    const overlay = document.getElementById('iframeOverlay');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closePrimeAccessOverlay() {
    const overlay = document.getElementById('iframeOverlay');
    overlay.style.display = 'none';
    document.body.style.overflow = ''; // Restore background scrolling
}

function openOverlayWithContent(url) {
    const overlay = document.getElementById('iframeOverlay');
    const fullscreenIframe = document.getElementById('fullscreenIframe');

    // Update iframe content dynamically
    fullscreenIframe.src = url;

    // Show the overlay
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}
