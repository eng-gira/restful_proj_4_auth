<?php
    include_once '/var/www/html/restful_proj_4_auth/JWT.php';
    include_once '/var/www/html/restful_proj_4_auth/models/User.php';

    use Firebase\JWT\JWT;

    class authController
    {
        public function register()
        {
            $data = json_decode(file_get_contents('php://input'));
            $username = $data->username;
            $pw = $data->pw;

            if(strlen($username) < 1 || strlen($pw) < 1)
            {
                echo json_encode('Missing input!');
                return;
            }

            if(User::username_exists($username)==1)
            {
                echo json_encode(
                    array('message' => 'Username already exists')
                );
                return;
            }

            $reg_response = User::new($username, $pw) == 1 ? 'User registered' 
                : 'Failed to register user';
            
            echo json_encode(
                array('message' => $reg_response)
            );
        }

        public function login()
        {
            $data = json_decode(file_get_contents('php://input'));
            $username = $data->username;
            $pw = $data->pw;

            if(strlen($username) < 1 || strlen($pw)<1)
            {
                echo json_encode('Missing input!');
                return;
            }

            $auth = User::authenticate($username, $pw);

            if($auth == 1)
            {
                echo json_encode(
                    array('TOKEN' => JWT::encode([
                        'iat' => time(),
                        'iss' => 'localhost',
                        'exp' => time() + (60) // 1 minute
                        ,
                        'username' => $username
                    ], 'ma_key'))
                );
            }
            else
            {
                echo json_encode(
                    array('message' => 'Wrong username or password')
                );
            }
            
        }
    }

?>