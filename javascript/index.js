const loginBtn = document.getElementById('login-btn');
const signupBtn = document.getElementById('signup-btn');
const tabs = document.getElementsByClassName('tab-pane')
const navs = document.getElementsByClassName('nav-link')
loginBtn.addEventListener("click",tabSwitch);
signupBtn.addEventListener("click",tabSwitch);
function tabSwitch(e){
  Array.from(navs).forEach((item) => {
    if(e.target != item){
      item.classList.remove("active");
    }else{
      item.classList.add("active");
    }
  });
  Array.from(tabs).forEach((item) => {
    if(e.target.value != item.id){
      item.classList.remove("active");
      item.classList.remove("show");
    }else{
      item.classList.add("active");
      item.classList.add("show");
    }
  });
}
