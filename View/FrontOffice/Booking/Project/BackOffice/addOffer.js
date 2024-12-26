var today = new Date().toISOString().split("T")[0]; //YYYY-MM-DDTHH:MM:SS.sssZ > ['YYYY-MM-DD','HH:MM:SS.sssZ']
document.getElementById("departure_date").setAttribute("min", today);
document.getElementById("return_date").setAttribute("min", today);

function validateTitle(){
    var a = document.getElementById('title').value
    title_msg = document.getElementById('title_msg')


    if(a.length<3){
        // alert('The title must contain at least 3 characters.')
        title_msg.textContent = 'The title must contain at least 3 characters.'
        title_msg.style.color = 'red'
    
    } else {
        title_msg.innerHTML = 'Correct'
        title_msg.style.color = 'green'
    }
}


document.addEventListener('keyup',function() {
    validateTitle()
})

document.addEventListener('keyup',function() {
    var b = document.getElementById('destination').value 
    destination_msg = document.getElementById('destination_msg')

    if(/^[a-zA-Z ]{3,}$/.test(b)){
        destination_msg.innerHTML = 'Correct'
        destination_msg.style.color = 'green'
    }else {
        destination_msg.textContent = 'The title must contain at least 3 characters.'
        destination_msg.style.color = 'red'
    }

    
})


function validateForm(){
    var a = document.getElementById('title').value
    var b = document.getElementById('destination').value 
    var c = document.getElementById('departure_date').value 
    var d = document.getElementById('return_date').value
    var e = document.getElementById('price').value
    

    // 
    title_msg = document.getElementById('title_msg')
    destination_msg = document.getElementById('destination_msg')
    returndate_msg = document.getElementById('returndate_msg')
    price_msg = document.getElementById('price_msg')


    if(a.length<3){
        // alert('The title must contain at least 3 characters.')
        title_msg.textContent = 'The title must contain at least 3 characters.'
        title_msg.style.color = 'red'
    
    } else {
        title_msg.innerHTML = 'Correct'
        title_msg.style.color = 'green'
    }

    if(/^[a-zA-Z ]{3,}$/.test(b)){
        destination_msg.innerHTML = 'Correct'
        destination_msg.style.color = 'green'
    }else {
        destination_msg.textContent = 'The title must contain at least 3 characters.'
        destination_msg.style.color = 'red'
    }


    if( c >= d ){
        returndate_msg.textContent = 'The title must contain at least 3 characters.'
        returndate_msg.style.color = 'red'
    }else {
        returndate_msg.innerHTML = 'Correct'
        returndate_msg.style.color = 'green'
    }


    if(e<=0){
        price_msg.textContent = 'The title must contain at least 3 characters.'
        price_msg.style.color = 'red'
    }else {
        price_msg.innerHTML = 'Correct'
        price_msg.style.color = 'green'
    }


}


document.addEventListener('submit', function(e){
    e.preventDefault()
    validateForm()
})