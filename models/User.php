<?php
    include '../data/DB.php';

    class User extends DB
    {
        public static function new($username, $pw)
        {
            $myCon = self::connect();
            
            $insertion_sql = 'INSERT INTO users (username, pw) VALUES (?, ?)';

            if($stmt=$myCon->prepare($insertion_sql))
            {
                $stmt->bind_param('ss', $username, $pw);
                
                if($stmt->execute())
                {
                    return 1;
                }
            }
            
            return 0;
        }

        public function username_exists($username)
        {
            $myCon = self::connect();

            $sql = 'SELECT id FROM users WHERE username = ?';

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param('s', $username);
                if($stmt->execute())
                {
                    $stmt->store_result();
                 
                    if($stmt->num_rows > 0)
                    {
                        return 1;    
                    }
                }
            }

            return 0;
        }

        public static function authenticate($username, $pw)
        {
            $myCon = self::connect();

            $selection_sql = 'SELECT id FROM users WHERE username = ? AND pw = ?';

            if($stmt=$myCon->prepare($selection_sql))
            {
                $stmt->bind_param('ss', $username, $pw);
                if($stmt->execute())
                {
                    $stmt->store_result();
                 
                    if($stmt->num_rows > 0)
                    {
                        return 1;    
                    }
                }
            }

            return 0;
        }
    }

?>  