<?php 
class Image{
    public function generate_filename($length) {
        if ($length < 1) {
            $length = 1;
        }
        
        $bytes = random_bytes($length);
        $filename = bin2hex($bytes);

        return substr($filename, 0, $length);
    }
    public function crop_image($original_image_name, $cropped_image_name, $desired_width, $desired_height) {
        if (!file_exists($original_image_name)) {
            return false;
        }

        $original_image = imagecreatefromjpeg($original_image_name);
        $original_width = imagesx($original_image);
        $original_height = imagesy($original_image);

        $aspect_ratio = $original_width / $original_height;

        if ($desired_width / $desired_height > $aspect_ratio) {
            $new_width = $desired_height * $aspect_ratio;
            $new_height = $desired_height;
        } else {
            $new_width = $desired_width;
            $new_height = $desired_width / $aspect_ratio;
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        imagedestroy($original_image);

        $x = ($new_width - $desired_width) / 2;
        $y = ($new_height - $desired_height) / 2;

        $cropped_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopy($cropped_image, $new_image, 0, 0, $x, $y, $desired_width, $desired_height);

        imagejpeg($cropped_image, $cropped_image_name, 90);

        imagedestroy($cropped_image);
        imagedestroy($new_image);

        return true;
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