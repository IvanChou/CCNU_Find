<?php
/**
 * Author: xworm
 * Date: 13-3-21
 * Time: 下午9:01
 */

class Conf extends Model {
    public function update_admin($old_name, $new_name, $password) {
        if (!$old_name) return false;

        $file_name = APP_PATH . "config/ccnu.php";
        $fp=fopen($file_name,'r+');
        $file = "";
        while(!feof($fp))
        {
            $buffer=fgets($fp,255);
            if(preg_match('/^\s+\'' . $old_name . '\'\s\=\>.*$/',$buffer,$tmps)){
                $tmp = $tmps[0];
                if($new_name && $old_name!=$new_name) $tmp = str_replace($old_name,$new_name,$tmp);
                if($password) $tmp = preg_replace('/\".*\"/','"'.$password.'"',$tmp);

                $file .= $tmp . "\n";
            }else{
                $file .= $buffer;
            };
        }
        fseek($fp, 0);
        fwrite($fp,$file);
        fclose($fp);

        return true;
    }
}