from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException, StaleElementReferenceException
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import automation as auto
from random import randint

def test():
    options = webdriver.ChromeOptions()
    options.add_experimental_option('detach',True)
    # options.add_argument('headless')
    s = Service("C:\SeleniumDrivers\chromedriver")
    driver = webdriver.Chrome(service=s, options=options)
    wait = WebDriverWait(driver,10)
    BASE_URL = 'http://localhost/PasswordGenerator/frontpage.php'
    driver.get(BASE_URL)
    auto.login(driver,wait,'kerby','1234')
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
    # auto.edit_account(driver,wait,2,{"username":"hello","password":[10,[2,3]]})
    # add_account(driver,wait,'test3','test2','test@gmail.com','')
    add_account_1(driver,wait)

def signup_missing_inputs(driver,wait):
    auto.signup(driver,wait,'kerby','','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        return True
    except:
        return False

def signup_invalid_email(driver,wait):
    auto.signup(driver,wait,'kerby1','sdfgmailcom','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'email is invalid'))
        return True
    except:
        return False

def signup_invalid_username(driver,wait):
    auto.signup(driver,wait,'kerby1/','sdf@gmail.com','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'username is invalid'))
        return True
    except:
        return False

def signup_psw_nomatch(driver,wait):
    auto.signup(driver,wait,'kerby1','sdf@gmail.com','qwert','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'the passwords don\'t match'))
        return True
    except:
        return False

def signup_user_exists(driver,wait):
    auto.signup(driver,wait,'tom','tom@gmail.com','qwer','qwer')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'username or email already used'))
        return True
    except:
        return False

def login_missing_inputs(driver,wait):
    auto.login(driver,wait,'kerby','')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        return True
    except:
        return False

def login_pwd_nomatch(driver,wait):
    auto.login(driver,wait,'kerby','12345')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'password doesn\'t match with account'))
        return True
    except:
        return False

def login_no_account(driver,wait):
    auto.login(driver,wait,'tom2','12345')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'account doesn\'t exist'))
        return True
    except:
        return False

def add_account_missing_inputs(driver,wait):
    auto.add_account(driver,wait,'','test1','test@gmail.com','qwert')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        return True
    except:
        return False

def add_account_invalid_email(driver,wait):
    auto.add_account(driver,wait,'test','test1','testgmail.com','qwert')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'email is invalid'))
        return True
    except:
        return False

def add_account_1(driver,wait):
    auto.add_account(driver,wait,'facebook','test1','test@gmail.com','qwert')
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-success p'),'Account has been added'))
        account_name,email,username,password = auto.get_accounts(driver,wait)[-1]
        success = account_name == 'facebook' and email == 'test@gmail.com' and username == 'test1' and password == 'qwert'
        return success
    except:
        return False

def generator_missing_length(driver,wait):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    auto.generate(driver,wait,'',[1,3],1)
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger '),'the password length has to be greater than 0'))
        return True
    except:
        return False

def generator_missing_options(driver,wait):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    auto.generate(driver,wait,12,[],1)
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger '),'you have to select at least one option'))
        return True
    except:
        return False

def generator_too_many_options(driver,wait):
    add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
    add_account_btn.click()
    auto.generate(driver,wait,2,[0,1,3],1)
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger '),'the password length is too short for the number of selected options'))
        return True
    except:
        return False

def delete_last(driver,wait):
    accounts = auto.get_accounts(driver,wait)
    account_name,email,username,password = accounts[-1]
    del_account_name,del_email,del_username,del_password=auto.delete_account(driver,wait,len(accounts))
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'Account has been deleted'))
        new_account = auto.get_accounts(driver,wait)
        success = account_name == del_account_name and email == del_email and username == del_username and password == del_password
        return success
    except:
        return False

def delete_random(driver,wait):
    accounts = auto.get_accounts(driver,wait)
    random = randint(1,len(accounts))
    account_name,email,username,password = accounts[random-1]
    del_account_name,del_email,del_username,del_password=auto.delete_account(driver,wait,random)
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'Account has been deleted'))
        new_account = auto.get_accounts(driver,wait)
        success = account_name == del_account_name and email == del_email and username == del_username and password == del_password
        return success
    except:
        return False

test()
