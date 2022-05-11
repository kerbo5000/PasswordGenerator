const pwd = document.getElementById('password');
const manual = document.getElementById('manual');
const generate = document.getElementById('generate');
manual.addEventListener("click",()=>{
  pwd.disabled = false;
});
const pwdForm = document.getElementById('pwd-generator');
generate.addEventListener("click",()=>{
  pwdForm.style.display="";
});
const numbers = "0123456789";
const lowerCase ="abcdefghijklmnopqrstuvwxyz";
const upperCase ="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const special = "!@#$%^*?|~&";
const options = [numbers,lowerCase,upperCase,special];
pwdForm.addEventListener("submit",pwdGeneration);
function pwdGeneration(e){
  e.preventDefault();
  const length = Number(document.getElementById("length").value);
  //const message = document.createElement('h3')
  const message = document.createElement('div')
  if(!Number.isInteger(length)||length<= 0){
    message.appendChild(document.createTextNode("the password length has to be greater than 0"));
    message.appendChild(document.createElement('br'));
  }
  const checked = pwdForm.querySelectorAll('input[type="checkbox"]:checked');
  if(checked.length <= 0){
    message.appendChild(document.createTextNode("you have to select at least one option"));
    message.appendChild(document.createElement('br'));
  }
  if(checked.length > length){
    message.appendChild(document.createTextNode("the password length is too short for the number of selected options"));
    message.appendChild(document.createElement('br'));
  }
  if(message.childNodes.length != 0){
    pwdForm.appendChild(message);
    setTimeout(function(){
      pwdForm.removeChild(message);
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
  pwd.value = result.join('');
  pwd.disabled = false;

}
