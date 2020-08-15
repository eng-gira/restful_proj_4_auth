<?php
    include_once '/var/www/html/restful_proj_4_auth/data/DB.php';

    class Post extends DB
    {
        public static function get_all()
        {
            $myCon = self::connect();

            $sql_get_all_posts = 'SELECT * FROM posts';

            $result = $myCon->query($sql_get_all_posts);

            if($result->num_rows>0)
            {
                $posts=array();
                while($row=$result->fetch_assoc())
                {
                    $posts[count($posts)]= [
                        'id'=>$row['id'],
                        'title'=>$row['title'], 
                        'body'=>$row['body']
                    ];
                }

                return $posts;
            }

            else
            {
                return 0;
            }
        }

        public static function get($id)
        {
            $myCon = self::connect();
            if($myCon->connect_error) {return 'connection failed: ' . $myCon->connect_error;}
           
            $selection_sql = 'SELECT * FROM posts WHERE id = ?';// . intval($id);

            if($stmt=$myCon->prepare($selection_sql))
            {
                $stmt->bind_param('i', $id);

                if($stmt->execute())
                {
                    $stmt->store_result();

                    if($stmt->num_rows>0)
                    {
                        $id = -1;
                        $title='';
                        $body='';
                        $author=-2;
                        $created_at='';

                        $stmt->bind_result($id, $title, $body, $author, $created_at);
                        $stmt->fetch();

                        /**
                         * @todo: get topics names not ids
                         */

                        $post = ['id'=>$id, 'title'=>$title, 'body'=>$body, 'author'
                        => $author, 'created_at'=>$created_at];

                        return $post;
                    }
                }
            }

            return 0;
        }

        public static function new($title, $body, $author)
        {
            $myCon = self::connect();

            $insertion_sql = 'INSERT INTO posts (title, body, author) VALUES 
            (?, ?, ?)';
            
            if($stmt=$myCon->prepare($insertion_sql))
            {
                $stmt->bind_param('sss', $title, $body, $author);

                if($stmt->execute())
                {
                    return 1;
                }
            }

            return 0;
        }

        public static function update($id, $title, $body, $author)
        {
            $myCon = self::connect();

            $update_sql = 'UPDATE posts SET title = ?, body = ?, author = ? WHERE id 
            = ?';
            
            if($stmt=$myCon->prepare($update_sql))
            {
                $stmt->bind_param('sssi', $title, $body, $author, $id);

                if($stmt->execute())
                {
                    return 1;
                }
            }

            return 0;
        }

  
        public static function delete($id)
        {
            $myCon = self::connect();

            $deletion_sql = 'DELETE FROM posts WHERE id = ?';
            
            if($stmt=$myCon->prepare($deletion_sql))
            {
                $stmt->bind_param('i', $id);

                if($stmt->execute())
                {
                    return 1;
                }
            }

            return 0;   
        }
    }

?>