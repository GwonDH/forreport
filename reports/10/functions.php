<?php 
session_start();

// 데이터베이스에 연결
$db = mysqli_connect('localhost', 'root', '', 'multi_login'); //MySQL 연결

// 변수 선언
$username = "";
$email    = "";
$errors   = array(); 

// register_btn을 누르면 register() 함수 호출
if (isset($_POST['register_btn'])) { //register_btn을 눌렀는가?
        register(); //가입
}

// REGISTER USER
function register(){
        // 함수에서 사용 가능하도록 전역 변수들을 call함
        global $db, $errors, $username, $email;

        // e() 함수로 form을 통해 입력된 값들을 전달받음
        // form 값에서 벗어나도록 아래처럼 변수를 정의함
        $username    =  e($_POST['username']);
        $email       =  e($_POST['email']);
        $password_1  =  e($_POST['password_1']);
        $password_2  =  e($_POST['password_2']);

        // form validation: ensure that the form is correctly filled
        if (empty($username)) { //$username이 비어있다면 == 사용자명 미입력 시
                array_push($errors, "Username is required");  //$errors(문자열 배열)에 "Username is required" 삽입
        }
        if (empty($email)) { //$email이 비어있다면 == 이메일 미입력 시
                array_push($errors, "Email is required"); //$errors에 "Email is required" 삽입
        }
        if (empty($password_1)) { //$password_1이 비어있다면 == 비밀번호 미입력 시
                array_push($errors, "Password is required"); //$errors에 "Password is required" 삽입
        }
        if ($password_1 != $password_2) { //$password_1과 $password_2가 다르다면 == 비밀번호와 비밀번호 확인의 값이 상이할 시
                array_push($errors, "The two passwords do not match"); //$errors에 "The two passwords do not match" 삽입
        }

        // form에서 에러가 없다면 회원가입
        if (count($errors) == 0) { //$errors 배열 안에 값이 없다면(처음 functions.php를 불러올 경우 $errors=array(); 이므로 값이 존재하지 않는다. 즉, 배열 안에 값이 삽입되지 않았다면이라고 볼 수 있다.)
                $password = md5($password_1);//데이터베이스에 저장하기 전에 패스워드 암호화

                if (isset($_POST['user_type'])) { //user_type가 지정이 되어 있다면 = admin/create_user.php에서 온 값이냐라고 다시 해석할 수 있음, register.php는 user_type를 보내주지 않음 
                        $user_type = e($_POST['user_type']); //user_type를 $user_type에 저장
                        $query = "INSERT INTO users (username, email, user_type, password) 
                                          VALUES('$username', '$email', '$user_type', '$password')"; // $(변수명)->users.(이름) 으로 저장하기 위한 명령어
                        mysqli_query($db, $query); //연결된 MySQL에서 $query 명령어 실행
                        $_SESSION['success']  = "New user successfully created!!"; //성공 메세지(create_user.php에서 전송된 것이므로, 새 유저가 생성되었다는 메세지가 나옴)
                        header('location: home.php'); //페이지를 home.php로 이동
                }else{
                        $query = "INSERT INTO users (username, email, user_type, password) 
                                          VALUES('$username', '$email', 'user', '$password')"; //위 $query와 비슷하나 user_type를 user로 고정, admin 불가
                        mysqli_query($db, $query); //위와 같음

                        // 생성된 유저의 id를 $logged_in_user_id에 저장
                        $logged_in_user_id = mysqli_insert_id($db);

                        $_SESSION['user'] = getUserById($logged_in_user_id); // 유저를 세션에 로그인시킴
                        $_SESSION['success']  = "You are now logged in"; //로그인 완료 메세지
                        header('location: index.php'); //페이지를 index.php로 이동
                }
        }
}

// id를 통해 user의 배열값 return
function getUserById($id){
        global $db;
        $query = "SELECT * FROM users WHERE id=" . $id;
        $result = mysqli_query($db, $query);

        $user = mysqli_fetch_assoc($result);
        return $user;
}

// 문자열 값으로 return
function e($val){
        global $db;
        return mysqli_real_escape_string($db, trim($val));
}

//오류 발생 시 오류가 났음을 알리는 함수
function display_error() {
        global $errors;

        if (count($errors) > 0){ //$errors에 값이 존재한다면
                echo '<div class="error">';
                        foreach ($errors as $error){
                                echo $error .'<br>'; //$errors 배열 내의 문자열들을 한 줄씩 추가
                        }
                echo '</div>';
        }
}       

//로그인 상태인지 체크하는 함수
function isLoggedIn()
{
        if (isset($_SESSION['user'])) { 
                return true;
        }else{
                return false;
        }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

// login_btn이 클릭되었다면 login() 호출
if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN USER
function login(){
    global $db, $username, $errors;

    // 값들 전달
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // form이 적절하게 채워졌는가
    if (empty($username)) { //사용자명 미입력 시
            array_push($errors, "Username is required"); //$errors에 "Username is required" 삽입
    }
    if (empty($password)) { //비밀번호 미입력시
            array_push($errors, "Password is required"); //$errors에 "Password is required" 삽입
    }

    // form에 오류가 없다면 로그인 시도
    if (count($errors) == 0) {
            $password = md5($password); //register 때처럼 암호화

            $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
            $results = mysqli_query($db, $query);

            if (mysqli_num_rows($results) == 1) { // 유저를 찾았다면
                    // 이 유저가 어드민인지 일반 유저인지 체크
                    $logged_in_user = mysqli_fetch_assoc($results);
                    if ($logged_in_user['user_type'] == 'admin') {

                            $_SESSION['user'] = $logged_in_user;
                            $_SESSION['success']  = "You are now logged in";
                            header('location: admin/home.php'); //어드민이면 admin/home.php로 이동
                    }else{
                            $_SESSION['user'] = $logged_in_user;
                            $_SESSION['success']  = "You are now logged in";

                            header('location: index.php'); //어드민이 아니라면 index.php로 이동
                    }
            }else {
                    array_push($errors, "Wrong username/password combination"); //유저를 찾지 못했다면 오류
            }
    }
}

function isAdmin()
{
        if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) { //해당 유저가 존재하며, user의 user_type 값이 admin이라면
                return true; //참을 return
        }else{
                return false;
        }
}