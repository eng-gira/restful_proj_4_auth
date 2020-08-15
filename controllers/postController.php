<?php
    include_once '/var/www/html/restful_proj_4_auth/models/Post.php';

    class postController {
        
        public function get_all()
        {
            $all_posts = Post::get_all();

            if($all_posts==0)
            {
                echo json_encode("Could not get posts");
            }
            else 
            {
                echo json_encode($all_posts);
            }
        }

        public function get($id=-1)
        {
            if($id<0) return;
                        
            $post = Post::get($id);
            
            if($post==0)
            {
                echo json_encode("Could not get post");
            }
            else 
            {
                echo json_encode($post);
            }

        }

        public function new()
        {
           
            $data = json_decode(file_get_contents('php://input'));
            $title=  $data->title;
            $body = $data->body;
            $author=  "Unauthorized";

            if(strlen($title) < 1 || strlen($body)<1) return json_encode("Missing input!");

            $new_post_response = Post::new($title, $body, $author);

            if($new_post_response!=0)
            {
                echo json_encode("Post created");
            }
            else
            {
                echo json_encode("An error occurred. Post was not created.");
            }
            
        }

        public function update($id=-1)
        {
            $id = intval($id);
            if($id<0) return;

            $data = json_decode(file_get_contents("php://input"));
            $title = $data->updated_title;
            $body=  $data->updated_body;
            $author = "Unauthorized";

            if(strlen($title) < 1 || strlen($body)<1) return;

            $update_response = Post::update($id, $title, $body, $author);

            if($update_response != 0)
            {
                echo json_encode("Post is updated");
            }
            else
            {
                echo json_encode("An error occurred. Post was not created.");
            }
            
        }

        public function delete($id=-1)
        {
            if($id<0) return;

            $result = Post::delete($id) ? "Post Deleted." : "An error has occurred.";

            echo json_encode($result);
        }
    }
?>