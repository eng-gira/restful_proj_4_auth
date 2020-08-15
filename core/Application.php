<?php
    include '/var/www/html/restful_proj_1/controllers/defaultController.php';
    include_once '/var/www/html/restful_proj_4_auth/jwt/JWT.php';
    include_once '/var/www/html/restful_proj_4_auth/models/User.php';

    use Firebase\JWT\JWT;

    class Application 
    {
        private $controller = 'defaultController';
        private $action = 'get_end_points';
        private $params = array();
        private $auth_controllers = ['postController', 'commentController'];

        public function __construct()
        {
            $extracted = $this->extract_end_point();

            // echo 'controller: ' . $this->controller . ', action: ' . $this->action . '<br>';
            // echo 'extract_end_points: ' . $extracted . '<br>';

            if(file_exists('../controllers/'. $this->controller .'.php'))
            {
                // echo 'File exists<br>';

                include '../controllers/'. $this->controller. '.php';

                if(method_exists($this->controller, $this->action))
                {
                    $green_light = 1;
                    
                    if($this->controller == 'postController')
                    {
                        //check for the auth token
                        //1: getting all headers
                        $headers = apache_request_headers();

                        //2: check
                        if(isset($headers['Authorization']))
                        {
                            $authorization = $headers['Authorization'];
                            $skip = 'Bearer ';

                            $token = substr($authorization, strlen($skip));
                           
                            echo 'here...';

                            $payload = '';
                            try
                            {
                                $payload = JWT::decode($token, 'ma_key', ['HS256']);
                            }
                            catch(Exception $e)
                            {
                                echo json_encode(
                                    array('message' => 'Username not set. ' . $e->getMessage())
                                );
                                return;
                            }

                            if(User::username_exists($payload->username) == 1)
                            {
                                echo $payload->username;
                                $green_light = 1;
                            }
                            else
                            {
                                $green_light = 0;
                            }
                        }
                        else
                        {
                            $green_light = 0;
                        }
                    }

                    if($green_light == 1) 
                    {
                        call_user_func_array([$this->controller, $this->action], $this->params);
                    }
                        
                }
            }
            else 
            {
                call_user_func_array(['defaultController', 'wrong_request'], []);
            }
        }  

        private function extract_end_point()
        {
            $uri = $_SERVER['REQUEST_URI'];

            $link = trim($uri, '/');
            
            $index = strpos($link, 'public') + strlen('public');

            $requested_end_point = substr($link, $index);

            // echo 'From extract_end_point() -> Requested end point: ' . $requested_end_point . '<br>';

            if(!empty($requested_end_point))
            {
                $elements = substr($requested_end_point, 0, 1) == '/' ? 
                explode('/', substr($requested_end_point,1)) : 
                explode('/', $requested_end_point);

                // echo 'From extract_end_point() -> controller: ' . $elements[0] . ', action: ' . $elements[1] . '<br>';
                $this->controller=isset($elements[0])? $elements[0] . "Controller" : 'defaultController';
                $this->action=isset($elements[1])? $elements[1] : 'get_end_points';
                unset($elements[0], $elements[1]);
                $this->params = !empty($elements) ? array_values($elements) : [];

                return '1';

            }

            return '0';

        }
    }

?>