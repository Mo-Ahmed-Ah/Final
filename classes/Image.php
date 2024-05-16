<?php 
class Image{
    public function generate_filename($length   ){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        // $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $random = rand(0,61);
            $randomString .= $characters[$random];
        }
        return $randomString;
    }
    public function crop_image($original_image_name , $cropped_image_name , $max_width , $max_height){
        if(file_exists(($original_image_name))){
            $original_image = imagecreatefromjpeg($original_image_name);
            $original_image_width = imagesx($original_image);
            $original_image_height = imagesy($original_image);

            if ($original_image_height > $original_image_width) {
                // make width equal to the max width 
                $retio = $max_width / $original_image_width;
                $new_width = $max_width;
                $new_height = $original_image_height * $retio;
            }else{
                // make width equal to the max width 
                $retio = $max_height / $original_image_height;
                $new_height = $max_height;
                $new_width = $max_width * $retio;
            }
        }
        // adjust incase max width and height ard different 
        if($max_width != $max_height){
            if($max_height > $max_width){
                if($max_height > $new_height){
                    $adjusment = ($max_height / $new_height);
                }else{
                    $adjusment = ($new_height / $max_height);
                }
                $new_width *=  $adjusment;
                $new_height *=  $adjusment;
            }else{
                if($max_width > $new_width){
                    $adjusment = ($max_width / $new_width);
                }else{
                    $adjusment = ($new_width / $max_width);
                }
                $new_width *=  $adjusment;
                $new_height *=  $adjusment;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image , $original_image , 0 , 0 , 0 , 0 , $new_width , $new_height , $original_image_width , $original_image_height );
        imagedestroy($original_image);

        if($max_width != $max_height){
            if($max_height > $max_width){
                $diff = ($new_height - $max_height);
                if($diff<0){
                    $diff *= -1;
                }
                $y =round($diff /2);
                $x = 0;
            }
            else{
                $diff = ($new_width - $max_height);
                if($diff<0){
                    $diff *= -1;
                }
                $x =round($diff /2);
                $y = 0;
            }
        } else {
            if($new_height > $new_width){
                $diff = ($new_height - $new_width);
                $y =round($diff /2);
                $x = 0;
            }
            else{
                $diff = ($new_width - $new_height);
                $x =round($diff /2);
                $y = 0;
            }
        }

        $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
        imagecopyresampled($new_cropped_image , $new_image , 0 , 0 , $x , $y , $max_width , $max_height , $max_width , $max_height );
        
        imagedestroy($new_image);

        imagejpeg($new_cropped_image ,$cropped_image_name, 90);
        imagedestroy($new_cropped_image);
    }
    // resize image
    public function resize_image($original_image_name , $resized_image_name , $max_width , $max_height){
        if(file_exists(($original_image_name))){
        $original_image = imagecreatefromjpeg($original_image_name);
        $original_image_width = imagesx($original_image);
        $original_image_height = imagesy($original_image);

        // Calculate aspect ratio
        $aspect_ratio = $original_image_width / $original_image_height;

        // Calculate new dimensions while maintaining aspect ratio
        if ($aspect_ratio > 1) {
            // Landscape image
            $new_width = $max_width;
            $new_height = $max_width / $aspect_ratio;
        } else {
            // Portrait or square image
            $new_width = $max_height * $aspect_ratio;
            $new_height = $max_height;
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image , $original_image , 0 , 0 , 0 , 0 , $new_width , $new_height , $original_image_width , $original_image_height );
        imagedestroy($original_image);
        
        imagejpeg($new_image, $resized_image_name, 90);
        imagedestroy($new_image);
    }
    }

    // create thumbnail for cover images
    public function get_thumb_cover($file_name){
        $thumbnail = $file_name . "_cover_thumb_.jpg";
        if(file_exists($thumbnail)){
            return $thumbnail;
        }
        $this->crop_image($file_name, $thumbnail , 1366 ,488);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }else{
            return $file_name;
        }

    }

    // create thumbnail for profile images

    public function get_thumb_profile($file_name){
        $thumbnail = $file_name . "_profile_thumb_.jpg";
        if(file_exists($thumbnail)){
            return $thumbnail;
        }
        $this->crop_image($file_name, $thumbnail , 600 ,600);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }else{
            return $file_name;
        }

    }

    // create thumbnail for post images

    public function get_thumb_post($file_name){
        $thumbnail = $file_name . "_post_thumb_.jpg";
        if(file_exists($thumbnail)){
            return $thumbnail;
        }
        $this->crop_image($file_name, $thumbnail , 600 ,600);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }else{
            return $file_name;
        }

    }
}