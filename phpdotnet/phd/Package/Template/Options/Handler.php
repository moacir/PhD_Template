<?php
/**
 * PhD Template Package
 *
 * PHP version 5.3+
 *
 * @category PhD
 * @package  PhD_Template
 * @author   Moacir de Oliveira <moacir@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD Style
 * @link     https://doc.php.net/phd/
 */
namespace phpdotnet\phd;

/**
 * Template Package options handler.
 *
 * @category PhD
 * @package  PhD_Template
 * @author   Moacir de Oliveira <moacir@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD Style
 * @link     https://doc.php.net/phd/
 */
class Package_Template_Options_Handler implements Options_Interface
{
    /**
     * Defines the options available in the package.
     * Current options:
     *      --template-file: The template file to be rendered
     */
    public function optionList()
    {
        return array(
            'file:', // The template file to be rendered
        );
    }

    /**
     * Handles the --template-file option.
     *
     * @param $k String Option name
     * @param $v String Option value
     */
    public function option_file($k, $v)
    {
        if (is_array($v)) {
            trigger_error("Can only render one template at a time", E_USER_ERROR);
        }
        if (!file_exists($v) || is_dir($v) || !is_readable($v)) {
            trigger_error(sprintf("'%s' is not a readable template file", $v), E_USER_ERROR);
        }
        Config::set_template_file(realpath($v));
    }
}
