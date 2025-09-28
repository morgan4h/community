console.log("hello world");

// routing section

function redirect(dataValue) {
    // console.log(dataValue);
    if(dataValue == 1) {
        console.log('go to download page')
        location.href = '../community/public/download.html'
    }else if (dataValue == 2) {
        console.log('go to login page')
        location.href = '../community/public/login.html'
    }else if (dataValue == 3) {
        console.log('go to upload page')
        location.href = '../community/public/upload.html'
    }else if (dataValue == 4) {
        console.log('www.youtube.com/@SOFAI4H')
        window.open('https://www.youtube.com/@SOFAI4H')
    } else {
        console.log('there is no page to go to')
    }
    return dataValue;
}


// create the event function that get the destination 
document.addEventListener('click', function(e) {
    let destination = e.target.getAttribute('data-route');
    redirect(destination)
})

