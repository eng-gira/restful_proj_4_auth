<?php
    class defaultController
    {
        public function index()
        {
            echo json_encode(['message'=>'@defaultController->index()']);
        }
        public function get_end_points()
        {
            $array_of_end_points = ['GET REQUEST: post/get_all', 
            'GET REQUEST: post/get/$id', 'POST REQUEST: post/new (AUTH) $_POST[$title], 
            $_POST[$topics], $_POST[$body]',
            'POST REQUEST: post/update/$id (AUTH) $_POST[$title], $_POST[$topics], 
            $_POST[$body]', 'GET REQUEST: post/delete/$id (AUTH)'];

            return json_encode($array_of_end_points);
        }

        public function wrong_request($error_cause = 'Wrong request')
        {
            if(strlen($error_cause)>1)
            {
                echo $error_cause . '<br>';
            }

            echo 'Valid end points: ';
            $array_of_end_points = ['GET REQUEST: post/get_all', 
            'GET REQUEST: post/get/$id', 'POST REQUEST: post/new (AUTH) $_POST[$title], 
            $_POST[$topics], $_POST[$body]',
            'POST REQUEST: post/update/$id (AUTH) $_POST[$title], $_POST[$topics], 
            $_POST[$body]', 'GET REQUEST: post/delete/$id (AUTH)'];

            echo json_encode($array_of_end_points);        }
    }
?>