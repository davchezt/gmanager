<?php
// кодировка UTF-8
/**
 * 
 * This software is distributed under the GNU LGPL v3.0 license.
 * @author Gemorroj
 * @copyright 2008-2009 http://wapinet.ru
 * @license http://www.gnu.org/licenses/lgpl-3.0.txt
 * @link http://wapinet.ru/gmanager/
 * @version 0.7 alpha
 * 
 * PHP version >= 5.2.1
 * 
 */


$mode = new http;
$class = 'http';

class http
{

    public function mkdir($dir = '', $chmod = '0755')
    {
    	settype($chmod, 'string');
    	$strlen = strlen($chmod);
		if(!ctype_digit($chmod) || ($strlen != 3 && $strlen != 4)){
    		// return false;
    		$chmod = '0755';
   		}
   		if($strlen == 3){
    		$chmod = '0' . $chmod;
   		}

   		$chmod = decoct(octdec(intval($chmod)));
        $result = mkdir($dir, $chmod);
        $this->chmod($dir, $chmod);
        return $result;
    }

    public function chmod($file = '', $chmod = '0755')
    {
    	/*
		$win = PHP_OS;
    	if($win[0] . $win[1] . $win[2] == 'WIN'){
    		trigger_error($GLOBALS['lng']['win_chmod']);
    		return false;
   		}
   		*/

    	settype($chmod, 'string');
    	$strlen = strlen($chmod);
    	if(!ctype_digit($chmod) || ($strlen != 3 && $strlen != 4)){
    		return false;
   		}

    	if($strlen == 3){
    		$chmod = '0' . $chmod;
   		}
  		 
        return chmod($file, octdec(intval($chmod)));
    }

	public function file_get_contents($str = ''){
		return file_get_contents($str);
	}

	public function file_put_contents($file = '', $data = ''){
		if(!$f = fopen($file, 'a')){
			return 0;
		}

		ftruncate($f, 0);

		if($data != ''){
			fputs($f, $data);
		}

		fclose($f);

		return 1;
	}

	public function is_dir($str = ''){
		return is_dir($str);
	}

	public function is_file($str = ''){
		return is_file($str);
	}

	public function is_link($str = ''){
		return is_link($str);
	}

	public function is_readable($str = ''){
		return is_readable($str);
	}

	public function filesize($str = ''){
		return sprintf('%u', filesize($str));
	}

	public function file_exists($str = ''){
		return file_exists($str);
	}

	public function filemtime($str = ''){
		return filemtime($str);
	}

	public function unlink($str = ''){
		return unlink($str);
	}

	public function rename($from = '', $to = ''){
		return rename($from, $to);
	}

	public function copy($from = '', $to = '', $chmod = '0644'){
		if($result = copy($from, $to)){
			$this->chmod($to, $chmod);
		}
		return $result;
	}

	public function rmdir($str = ''){
		return rmdir($str);
	}

	public function fileperms($str = ''){
		return fileperms($str);
	}

	public function getcwd(){
		return getcwd();
	}

	public function iterator($str = ''){
		$tmp = array();

		$dir = new DirectoryIterator($str);
			foreach ($dir as $fileinfo) {
    			if (!$fileinfo->isDot()) {
        			$tmp[] = $fileinfo->getFilename();
    			}
			}
			
		return $tmp;
	}
}

?>