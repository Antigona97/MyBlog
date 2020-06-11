<?php

class File  {

    /**
     * Create Date Coded Path
     * @access  public
     * @return  string
     * @since   1.0.0
     * @author  nbe
     */
    public static function createDateCodedPath(){
        $date       = date('Y:m:d', time());
        $code       = explode(':', $date);
        $coded_path = '';

        foreach($code as $dir)
            $coded_path .= "$dir/";

        return (string) $coded_path;
    }


    /**
     * Create Folder
     * @access  private
     * @param   string  $dir
     * @param   int     $mode
     * @return  bool
     * @since   1.0.0
     * @author  nbe
     */
    private static function createFolder($dir, $mode = 0777){
        if (!file_exists($dir))
            return (boolean) mkdir($dir, $mode, true);
        else
            return true;
    }

    /**
     * Create Img Thumbnail
     * @access  private
     * @param   string  $img
     * @param   string  $thumb_path
     * @param   int     $width
     * @param   int     $height
     * @return  bool
     * @since   1.0.0
     * @author  nbe
     */
    private static function createImgThumbnail($img, $thumb_path, $width, $height) {
        if (!$width || !$height)
            return false;

        list($img_width, $img_height, $img_type) = getimagesize($img);


        switch($img_type){
            case IMAGETYPE_GIF:
                $gd_img = imagecreatefromgif($img);
                break;
            case IMAGETYPE_JPEG:
                $gd_img = imagecreatefromjpeg($img);
                break;
            case IMAGETYPE_PNG:
                $gd_img = imagecreatefrompng($img);
                break;
            default:
                return false;
        }

        $thumb_width='200';
        $thumb_height='200';

        $gd_thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        self::addWatermarkImage($thumb_path);
        imagecopyresampled($gd_thumb, $gd_img, 0, 0, 0, 0, $thumb_width, $thumb_height, $img_width, $img_height);
        imagejpeg($gd_thumb, $thumb_path, 90);

        imagedestroy($gd_img);
        imagedestroy($gd_thumb);

        return true;
    }

    public static function addWatermarkImage($destination){
        $fileType = pathinfo($destination,PATHINFO_EXTENSION);
            // Load the stamp and the photo to apply the watermark to
                $watermarkImagePath='uploads/MyBlog.png';

                $watermarkImg = imagecreatefrompng($watermarkImagePath);

                switch($fileType){
                    case 'jpg':
                        $im = imagecreatefromjpeg($destination);
                        break;
                    case 'jpeg':
                        $im = imagecreatefromjpeg($destination);
                        break;
                    case 'png':
                        $im = imagecreatefrompng($destination);
                        break;
                    default:
                        $im = imagecreatefromjpeg($destination);
                }

                // Set the margins for the watermark
                $marge_right = 10;
                $marge_bottom = 10;

                // Get the height/width of the watermark image
                $sx = imagesx($watermarkImg);
                $sy = imagesy($watermarkImg);

                // Copy the watermark image onto our photo using the margin offsets and
                // the photo width to calculate the positioning of the watermark.
                imagecopy($im, $watermarkImg, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermarkImg), imagesy($watermarkImg));


                // Save image and free memory
                imagejpeg($im, $destination, 90);
                imagedestroy($im);
    }

    /**
     * Get type of an image
     * @access  private
     * @param   string  $tempImgFile
     * @return  string
     * @since   1.0.0
     * @author  nbe
     */
    private static function getImgType($tempImgFile){
        list( , , $tempImgFile) = getimagesize($tempImgFile);
        switch($tempImgFile){
            case IMAGETYPE_GIF:
                return '.gif';
            case IMAGETYPE_ICO:
                return '.ico';
            case IMAGETYPE_JPEG:
                return '.jpg';
            case IMAGETYPE_PNG:
                return '.png';
            default:
                return false;
        }
    }

    /**
     * Move Uploaded File
     * @access  public
     * @param   string  $file
     * @param   string  $destination
     * @return  bool
     * @since   1.0.0
     * @author  nbe
     */
    public static function moveUploadedFile($file, $destination){
        if(move_uploaded_file($file, $destination)){
            return (boolean) self::addWatermarkImage($destination);
        }
    }

    /**
     * Delete file
     * @access  public
     * @param   string  $file
     * @return  bool
     * @since   1.0.0
     * @author  nbe
     */
    public static function delete($file) {
        return (boolean) unlink($file);
    }

    /**
     * Upload Img
     * @access  public
     * @param   array  $fileArray
     * @param   string  $path
     * @param   array   $thumb
     * @return  mixed
     * @since   1.0.0
     * @author  nbe
     */
    public static function uploadImg($fileArray, $path = '', array $thumb = array(IMAGE_THUMB_WIDTH, IMAGE_THUMB_HEIGHT)) {

        $temp_img_id    = $fileArray['name'];
        $temp_img_file  = $fileArray['tmp_name'];
        $temp_img_type  = '.'.explode('.', $temp_img_id)[1];
        $temp_img_size  = $fileArray['size'];

        $img_name   = time().'-'.rand(100,9999);
        $img_type   = self::getImgType($temp_img_file);

        if (!$img_type && !$temp_img_type)
            $img_type   = IMAGE_DEFAULT_EXT;
        else
            $img_type   = $temp_img_type;

        $inner_path     = implode('/', explode('/', $path)).'/';
        $coded_path     = self::createDateCodedPath();
        $img_dir        = IMAGE_UPLOADS_PATH."{$inner_path}{$coded_path}";

        $img_path       = "{$img_dir}{$img_name}{$img_type}";
        $thumb_path     = "{$img_dir}{$img_name}".IMAGE_THUMB_EXT."{$img_type}";

        // TODO: ForLoop if more then one thumb-size
        if (!empty($thumb)) {
            $thumb_height   = $thumb[1];
            $thumb_width    = $thumb[0];
        }

        if (!self::createFolder($img_dir))
            $error['upload']    = _('Missing User-Rights');
        if (!self::moveUploadedFile($temp_img_file, $img_path))
            $error['upload']    = _('Error while uploading file');
        if (empty($thumb) && !self::createImgThumbnail($img_path, $thumb_path, $thumb_width, $thumb_height) || !empty($thumb) && !self::createImgThumbnail($img_path, $thumb_path, $thumb_width, $thumb_height))
            $error['upload']    = _('Error while generating Thumbnails');

        return array('name' => $temp_img_id, 'image' => $img_path, 'thumb' => $thumb_path, 'size' => $temp_img_size);
    }


}