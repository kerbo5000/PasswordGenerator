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
    # login(driver,wait,'kerby','1234')
    # signup(driver,wait,'tom','tom@gmail.com','1234','1234')
    # logout(driver,wait)
    # driver.get(BASE_URL)
    # signup_missing_inputs(driver,wait)
    # signup_invalid_email(driver,wait)
    # signup_invalid_username(driver,wait)
    # signup_user_exists(driver,wait)
    # login_missing_inputs(driver,wait)
    # login_pwd_nomatch(driver,wait)
    login_no_account(driver,wait)

    # signup_psw_nomatch(driver,wait)

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

def add_account(driver,wait,account_name,username,email):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()



test()
