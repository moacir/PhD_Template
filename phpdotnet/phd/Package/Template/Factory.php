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
 * Factory to generate the formats of Template Package.
 *
 * @category PhD
 * @package  PhD_Template
 * @author   Moacir de Oliveira <moacir@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD Style
 * @link     https://doc.php.net/phd/
 */
class Package_Template_Factory extends Format_Factory
{
    /**
     * List of available formats. 
     *
     * @var Array
     */
    private $formats = array(
        'xhtml' => 'Package_Template_ChunkedXHTML',
    );

    /**
     * Factory constructor.
     * Adds the 'template_file' value in Config, to store the
     * template file name.
     */
    public function __construct()
    {
        parent::setPackageName("Template");
        parent::registerOutputFormats($this->formats);
        parent::registerOptionsHandler(new Package_Template_Options_Handler());

        Config::init(array(
            'template_file' => __DIR__ . '/templates/bootstrap.tpl',
        ));
    }
}
