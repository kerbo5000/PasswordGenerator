const loginBtn = document.getElementById('login-btn');
const signupBtn = document.getElementById('signup-btn');
const tabs = document.getElementsByClassName('tab')
loginBtn.addEventListener("click",tabSwitch);
signupBtn.addEventListener("click",tabSwitch);
// let php = "<?php $_POST = array();?>";
function tabSwitch(e){
  Array.from(tabs).forEach((item) => {
    if(e.target.value != item.id){
      item.style.display = "none";
    }else{
      item.style.display ="";
    }
  });
  // alert(php);
}
const pwd = document.getElementById('password');
const manual = document.getElementById('manual');
const generate = document.getElementById('generate');
manual.addEventListener("click",(){
  pwd.disabled = false;
}));
signupBtn.addEventListener("click",tabSwitch);
