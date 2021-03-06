// code for the typing animation header in the UI

var typed = new Typed('.typing', {
    strings: ["Shorten Your Long URL With Ease"],
    typeSpeed: 310,
    loop: true
});


// selecting all required elements

const form = document.querySelector(".wrapper form"),
fullURL = form.querySelector("input"),
shortenBtn = form.querySelector("button"),
blurEffect = document.querySelector(".blur-effect"),
popupBox = document.querySelector(".popup-box"),
form2 = popupBox.querySelector("form"),
shortenURL = popupBox.querySelector("input"),
saveBtn = popupBox.querySelector("button"),
closeBtn = popupBox.querySelector("button#close"),
copyBtn = popupBox.querySelector(".url-copy"),
infoBox = popupBox.querySelector(".info-box");



form.onsubmit = (e)=>{
    e.preventDefault(); // preventing form from submiting
}

closeBtn.addEventListener('click', () =>{
    blurEffect.style.display = "none";
    popupBox.classList.remove("show")
});

shortenBtn.onclick = ()=>{
    // let's start ajax
    let xhr = new XMLHttpRequest(); // creating xhr object
    xhr.open("POST", "php/url-controll.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            let data = xhr.response;
            if(data.length <= 5){
                blurEffect.style.display = "block";
                popupBox.classList.add("show");

                let domain = "localhost/url_shortener/";
                shortenURL.value = domain + data;
                copyBtn.onclick = ()=>{
                    shortenURL.select();
                    document.execCommand("copy");
                }

                form2.onsubmit = (e)=>{
                    e.preventDefault(); // preventing form from submiting
                }

                // let's work on the save button
                saveBtn.onclick = ()=>{
                    let xhr2 = new XMLHttpRequest(); // creating xhr object
                    xhr2.open("POST", "php/save-url.php", true);
                    xhr2.onload = ()=>{
                        if(xhr2.readyState == 4 && xhr2.status == 200){
                            let data = xhr2.response;
                            if(data == "Success"){
                                //reload the current page 
                                location.reload();
                            }else{
                                infoBox.innerText = data;
                                infoBox.classList.add("error");
                            }
                        }
                    }
                    // let's send two data/value from ajax to php
                    let short_url = shortenURL.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr2.send("shorten_url="+short_url+"&hidden_url="+hidden_url);

                }

            }else{
                alert(data);
            }
        }
    }
    // let's send from data to php file
    let formData = new FormData(form); // creating new FormData object
    xhr.send(formData); // sending form value to php
}