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
 * Format for rendering chunked html files. This class allows the use
 * of templates to customize the PhD output.
 *
 * The following variables can be used within the templates:
 * - {CONTENT}: The content html rendered
 * - {TITLE}: Page title
 * - {TOC}: HTML Table of contents
 * - {LANG}: The manual language 
 * - {HOME_DESC}: The title of the index page
 * - {HOME_HREF}: The href of the index page
 * - {UP_DESC}: The title of the parent page
 * - {UP_HREF}: The href of the parent page
 * - {NEXT_DESC}: The title of the next page
 * - {NEXT_HREF}: The href of the next page
 * - {PREV_DESC}: The title of the previous page
 * - {PREV_HREF}: The href of the previous page
 * - {PHD_VERSION}: The current PhD version
 * - {PHD_URL}: PhD site URL
 *
 * @category PhD
 * @package  PhD_Template
 * @author   Moacir de Oliveira <moacir@php.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php BSD Style
 * @link     https://doc.php.net/phd/
 */
class Package_Template_ChunkedXHTML extends Package_PHP_Web
{
    /**
     * Template file contents.
     *
     * @var String
     */
    protected $template = '';

    /**
     * Format constructor.
     * Reads the template file from Config::template_file()
     */
    public function __construct()
    {
        parent::__construct();
        $this->registerFormatName('Template-Chunked-XHTML');
        $this->setExt(Config::ext() === null ? '.html' : Config::ext());
        $this->template = file_get_contents(Config::template_file());
    }

    /**
     * Writes the current chunk in an output file.
     * The content is passed in a resource $fp. For using the full
     * content it is necessary to rewind the resource.
     *
     * @param $id String xml:id of the chunk
     * @param $fp Resource The content rendered of the current chunk
     */
    public function writeChunk($id, $fp)
    {
        rewind($fp);

        $vars = $this->getTemplateVars($id);
        $vars['content'] = stream_get_contents($fp);

        $filename = $this->getOutputDir() . Format::getFilename($id) . $this->getExt();
        file_put_contents($filename, $this->renderTemplate($this->template, $vars));
    }

    /**
     * Prepare the template variables for the given chunk id.
     *
     * @param $id String xml:id of the chunk
     */
    public function getTemplateVars($id)
    {
        static $cssLinks = null;
        if ($cssLinks === null) {
            // Create the links for the css passed via command line (--css)
            $cssLinks = $this->createCSSLinks();
        }

        $title = Format::getLongDescription($id);

        $parent = Format::getParent($id);
        $next = $prev = $up = array('href' => null, 'desc' => null);
        if ($parent && $parent != 'ROOT') {
            if ($prevId = Format::getPrevious($id)) {
                $prev = array(
                    'href' => $this->getFilename($prevId) . $this->getExt(),
                    'desc' => $this->getShortDescription($prevId),
                );
            }
            if ($nextId = Format::getNext($id)) {
                $next = array(
                    'href' => $this->getFilename($nextId) . $this->getExt(),
                    'desc' => $this->getShortDescription($nextId),
                );
            }
            if ($parentId = Format::getParent($id)) {
                $up = array(
                    'href' => $this->getFilename($parentId) . $this->getExt(),
                    'desc' => $this->getShortDescription($parentId),
                );
            }
        }

        return array(
            'title' => $title,
            'root' => Format::getRootIndex(),
            'up' => $up,
            'next' => $next,
            'prev' => $prev,
            'css' => $cssLinks,
            'lang' => Config::language(),
            'toc' => $this->createTableOfContents($id),
            'phd' => array(
                'version' => Config::VERSION,
                'url' => 'http://doc.php.net/phd',
            ),
        );
    }

    /**
     * Creates a ready to use table of contents.
     *
     * @param $id String xml:id of the chunk
     */
    public function createTableOfContents($id)
    {
        $parent = Format::getParent($id);
        if ($parent === '') {
            $tocBar = '<ul class="toc">';
            foreach ($this->getChildren($id) as $child) {
                $desc = '';
                $link = $this->createLink($child, $desc);
                $tocBar .= "  <li><a href=\"$link\">$desc</a></li>\n";
            }
            $tocBar .= '</ul>';
            return $tocBar;
        }

        $root = Format::getRootIndex();
        $tocBar =  '<ul class="toc">';
        $tocBar .= sprintf('<li class="header home"><a href="%s">%s</a></li>',
            $root['filename'].$this->getExt(),
            $root['ldesc']
        );

        // Fetch ancestors of the current node
        $ancestors = array();
        $currentId = $id;
        while (($currentId = $this->getParent($currentId)) && $currentId != "index") {
            $desc = '';
            $link = $this->createLink($currentId, $desc);
            $ancestors[] = array('desc' => $desc, 'link' => $link);
        }

        // Show them from the root to the closest parent
        foreach (array_reverse($ancestors) as $ancestor) {
        	$tocBar .= "  <li class=\"header up\"><a href=\"{$ancestor['link']}\">{$ancestor['desc']}</a></li>\n";
        }

        // Fetch siblings of the current node
        foreach ($this->getChildren($parent) as $child) {
            $desc = '';
            $link = $this->createLink($child, $desc);
            $active = ($id === $child);
            $tocBar .= "  <li" .($active ? " class=\"active\"" : ""). "><a href=\"$link\">$desc</a></li>\n";
        }
        return $tocBar . " </ul>\n";
    }

    /**
     * Replace the template variables with the current values.
     * Current variables:
     * - {CONTENT}: The content html rendered
     * - {TITLE}: Page title
     * - {TOC}: Table of contents
     * - {LANG}: The manual language 
     * - {HOME_DESC}: The title of the index page
     * - {HOME_HREF}: The href of the index page
     * - {UP_DESC}: The title of the parent page
     * - {UP_HREF}: The href of the parent page
     * - {NEXT_DESC}: The title of the next page
     * - {NEXT_HREF}: The href of the next page
     * - {PREV_DESC}: The title of the previous page
     * - {PREV_HREF}: The href of the previous page
     * - {PHD_VERSION}: The current PhD version
     * - {PHD_URL}: PhD site URL
     *
     * @param $template String Content of the template file
     * @param $vars Template values
     */
    public function renderTemplate($template, $vars)
    {
        return preg_replace(
            array(
                '/\{CONTENT\}/',
                '/\{TITLE\}/',
                '/\{TOC\}/',
                '/\{LANG\}/',
                '/\{HOME_DESC\}/',
                '/\{HOME_HREF\}/',
                '/\{UP_DESC\}/',
                '/\{UP_HREF\}/',
                '/\{NEXT_DESC\}/',
                '/\{NEXT_HREF\}/',
                '/\{PREV_DESC\}/',
                '/\{PREV_HREF\}/',
                '/\{PHD_VERSION\}/',
                '/\{PHD_URL\}/',
            ),
            array(
                $vars['content'],
                $vars['title'],
                $vars['toc'],
                $vars['lang'],
                $vars['root']['ldesc'],
                $vars['root']['filename'] . $this->getExt(),
                $vars['up']['desc'],
                $vars['up']['href'],
                $vars['next']['desc'],
                $vars['next']['href'],
                $vars['prev']['desc'],
                $vars['prev']['href'],
                $vars['phd']['version'],
                $vars['phd']['url'],
            ),
            $template
        );
    }
}
