<?php
/**
 * 
 * This software is distributed under the GNU LGPL v3.0 license.
 * @author Gemorroj
 * @copyright 2008-2010 http://wapinet.ru
 * @license http://www.gnu.org/licenses/lgpl-3.0.txt
 * @link http://wapinet.ru/gmanager/
 * @version 0.7.4 beta
 * 
 * PHP version >= 5.2.1
 * 
 */


class HTTP
{
    static private $_stat   = array();
    static private $_id     = array();


    public function __construct ()
    {
        Config::$sysType = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? 'WIN' : 'NIX';
    }


    /**
     * Valid chmod
     * 
     * @param mixed $chmod
     * @return int
     */
    private function _chmoder ($chmod)
    {
        if (!is_int($chmod)) {
            $strlen = strlen($chmod);
            
            if (($strlen != 3 && $strlen != 4) || !is_numeric($chmod)) {
                return false;
            } else if ($strlen == 3) {
                $chmod = '0' . $chmod;
            }
            $chmod = octdec($chmod);
        }
        return $chmod;
    }


    /**
     * mkdir
     * 
     * @param string $dir
     * @param mixed $chmod
     * @return bool
     */
    public function mkdir ($dir, $chmod = 0755)
    {
        return @mkdir($dir, $this->_chmoder($chmod), true);
    }


    /**
     * chmod
     * 
     * @param string $file
     * @param mixed $chmod
     * @return bool
     */
    public function chmod ($file, $chmod = 0755)
    {
        /*
        if (Config::$sysType == 'WIN') {
            trigger_error($GLOBALS['lng']['win_chmod']);
            return false;
        }
        */

        return @chmod($file, $this->_chmoder($chmod));
    }


    /**
     * file_get_contents
     * 
     * @param string $file
     * @return string
     */
    public function file_get_contents ($file)
    {
        return file_get_contents($file);
    }


    /**
     * file_put_contents
     * 
     * @param string $file
     * @param string $data
     * @return int (0 or 1)
     */
    public function file_put_contents ($file, $data = '')
    {
        if (!$f = @fopen($file, 'a')) {
            return 0;
        }

        ftruncate($f, 0);

        if ($data != '') {
            fputs($f, $data);
        }

        fclose($f);

        return 1;
    }


    /**
     * is_dir
     * 
     * @param string $str
     * @return bool
     */
    public function is_dir ($str)
    {
        return is_dir($str);
    }


    /**
     * is_file
     * 
     * @param string $str
     * @return bool
     */
    public function is_file ($str)
    {
        return is_file($str);
    }


    /**
     * is_link
     * 
     * @param string $str
     * @return bool
     */
    public function is_link ($str)
    {
        return is_link($str);
    }


    /**
     * is_readable
     * 
     * @param string $str
     * @return bool
     */
    public function is_readable ($str)
    {
        return is_readable($str);
    }


    /**
     * is_writable
     * 
     * @param string $str
     * @return bool
     */
    public function is_writable ($str)
    {
        return is_writable($str);
    }


    /**
     * stat
     * 
     * @param string $str
     * @return array
     */
    public function stat ($str)
    {
        if (!isset(self::$_stat[$str])) {
            self::$_stat[$str] = @stat($str);
        }

        if (isset(self::$_id[self::$_stat[$str]['uid']])) {
            self::$_stat[$str]['owner'] = self::$_id[self::$_stat[$str]['uid']];
        } else {
            self::$_stat[$str]['owner'] = Gmanager::id2name(self::$_stat[$str]['uid'], Config::$sysType);
        }

        if (isset(self::$_id[self::$_stat[$str]['gid']])) {
            self::$_stat[$str]['group'] = self::$_id[self::$_stat[$str]['gid']];
        } else {
            self::$_stat[$str]['group'] = Gmanager::id2name(self::$_stat[$str]['gid'], Config::$sysType);
        }

        return self::$_stat[$str];
    }


    /**
     * fileperms
     * 
     * @param string $str
     * @return int
     */
    public function fileperms ($str)
    {
        if (!isset(self::$_stat[$str][2])) {
            self::$_stat[$str] = @stat($str);
        }
        return self::$_stat[$str][2];
    }


    /**
     * filesize
     * 
     * @param string $file
     * @return int
     */
    public function filesize ($file)
    {
        if (!isset(self::$_stat[$file][7])) {
            self::$_stat[$file] = stat($file);
        }
        return self::$_stat[$file][7];
    }


    /**
     * filemtime
     * 
     * @param string $str
     * @return int
     */
    public function filemtime ($str)
    {
        if (!isset(self::$_stat[$str][9])) {
            self::$_stat[$str] = stat($str);
        }
        return self::$_stat[$str][9];
    }


    /**
     * readlink
     * 
     * @param string $link
     * @return array
     */
    public function readlink ($link)
    {
        chdir(Config::$current);
        return array(basename($link), realpath(readlink($link)));
    }


    /**
     * file_exists
     * 
     * @param string $str
     * @return bool
     */
    public function file_exists ($str)
    {
        return file_exists($str);
    }


    /**
     * unlink
     * 
     * @param string $file
     * @return bool
     */
    public function unlink ($file)
    {
        return unlink($file);
    }


    /**
     * rename
     * 
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function rename ($from, $to)
    {
        return rename($from, $to);
    }


    /**
     * copy
     * 
     * @param string $from
     * @param string $to
     * @param mixed  $chmod
     * @return bool
     */
    public function copy ($from, $to, $chmod = 0644)
    {
        if ($result = @copy($from, $to)) {
            $this->chmod($to, $chmod);
        }
        return $result;
    }


    /**
     * rmdir
     * 
     * @param string $dir
     * @return bool
     */
    public function rmdir ($dir)
    {
        return is_dir($dir) ? rmdir($dir) : true;
    }


    /**
     * getcwd
     * 
     * @return string
     */
    public function getcwd ()
    {
        return getcwd();
    }


    /**
     * iterator
     * 
     * @param string $dir
     * @return array
     */
    public function iterator ($dir)
    {
        return array_diff(scandir($dir, 0), array('.', '..'));
    }
}

?>
