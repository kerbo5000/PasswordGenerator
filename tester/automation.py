from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException, StaleElementReferenceException
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def login(driver,wait,username,password):
    login_btn = wait.until(EC.element_to_be_clickable((By.ID,'login-btn')))
    login_btn.click()
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'login-username')))
    password_input = wait.until(EC.presence_of_element_located((By.NAME,'login-password')))
    username_input.clear()
    username_input.send_keys(username)
    password_input.clear()
    password_input.send_keys(password)
    submit = driver.find_element(By.NAME,'login-submit')
    submit.click()
    return

def signup(driver,wait,username,email,password,repeat_password):
    signup_btn = wait.until(EC.element_to_be_clickable((By.ID,'signup-btn')))
    signup_btn.click()
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-username')))
    email_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-email')))
    password_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-password')))
    rep_password_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-repeat-password')))
    username_input.clear()
    username_input.send_keys(username)
    email_input.clear()
    email_input.send_keys(email)
    password_input.clear()
    password_input.send_keys(password)
    rep_password_input.clear()
    rep_password_input.send_keys(repeat_password)
    submit = driver.find_element(By.NAME,'signup-submit')
    submit.click()
    return

def add_account(driver,wait,account_name,username,email,password):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    account_name_input = wait.until(EC.presence_of_element_located((By.NAME,'account-name')))
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'username')))
    email_input = wait.until(EC.presence_of_element_located((By.NAME,'email')))
    account_name_input.click()
    account_name_input.send_keys(account_name)
    username_input.send_keys(username)
    email_input.send_keys(email)
    if password:
        manual_btn = wait.until(EC.element_to_be_clickable((By.CLASS_NAME,'manual')))
        manual_btn.click()
        password_input = wait.until(EC.presence_of_element_located((By.NAME,'password')))
        password_input.send_keys(password)
    else:
        generate(driver,wait,10,[1,3],1)
    submit_btn = driver.find_element(By.NAME,'submit')
    submit_btn.click()
    return

def generate(driver,wait,length,options,location):
    generate_btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,'div.modal:nth-of-type('+str(location)+') .generate')))
    generate_btn.click()
    length_input =wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,'div.modal:nth-of-type('+str(location)+') .length')))
    length_input.send_keys(length)
    options_inputs = wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR,'div.modal:nth-of-type('+str(location)+')' +' input[type="checkbox"]')))
    for i in options:
        options_inputs[i].click()
    submit_btn = driver.find_element(By.CSS_SELECTOR,'div.modal:nth-of-type('+str(location)+')'+' button[type="submit"]')
    submit_btn.click()
    return

def logout(driver,wait):
    logout_btn = wait.until(EC.element_to_be_clickable((By.NAME,'logout')))
    logout_btn.click()
    return

def get_accounts(driver,wait):
    table_rows = wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR,'tbody tr')))
    accounts =list()
    for row in table_rows:
        colus = row.find_elements(By.TAG_NAME,'td')
        account = list()
        for i in range(0,4):
            account.append(colus[i].text)
        accounts.append(account)
    return accounts

def delete_account(driver,wait,account):
    table_row = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,'tbody tr:nth-child('+str(account)+') ')))
    colus = table_row.find_elements(By.TAG_NAME,'td')
    delete_btn = colus[-1].find_element(By.NAME,'id-delete')
    delete_btn.click()
    return

def edit_account(driver,wait,account,changes):
    edit_btn = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,'tbody tr:nth-child('+str(account)+') .edit-btn')))
    edit_btn.click()
    for i in changes:
        match i:
            case 'username':
                username_input = wait.until(EC.presence_of_element_located((By.NAME,'usernameEdit')))
                username_input.click()
                username_input.clear()
                username_input.send_keys(changes[i])
            case 'email':
                email_input = wait.until(EC.presence_of_element_located((By.NAME,'emailEdit')))
                email_input.click()
                email_input.clear()
                email_input.send_keys(changes[i])
            case 'password':
                if isinstance(changes[i],str):
                    manual_btn = wait.until(EC.element_to_be_clickable((By.CLASS_NAME,'manual')))
                    manual_btn.click()
                    password_input = wait.until(EC.presence_of_element_located((By.NAME,'passwordEdit')))
                    password_input.clear()
                    password_input.send_keys(changes[i])
                else:
                    generate(driver,wait,changes[i][0],changes[i][1],2)
    submit_btn = driver.find_element(By.NAME,'id-edit')
    submit_btn.click()
    return

def close_form(driver,wait,location):
    close_btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,'div.modal:nth-of-type('+str(location)+') .btn-close')))
    close_btn.click()
    return

def search(driver,wait,filter,input):
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'search')))
    username_input.click()
    username_input.send_keys(input)
    radio_btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,'input[type="radio"][value='+filter+']')))
    radio_btn.click()
    search_btn = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR,'button[name="search-btn"]')))
    search_btn.click()
    return

# def test():
#     options = webdriver.ChromeOptions()
#     options.add_experimental_option('detach',True)
#     # options.add_argument('headless')
#     s = Service("C:\SeleniumDrivers\chromedriver")
#     driver = webdriver.Chrome(service=s, options=options)
#     wait = WebDriverWait(driver,10)
#     BASE_URL = 'http://localhost/PasswordGenerator/frontpage.php'
#     driver.get(BASE_URL)
#     login(driver,wait,'kerby','1234')
#     # add_account(driver,wait,'','test1','test@gmail.com','')
#     search(driver,wait,'email','test@gmail.com')
#     # edit_account(driver,wait,2,{"username":"","password":[10,[2,3]]})
#     # close_form(driver,wait,2)
# test()
