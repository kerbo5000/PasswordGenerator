from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException, TimeoutException,ElementNotInteractableException
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import automation as auto
from random import randint
from faker import Faker
from faker.providers import internet

def test():
    options = webdriver.ChromeOptions()
    options.add_experimental_option('detach',True)
    # options.add_argument('headless')
    s = Service("C:\SeleniumDrivers\chromedriver")
    driver = webdriver.Chrome(service=s, options=options)
    wait = WebDriverWait(driver,10)
    BASE_URL = 'http://localhost/PasswordGenerator/frontpage.php'
    driver.get(BASE_URL)
    fake = Faker()
    fake.add_provider(internet)
    username = fake.user_name();
    email = username+'@'+fake.free_email_domain()
    auto.signup(driver,wait,username,email,'1234','1234')
    auto.add_account(driver,wait,'facebook','initial1','initial@gmail.com','4321')
    auto.add_account(driver,wait,'facebook','initial2','initial@hotmail.com','1234')
    auto.add_account(driver,wait,'youtube','initial3','initial@gmail.com','9876')
    auto.add_account(driver,wait,'twitter','initial4','initial@outlook.com','6789')
    auto.logout(driver,wait)
    results = 0
    print('-----------starting tests-----------')
    print('-----------signup test-----------')
    if signup_missing_inputs(driver,wait): results+=1
    if signup_invalid_email(driver,wait): results+=1
    if signup_invalid_username(driver,wait): results+=1
    if signup_psw_nomatch(driver,wait): results+=1
    if signup_user_exists(driver,wait,username): results+=1
    if signup_1(driver,wait): results+=1
    print('-----------login test-----------')
    if login_missing_inputs(driver,wait): results+=1
    if login_pwd_nomatch(driver,wait,username): results+=1
    if login_no_account(driver,wait): results+=1
    if login_1(driver,wait,username): results+=1
    print('-----------search test-----------')
    if search_missing_input(driver,wait): results+=1
    if search_1(driver,wait): results+=1
    if search_2(driver,wait): results+=1
    print('-----------password generator test-----------')
    if generator_missing_length(driver,wait): results+=1
    if generator_missing_options(driver,wait): results+=1
    if generator_too_many_options(driver,wait): results+=1
    print('-----------add account test-----------')
    if add_account_missing_inputs(driver,wait): results+=1
    if add_account_invalid_email(driver,wait): results+=1
    if add_account_exists(driver,wait): results+=1
    if add_account_1(driver,wait): results+=1
    if add_account_2(driver,wait): results+=1
    print('-----------edit account test-----------')
    if edit_missing_input(driver,wait): results+=1
    if edit_invalid_email(driver,wait): results+=1
    if edit_2nd(driver,wait): results+=1
    if edit_last(driver,wait): results+=1
    print('-----------delete account test-----------')
    if delete_last(driver,wait): results+=1
    if delete_3rd(driver,wait): results+=1
    print('-----------logout test-----------')
    if logout_1(driver,wait): results+=1
    print('-----------tests done-----------')
    print('passed '+str(results)+' out of 28 tests')

def signup_missing_inputs(driver,wait):
    print('signup missing inputs')
    try:
        auto.signup(driver,wait,'kerby','','qwer','qwer')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def signup_invalid_email(driver,wait):
    print('signup inavlid email')
    try:
        auto.signup(driver,wait,'kerby1','sdfgmailcom','qwer','qwer')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'email is invalid'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def signup_invalid_username(driver,wait):
    print('signup invalid username')
    try:
        auto.signup(driver,wait,'kerby1/','sdf@gmail.com','qwer','qwer')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'username is invalid'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def signup_psw_nomatch(driver,wait):
    print("signup passwords don't match")
    try:
        auto.signup(driver,wait,'kerby1','sdf@gmail.com','qwert','qwer')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'the passwords don\'t match'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def signup_user_exists(driver,wait,username):
    print('signup user exixts')
    try:
        auto.signup(driver,wait,username,'sdf@gmail.com','12345','12345')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'username or email already used'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def signup_1(driver,wait):
    print('signup successful')
    try:
        fake = Faker()
        fake.add_provider(internet)
        username = fake.user_name();
        email = username+'@'+fake.free_email_domain()
        auto.signup(driver,wait,username,email,'12345','12345')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.url_to_be('http://localhost/PasswordGenerator/account.php'))
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'p#user'),'Hi, '+username))
        print('test is passed')
        auto.logout(driver,wait)
        return True
    except Exception as e:
        print(e)
        print('test is failed')
        return False

def login_missing_inputs(driver,wait):
    print('login missing inputs')
    try:
        auto.login(driver,wait,'kerby','')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'missing inputs'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def login_pwd_nomatch(driver,wait,username):
    print("login password doesn't match")
    try:
        auto.login(driver,wait,username,'12345')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'password doesn\'t match with account'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def login_no_account(driver,wait):
    print('login no account')
    try:
        auto.login(driver,wait,'tom2','12345')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'account doesn\'t exist'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def login_1(driver,wait,username):
    print('login successful')
    try:
        auto.login(driver,wait,username,'1234')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.url_to_be('http://localhost/PasswordGenerator/account.php'))
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'p#user'),'Hi, '+username))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def add_account_missing_inputs(driver,wait):
    print('add account missing inputs')
    try:
        auto.add_account(driver,wait,'','test1','test@gmail.com','qwert')
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(1) div.alert-danger p'),'missing inputs'))
        auto.close_form(driver,wait,1)
        print('test is passed')
        print()
        return True
    except:
        print('test is failed')
        return False

def add_account_invalid_email(driver,wait):
    print('add account invalid email')
    try:
        auto.add_account(driver,wait,'test','test1','testgmail.com','qwert')
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(1) div.alert-danger p'),'email is invalid'))
        auto.close_form(driver,wait,1)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def add_account_exists(driver,wait):
    print('adding existing account')
    try:
        auto.add_account(driver,wait,'facebook','initial1','initial@gmail.com','qwert')
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(2) div.alert-danger p'),'Account already exists, you can update it here'))
        auto.close_form(driver,wait,2)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def add_account_1(driver,wait):
    print('add account without password generator')
    try:
        auto.add_account(driver,wait,'facebook','test1','test1@gmail.com','qwert')
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-success p'),'Account has been added'))
        account_name,email,username,password = auto.get_accounts(driver,wait)[-1]
        if account_name == 'facebook' and email == 'test@gmail.com' and username == 'test1' and password == 'qwert':
            print('test is passed')
            return True
        else:
            print('test is failed')
            print('hi')
            return False
    except:
        print('test is failed')
        return False

def add_account_2(driver,wait):
    print('add account with password generator')
    try:
        auto.add_account(driver,wait,'youtube','test2','test2@gmail.com','')
    except (TimeoutException,ElementNotInteractableException)  as e:
        print(e)
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-success p'),'Account has been added'))
        account_name,email,username,password = auto.get_accounts(driver,wait)[-1]
        if account_name == 'youtube' and email == 'test1@gmail.com' and username == 'test1':
            print('test is passed')
            return True
        else:
            print('test is failed')
            print('hi')
            return False
    except:
        print('test is failed')
        return False

def edit_missing_input(driver,wait):
    print('edit account missing inputs')
    try:
        accounts = auto.get_accounts(driver,wait)
        account_name,email,username,password = accounts[-1]
        auto.edit_account(driver,wait,1,{"username":"","password":'123456'})
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,2)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(2) div.alert-warning p'),'missing inputs'))
        auto.close_form(driver,wait,2)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def edit_invalid_email(driver,wait):
    print('edit account invalid eamil')
    try:
        accounts = auto.get_accounts(driver,wait)
        account_name,email,username,password = accounts[-1]
        auto.edit_account(driver,wait,1,{"email":"testgmail.com","password":'123456'})
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,2)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(2) div.alert-warning p'),'email is invalid'))
        auto.close_form(driver,wait,2)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def edit_2nd(driver,wait):
    print('editing 2nd account')
    try:
        auto.edit_account(driver,wait,2,{"username":"hello","password":[10,[2,3]]})
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,2)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-warning p'),'Account has been updated'))
        new_account_name,new_email,new_username,new_password = auto.get_accounts(driver,wait)[1]
        if 'facebook' == new_account_name and 'initial@hotmail.com' == new_email and new_username == 'hello':
            print('test is passed')
            return True
        else:
            print('test is failed')
            return False
    except:
        print('test is failed')
        return False

def edit_last(driver,wait):
    print('editing random account')
    try:
        accounts = auto.get_accounts(driver,wait)
        account_name,email,username,password = accounts[-1]
        auto.edit_account(driver,wait,random,{"username":"bye","password":'123456'})
    except (TimeoutException,ElementNotInteractableException) as e:
        print(e)
        auto.close_form(driver,wait,2)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-warning p'),'Account has been updated'))
        new_account_name,new_email,new_username,new_password = auto.get_accounts(driver,wait)[-1]
        if account_name == new_account_name and email == new_email and new_username == 'bye' and new_password == '123456':
            print('test is passed')
            return True
        else:
            print('test is failed')
            return False
    except:
        print('test is failed')
        return False

def generator_missing_length(driver,wait):
    print('password generator missing password length')
    try:
        add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
        add_account_btn.click()
        auto.generate(driver,wait,'',[1,3],1)
    except (TimeoutException,ElementNotInteractableException):
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(1) div.pwd-div div.alert-danger '),'the password length has to be greater than 0'))
        auto.close_form(driver,wait,1)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def generator_missing_options(driver,wait):
    print('password generator missing options')
    try:
        add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
        add_account_btn.click()
        auto.generate(driver,wait,12,[],1)
    except (TimeoutException,ElementNotInteractableException):
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(1) div.pwd-div div.alert-danger '),'you have to select at least one option'))
        auto.close_form(driver,wait,1)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def generator_too_many_options(driver,wait):
    print('password generator has too many options')
    try:
        add_account_btn = wait.until(EC.element_to_be_clickable((By.ID,'add-btn')))
        add_account_btn.click()
        auto.generate(driver,wait,2,[0,1,3],1)
    except (TimeoutException,ElementNotInteractableException):
        auto.close_form(driver,wait,1)
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.modal:nth-of-type(1) div.pwd-div div.alert-danger '),'the password length is too short for the number of selected options'))
        auto.close_form(driver,wait,1)
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def delete_last(driver,wait):
    print('deleting last account')
    try:
        accounts = auto.get_accounts(driver,wait)
        account_name,email,username,password = accounts[-1]
        auto.delete_account(driver,wait,len(accounts))
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'Account has been deleted'))
        new_accounts = auto.get_accounts(driver,wait)
        for account in new_accounts:
            new_account_name,new_email,new_username,new_password = account
            if account_name == new_account_name and email == new_email and username == new_username and password == new_password:
                print('test is failed')
                return False
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def delete_3rd(driver,wait):
    print('deleting random account')
    try:
        auto.delete_account(driver,wait,3)
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'Account has been deleted'))
        new_accounts = auto.get_accounts(driver,wait)
        for account in new_accounts:
            new_account_name,new_email,new_username,new_password = account
            if account_name == 'youtube' and email == 'initial@gmail.com' and username == 'initial3' and password == '9876':
                print('test is failed')
                return False
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def search_missing_input(driver,wait):
    print('search missing inputs')
    try:
        auto.search(driver,wait,'email','')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.text_to_be_present_in_element((By.CSS_SELECTOR,'div.alert-danger p'),'Search field has to be filled and option has to be selected for filter to work'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def search_1(driver,wait):
    print('search missing inputs')
    try:
        auto.search(driver,wait,'email','initial@gmail.com')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        filtered_accounts = auto.get_accounts(driver,wait)
        for account in filtered_accounts:
            if account[1] != 'test@gmail.com':
                print('test is failed')
                return False
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def search_2(driver,wait):
    print('search missing inputs')
    try:
        auto.search(driver,wait,'accountName','facebook')
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        filtered_accounts = auto.get_accounts(driver,wait)
        for account in filtered_accounts:
            if account[0] != 'facebook':
                print('test is failed')
                return False
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

def logout_1(driver,wait):
    print('logout successful')
    try:
        auto.logout(driver,wait)
    except (TimeoutException,ElementNotInteractableException):
        print("test wasn't able to run")
        return False
    try:
        wait.until(EC.url_to_be('http://localhost/PasswordGenerator/frontpage.php'))
        print('test is passed')
        return True
    except:
        print('test is failed')
        return False

test()
