from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException, StaleElementReferenceException
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def test():
    options = webdriver.ChromeOptions()
    options.add_experimental_option('detach',True)
    # options.add_argument('headless')
    s = Service("C:\SeleniumDrivers\chromedriver")
    driver = webdriver.Chrome(service=s, options=options)
    wait = WebDriverWait(driver,6)
    BASE_URL = 'http://localhost/PasswordGenerator/frontpage.php'
    driver.get(BASE_URL)
    login(driver,wait,'kerby','1234')
    # add_account(driver,wait,'test','test1','test@gmail.com','')
    # signup(driver,wait,'tom','tom@gmail.com','1234','1234')
    # logout(driver,wait)
    # driver.get(BASE_URL)
    # signup_missing_inputs(driver,wait)
    # signup_invalid_email(driver,wait)
    # signup_invalid_username(driver,wait)
    # signup_user_exists(driver,wait)
    # login_missing_inputs(driver,wait)
    # login_pwd_nomatch(driver,wait)
    # login_no_account(driver,wait)
    # signup_psw_nomatch(driver,wait)
    # add_account_missing_inputs(driver,wait)
    # add_account_invalid_email(driver,wait)
    # generator_missing_length(driver,wait)
    # generator_missing_options(driver,wait)
    # generator_too_many_options(driver,wait)
    # get_accounts(driver,wait)
    # delete_account(driver,wait,2)
    edit_account(driver,wait,1,{"email":"test@hotmail.com","password":[10,[2,3]]})
    # add_account(driver,wait,'test3','test2','test@gmail.com','')

def login(driver,wait,username,password):
    login_btn = wait.until(EC.element_to_be_clickable((By.ID,'login-btn')))
    login_btn.click()
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'login-username')))
    password_input = wait.until(EC.presence_of_element_located((By.NAME,'login-password')))
    username_input.send_keys(username)
    password_input.send_keys(password)
    submit = driver.find_element(By.NAME,'login-submit')
    submit.click()

def signup(driver,wait,username,email,password,repeat_password):
    signup_btn = wait.until(EC.element_to_be_clickable((By.ID,'signup-btn')))
    signup_btn.click()
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-username')))
    email_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-email')))
    password_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-password')))
    rep_password_input = wait.until(EC.presence_of_element_located((By.NAME,'signup-repeat-password')))
    username_input.send_keys(username)
    email_input.send_keys(email)
    password_input.send_keys(password)
    rep_password_input.send_keys(repeat_password)
    submit = driver.find_element(By.NAME,'signup-submit')
    submit.click()

def add_account(driver,wait,account_name,username,email,password):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    account_name_input = wait.until(EC.presence_of_element_located((By.NAME,'account-name')))
    username_input = wait.until(EC.presence_of_element_located((By.NAME,'username')))
    email_input = wait.until(EC.presence_of_element_located((By.NAME,'email')))
    account_name_input.send_keys(account_name)
    username_input.send_keys(username)
    email_input.send_keys(email)
    if password:
        manual_btn = wait.until(EC.element_to_be_clickable((By.CLASS_NAME,'manual')))
        manual_btn.click()
        password_input = wait.until(EC.presence_of_element_located((By.NAME,'password')))
        password_input.send_keys(password)
    else:
        generate(driver,wait,10,[1,3],0)
    submit_btn = driver.find_element(By.NAME,'submit')
    submit_btn.click()

def generate(driver,wait,length,options,location):
    generate_btn = wait.until(EC.visibility_of_element_located((By.CLASS_NAME,'generate')))
    generate_btn.click()
    length_input =wait.until(EC.visibility_of_element_located((By.CLASS_NAME,'length')))
    length_input.send_keys(length)
    options_inputs = wait.until(EC.visibility_of_element_located((By.CSS_SELECTOR,'.pwd-generator input[type="checkbox"]')))
    for i in options:
        options_inputs[i].click()
    submit_btn = driver.find_element(By.CSS_SELECTOR,'.pwd-generator button[type="submit"]')
    submit_btn.click()

def logout(driver,wait):
    logout_btn = wait.until(EC.element_to_be_clickable((By.NAME,'logout')))
    logout_btn.click()

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
    table_row = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,'tbody tr:nth-child('+str(account)+')')))
    account = list()
    colus = table_row.find_elements(By.TAG_NAME,'td')
    for i in range(0,4):
        account.append(colus[i].text)
    delete_btn = colus[-1].find_element(By.NAME,'id-delete')
    delete_btn.click()
    return account

def edit_account(driver,wait,account,changes):
    edit_btn = wait.until(EC.presence_of_element_located((By.CSS_SELECTOR,'tbody tr:nth-child('+str(account)+') .edit-btn')))
    edit_btn.click()
    for i in changes:
        match i:
            case 'username':
                username_input = wait.until(EC.presence_of_element_located((By.NAME,'usernameEdit')))
                username_input.clear()
                username_input.send_keys(changes[i])
            case 'email':
                email_input = wait.until(EC.presence_of_element_located((By.NAME,'emailEdit')))
                # print(email_input.get_attribute('outerHTML'))
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
                    generate(driver,wait,changes[i][0],changes[i][1])



def signup_missing_inputs(driver,wait):
    signup(driver,wait,'kerby','','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        return True
    except:
        return False

def signup_invalid_email(driver,wait):
    signup(driver,wait,'kerby1','sdfgmailcom','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'email is invalid'))
        return True
    except:
        return False

def signup_invalid_username(driver,wait):
    signup(driver,wait,'kerby1/','sdf@gmail.com','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'username is invalid'))
        return True
    except:
        return False

def signup_psw_nomatch(driver,wait):
    signup(driver,wait,'kerby1','sdf@gmail.com','qwert','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'the passwords don\'t match'))
        return True
    except:
        return False

def signup_user_exists(driver,wait):
    signup(driver,wait,'tom','tom@gmail.com','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'username or email already used'))
        return True
    except:
        return False

def logout(driver,wait):
    logout_btn = wait.until(EC.element_to_be_clickable((By.NAME,'logout')))
    logout_btn.click()

def login_missing_inputs(driver,wait):
    login(driver,wait,'kerby','')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        return True
    except:
        return False

def login_pwd_nomatch(driver,wait):
    login(driver,wait,'kerby','12345')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'password doesn\'t match with account'))
        return True
    except:
        return False

def login_no_account(driver,wait):
    login(driver,wait,'tom2','12345')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'account doesn\'t exist'))
        return True
    except:
        return False

def add_account_missing_inputs(driver,wait):
    add_account(driver,wait,'','test1','test@gmail.com','qwert')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        return True
    except:
        return False

def add_account_invalid_email(driver,wait):
    add_account(driver,wait,'test','test1','testgmail.com','qwert')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'email is invalid'))
        return True
    except:
        return False

def generator_missing_length(driver,wait):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    generate(driver,wait,'',[1,3])
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger '),'the password length has to be greater than 0'))
        return True
    except:
        return False

def generator_missing_options(driver,wait):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    generate(driver,wait,12,[])
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger '),'you have to select at least one option'))
        return True
    except:
        return False

def generator_too_many_options(driver,wait):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    generate(driver,wait,2,[0,1,3])
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger '),'the password length is too short for the number of selected options'))
        return True
    except:
        return False


test()
