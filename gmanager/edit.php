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


if (isset($_POST['get'])) {
    header('Location: http://' . str_replace(array('\\', '//'), '/', $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/change.php?get=' . rawurlencode($_GET['c'] . ($_GET['f'] ? '&f=' . $_GET['f'] : ''))));
    exit;
}

require 'functions.php';

$charset = array();
$full_charset = '';

if($_GET['charset']){
list($charset[0], $charset[1],) = encoding('', $_GET['charset']);
$full_charset = 'charset=' . htmlspecialchars($charset[0], ENT_COMPAT, 'UTF-8') . '&amp;';
}

$current = c($_SERVER['QUERY_STRING'], /*rawurlencode(*/$_GET['c']/*)*/);
//$current = c($_SERVER['QUERY_STRING'], rawurlencode($_GET['c']));
$h_current = htmlspecialchars($current, ENT_COMPAT);
$r_current = str_replace('%2F', '/', rawurlencode($current));

send_header($_SERVER['HTTP_USER_AGENT']);

echo str_replace('%dir%', $h_current, $top) . '
<div class="w2">
' . $lng['title_edit'] . '<br/>
</div>
' . this($current);

$type = get_type($h_current);


switch ($_GET['go']) {
    default:

        if (!$mode->is_file($current)) {
            echo report($lng['not_found'], true);
            break;
        }


        if ($type == 'ZIP' || $type == 'JAR') {
            $content = edit_zip_file($current, $_GET['f']);
            $content['text'] = htmlspecialchars($content['text'], ENT_NOQUOTES);
            $f = '&amp;f=' . $_GET['f'];
        } else {
            $content['text'] = htmlspecialchars($mode->file_get_contents($current), ENT_NOQUOTES);
            $content['size'] = file_size($current, true);
            $content['lines'] = sizeof(explode("\n", $content['text']));
            $f = '';
        }

        if ($charset) {
            $content['text'] = iconv($charset[0], $charset[1], $content['text']);
        }


if(get_class($mode) == 'http' && $path = iconv_substr(realpath($current), iconv_strlen($_SERVER['DOCUMENT_ROOT']))){
$http = '<div class="rb">
<a href="http://' . $_SERVER['HTTP_HOST'] . str_replace('\\', '/', $path).'">'.$lng['look'].'</a><br/>
</div>';
}
else{
$http = '';
}


echo '<div class="input">
' . $lng['sz'] . ': ' . $content['size'] . '<br/>
Строк: ' . $content['lines'] . '
<form action="edit.php?go=save&amp;c=' . $r_current . $f . '" method="post">
<div>
<textarea name="text" rows="18" cols="64" wrap="off">' . $content['text'] . '</textarea>
<br/>
<input type="submit" value="' . $lng['save'] . '"/>
<select name="charset">
<option value="utf-8">utf-8</option>
<option value="windows-1251"'.($charset[1] == 'windows-1251'? ' selected="selected"' : '').'>windows-1251</option>
<option value="iso-8859-1"'.($charset[1] == 'iso-8859-1'? ' selected="selected"' : '').'>iso-8859-1</option>
<option value="cp866"'.($charset[1] == 'cp866'? ' selected="selected"' : '').'>cp866</option>
<option value="koi8-r"'.($charset[1] == 'koi8-r'? ' selected="selected"' : '').'>koi8-r</option>
</select><br/>
' . $lng['chmod'] . ' <input onkeypress="return number(event)" type="text" name="chmod" value="' . look_chmod($current) . '" size="4" maxlength="4" style="width:28pt;"/><br/>
<input type="submit" name="get" value="' . $lng['get'] . '"/>
</div>
</form>
</div>
<div class="input">
<form action="edit.php?go=replace&amp;c=' . $r_current . $f . '" method="post">
<div>
' . $lng['replace_from'] . '<br/>
<input type="text" name="from" style="width:128pt;"/>' . $lng['replace_to'] . '<input type="text" name="to" style="width:128pt;"/><br/>
<input type="checkbox" name="regexp" value="1"/>' . $lng['regexp'] . '<br/>
<input type="submit" value="' . $lng['replace'] . '"/>
</div>
</form>
</div>
'.$http.'
<div class="rb">
<a href="edit.php?c=' . $r_current . $f . '&amp;' . $full_charset . 'go=syntax">' . $lng['syntax'] . '</a><br/>
</div>';

if ($type != 'ZIP' && $type != 'JAR' && extension_loaded('xml')) {
echo '<div class="rb">
<a href="edit.php?c=' . $r_current . '&amp;' . $full_charset . 'go=validator">' . $lng['validator'] . '</a><br/>
</div>';
}

echo '<div class="rb">
' . $lng['charset'] . '
<form action="edit.php?" method="get" style="padding:0; margin:0;">
<div>
<input type="hidden" name="c" value="' . $r_current . '"/>
<input type="hidden" name="f" value="' . $_GET['f'] . '"/>
<select name="charset">
<option value="">'.$lng['charset_no'].'</option>
<optgroup label="UTF-8">
<option value="utf-8 -&gt; windows-1251"'.($_GET['charset'] == 'utf-8 -> windows-1251' ? ' selected="selected"' : '').'>utf-8 -&gt; windows-1251</option>
<option value="utf-8 -&gt; iso-8859-1"'.($_GET['charset'] == 'utf-8 -> iso-8859-1' ? ' selected="selected"' : '').'>utf-8 -&gt; iso-8859-1</option>
<option value="utf-8 -&gt; cp866"'.($_GET['charset'] == 'utf-8 -> cp866' ? ' selected="selected"' : '').'>utf-8 -&gt; cp866</option>
<option value="utf-8 -&gt; koi8-r"'.($_GET['charset'] == 'utf-8 -> koi8-r' ? ' selected="selected"' : '').'>utf-8 -&gt; koi8-r</option>
</optgroup>
<optgroup label="Windows-1251">
<option value="windows-1251 -&gt; utf-8"'.($_GET['charset'] == 'windows-1251 -> utf-8' ? ' selected="selected"' : '').'>windows-1251 -&gt; utf-8</option>
<option value="windows-1251 -&gt; iso-8859-1"'.($_GET['charset'] == 'windows-1251 -> iso-8859-1' ? ' selected="selected"' : '').'>windows-1251 -&gt; iso-8859-1</option>
<option value="windows-1251 -&gt; cp866"'.($_GET['charset'] == 'windows-1251 -> cp866' ? ' selected="selected"' : '').'>windows-1251 -&gt; cp866</option>
<option value="windows-1251 -&gt; koi8-r"'.($_GET['charset'] == 'windows-1251 -> koi8-r' ? ' selected="selected"' : '').'>windows-1251 -&gt; koi8-r</option>
</optgroup>
<optgroup label="ISO-8859-1">
<option value="iso-8859-1 -&gt; utf-8"'.($_GET['charset'] == 'iso-8859-1 -> utf-8' ? ' selected="selected"' : '').'>iso-8859-1 -&gt; utf-8</option>
<option value="iso-8859-1 -&gt; windows-1251"'.($_GET['charset'] == 'iso-8859-1 -> windows-1251' ? ' selected="selected"' : '').'>iso-8859-1 -&gt; windows-1251</option>
<option value="iso-8859-1 -&gt; cp866"'.($_GET['charset'] == 'iso-8859-1 -> cp866' ? ' selected="selected"' : '').'>iso-8859-1 -&gt; cp866</option>
<option value="iso-8859-1 -&gt; koi8-r"'.($_GET['charset'] == 'iso-8859-1 -> koi8-r' ? ' selected="selected"' : '').'>iso-8859-1 -&gt; koi8-r</option>
</optgroup>
<optgroup label="CP866">
<option value="cp866 -&gt; utf-8"'.($_GET['charset'] == 'cp866 -> utf-8' ? ' selected="selected"' : '').'>cp866 -&gt; utf-8</option>
<option value="cp866 -&gt; windows-1251"'.($_GET['charset'] == 'cp866 -> windows-1251' ? ' selected="selected"' : '').'>cp866 -&gt; windows-1251</option>
<option value="cp866 -&gt; iso-8859-1"'.($_GET['charset'] == 'cp866 -> iso-8859-1' ? ' selected="selected"' : '').'>cp866 -&gt; iso-8859-1</option>
<option value="cp866 -&gt; koi8-r"'.($_GET['charset'] == 'cp866 -> koi8-r' ? ' selected="selected"' : '').'>cp866 -&gt; koi8-r</option>
</optgroup>
<optgroup label="KOI8-R">
<option value="koi8-r -&gt; utf-8"'.($_GET['charset'] == 'koi8-r -> utf-8' ? ' selected="selected"' : '').'>koi8-r -&gt; utf-8</option>
<option value="koi8-r -&gt; windows-1251"'.($_GET['charset'] == 'koi8-r -> windows-1251' ? ' selected="selected"' : '').'>koi8-r -&gt; windows-1251</option>
<option value="koi8-r -&gt; iso-8859-1"'.($_GET['charset'] == 'koi8-r -> iso-8859-1' ? ' selected="selected"' : '').'>koi8-r -&gt; iso-8859-1</option>
<option value="koi8-r -&gt; cp866"'.($_GET['charset'] == 'koi8-r -> cp866' ? ' selected="selected"' : '').'>koi8-r -&gt; cp866</option>
</optgroup>
</select><br/>
<input type="submit" value="' . $lng['ch'] . '"/>
</div>
</form>
</div>';

		break;


    case 'save':
    	if($_POST['charset'] != 'utf-8'){
    		$_POST['text'] = iconv('UTF-8', $_POST['charset'], $_POST['text']);
   		}

        if ($type == 'ZIP' || $type == 'JAR') {
            echo edit_zip_file_ok($current, $_GET['f'], $_POST['text']);
        } else {
            echo create_file($current, $_POST['text'], $_POST['chmod']);
        }
        break;


    case 'replace':
        if ($type == 'ZIP' || $type == 'JAR') {
            echo zip_replace($current, $_GET['f'], $_POST['from'], $_POST['to'], $_POST['regexp']);
        } else {
            echo replace($current, $_POST['from'], $_POST['to'], $_POST['regexp']);
        }
        break;


    case 'syntax':
        if ($type == 'ZIP' || $type == 'JAR') {
            echo zip_syntax($current, $_GET['f'], $charset, $syntax);
        } else {
            if (!$syntax) {
                echo syntax($current, $charset);
            } else {
                echo syntax2($current, $charset);
            }
        }
        break;


    case 'validator':
    /*
        echo validator('http://' . $_SERVER['HTTP_HOST'] . str_replace('\\', '/', substr(realpath($current), strlen($_SERVER['DOCUMENT_ROOT']))), $charset);
    */
    echo validator($current, $charset);
        break;
}


echo '<div class="rb">' . round(microtime(true) - $ms, 4) . '<br/></div>' . $foot;
?>