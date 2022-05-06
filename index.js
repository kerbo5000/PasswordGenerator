const loginBtn = document.getElementById('login-btn');
const signupBtn = document.getElementById('signup-btn');
const tabs = document.getElementsByClassName('tab')
loginBtn.addEventListener("click",tabSwitch);
signupBtn.addEventListener("click",tabSwitch);
function tabSwitch(e){
  Array.from(tabs).forEach((item) => {
    if(e.target.value != item.id){
      item.style.display = "none";
    }else{
      item.style.display ="";
    }
  });
}
