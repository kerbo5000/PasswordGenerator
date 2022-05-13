const pwd = document.getElementsByClassName('password');
const manual = document.getElementsByClassName('manual');
const generate = document.getElementsByClassName('generate');
Array.from(manual).forEach((item) => {
  item.addEventListener("click",()=>{
    item.disabled = false;
  });
});

// manual[0].addEventListener("click",()=>{
//   pwd[0].disabled = false;
// });
// manual[1].addEventListener("click",()=>{
//   pwd[1].disabled = false;
// });

const pwdForm = document.getElementsByClassName('pwd-generator');
const formDiv = document.getElementsByClassName('form-div');
Array.from(generate).forEach((item,i) => {
  item.addEventListener("click",()=>{
    if(formDiv[i].style.display == 'none'){
      formDiv[i].style.display="";
    }else{
      formDiv[i].style.display="none";
    }
  });
});

// generate[0].addEventListener("click",()=>{
//   if(formDiv[0].style.display == 'none'){
//     formDiv[0].style.display="";
//   }else{
//     formDiv[0].style.display="none";
//   }
//
// });
const numbers = "0123456789";
const lowerCase ="abcdefghijklmnopqrstuvwxyz";
const upperCase ="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const special = "!@#$%^*?|~&";
const options = [numbers,lowerCase,upperCase,special];
Array.from(pwdForm).forEach((item, i) => {
  item.addEventListener('submit',pwdGeneration);
  item.index = i;
});

// pwdForm[0].addEventListener("submit",pwdGeneration);
function pwdGeneration(e){
  e.preventDefault();
  const length = Number(document.getElementsByClassName("length")[e.currentTarget.index].value);
  //const message = document.createElement('h3')
  const message = document.createElement('div')
  if(!Number.isInteger(length)||length<= 0){
    message.appendChild(document.createTextNode("the password length has to be greater than 0"));
    message.appendChild(document.createElement('br'));
  }
  const checked = pwdForm[e.currentTarget.index].querySelectorAll('input[type="checkbox"]:checked');
  if(checked.length <= 0){
    message.appendChild(document.createTextNode("you have to select at least one option"));
    message.appendChild(document.createElement('br'));
  }
  if(checked.length > length){
    message.appendChild(document.createTextNode("the password length is too short for the number of selected options"));
    message.appendChild(document.createElement('br'));
  }

  if(message.childNodes.length != 0){
    message.className = 'alert';
    message.className +=' alert-danger';
    message.className +=' mt-3';
    message.setAttribute('role','alert');
    pwdForm[e.currentTarget.index].appendChild(message);
    setTimeout(function(){
      pwdForm[e.currentTarget.index].removeChild(message);
    },4000)
    return
  }
  let result = Array(length).fill(-1);
  let chosenOptions = [];
  checked.forEach((item) => {
    chosenOptions.push(Number(item.value));
  });
  chosenOptions.forEach((item) => {
    let index = Math.floor(Math.random()*length);
    while(result[index]!=-1){
      index = Math.floor(Math.random()*length);
    }
    result[index] = item;
  });
  result.forEach((item, i) => {
    if(item == -1){
      result[i] = chosenOptions[Math.floor(Math.random()*chosenOptions.length)];
    }
    result[i] = options[result[i]][Math.floor(Math.random()*options[result[i]].length)];
  });
  pwd[e.currentTarget.index].value = result.join('');
  pwd[e.currentTarget.index].disabled = false;
}
