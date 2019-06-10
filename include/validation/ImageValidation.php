<?php
class ImageValidation extends Validation
{
    public function __construct()
    {

    }

    public function checkImageFile($files, $new_img) {
        if (isset($files) && isset($new_img) !== TRUE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function checkImageSize($img_size) {
        if ($img_size >= 2097152) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function checkImageEmpty($img_tmp, $img_name) {
        if (is_uploaded_file($img_tmp) !== TRUE || $img_name === '') {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function checkImageExt($tmp_name, $new_name) {
        switch (exif_imagetype($tmp_name)){
            case IMAGETYPE_JPEG:
                $new_name .= '.jpg';
                break;
            case IMAGETYPE_PNG:
                $new_name .= '.png';
                break;
            default:
                return FALSE;
        }
        return $new_name;
    }


    public function createRandFileName() {
        $new_name = date("YmdHis"); //ベースとなるファイル名は日付
        $new_name .= mt_rand(); //ランダムな数字も追加

        return $new_name;
    }


    public function uploadImageFile($new_name, $tmp_name) {
        global $errors;
        $img_path = './images/' . basename($new_name);
        // 自分のフォルダに移動
        if(move_uploaded_file($tmp_name, $img_path)){
            return $img_path. 'のアップロードに成功しました';
        }else {
            $errors[] = 'アップロードに失敗しました';
        }
    }
}