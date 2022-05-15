const pwd = document.getElementsByClassName('password');
const manual = document.getElementsByClassName('manual');
const generate = document.getElementsByClassName('generate');
Array.from(manual).forEach((item,i) => {
  item.addEventListener("click",()=>{
    pwd[i].readOnly = false;
  });
});
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
const numbers = "0123456789";
const lowerCase ="abcdefghijklmnopqrstuvwxyz";
const upperCase ="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const special = "!@#$%^*?|~&";
const options = [numbers,lowerCase,upperCase,special];
Array.from(pwdForm).forEach((item, i) => {
  item.addEventListener('submit',pwdGeneration);
  item.index = i;
});
function pwdGeneration(e){
  e.preventDefault();
  const length = Number(document.getElementsByClassName("length")[e.currentTarget.index].value);
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
  if(checked.length > length && length>0){
    message.appendChild(document.createTextNode("the password length is too short for the number of selected options"));
    message.appendChild(document.createElement('br'));
  }
  if(message.childNodes.length != 0){
    message.className = 'alert';
    message.className +=' alert-danger';
    message.className +=' mt-3';
    message.setAttribute('role','alert');
    pwdForm[e.currentTarget.index].appendChild(message);
    setTimeout(function(i){
      pwdForm[i].removeChild(message);
    },4000,e.currentTarget.index)
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
  pwd[e.currentTarget.index].readOnly = false;
}

const editBtn = document.getElementsByClassName('edit-btn');
Array.from(editBtn).forEach((item,i) => {
  item.addEventListener('click',editModal);
  item.index = i;
});
const dummy = document.getElementById('dummy');
const modalEvent = new Event('click');
const inputEditForm = document.getElementById('edit-form').querySelectorAll("input[type='text']");
const hiddenEdit = document.getElementById('hidden-edit');
function editModal(e){
  e.preventDefault();
  const data = document.getElementsByTagName('tr')[e.currentTarget.index+1].getElementsByTagName('td');
  console.log(data);
  console.log(inputEditForm);
  inputEditForm.forEach((item, i) => {
    item.value = data[i].innerText;
  });
  hiddenEdit.value = e.currentTarget.value;
  dummy.dispatchEvent(modalEvent);
}
