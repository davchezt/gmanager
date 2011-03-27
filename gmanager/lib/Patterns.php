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


class Patterns
{
    const Htaccess      = 'Htaccess';
    const HTML          = 'HTML';
    const MySQL         = 'MySQL';
    const PHP           = 'PHP';
    const PostgreSQL    = 'PostgreSQL';
    const SQLite        = 'SQLite';
    const WML           = 'WML';
    const XHTML         = 'XHTML';


    private $_patterns = array();


    /**
     * Get patterns
     *
     * @param array $patterns
     * @return $this
     */
    public function set ($patterns = array())
    {
        foreach ($patterns as $pattern) {
            $tmp = 'Patterns_' . $pattern;
            $this->_patterns[$pattern] = $tmp::get();
        }

        return $this;
    }


    /**
     * Get pattern
     *
     * @param string $pattern
     * @param string $name
     * @return string
     */
    public function getPattern ($pattern = null, $name = null)
    {
        if (isset($this->_patterns[$pattern][$name])) {
            return $this->_patterns[$pattern][$name];
        }

        return null;
    }


    /**
     * Get patterns
     *
     * @return array
     */
    public function getArray ()
    {
        return $this->_patterns;
    }


    /**
     * Get patterns
     *
     * @return string
     */
    public function getOptions ()
    {
        $out = '';
        foreach ($this->_patterns as $key => $val) {
            $out .= '<optgroup label="' . htmlspecialchars($key) . '">';
            foreach ($val as $k => $v) {
                $out .= '<option value="' . rawurlencode($v) . '">' . htmlspecialchars($k, ENT_NOQUOTES) . '</option>';
            }
            $out .= '</optgroup>';
        }
        return $out;
    }
}

?>