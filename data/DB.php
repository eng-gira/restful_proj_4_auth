<?php

    class DB
    {
        protected function connect()
        {
            $conn = new mysqli('localhost', 'root', 'root1234', 'restful_4');

            return $conn;
        }
    }

?>