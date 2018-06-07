<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 22-02-18
 * Time: 15:27
 */

namespace Framework\Helpers;

class HtmlHelper
{
    use HtmlTrait;

    private $controller;
    private $action;

    /**
     * HtmlHelper constructor.
     * @param null $controller
     * @param null $action
     */
    public function __construct($controller = null, $action = null)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function postLink($text, array $urlOptions = [], array $other = [])
    {
        $controller = $this->controller;
        $action = $this->action;

        $html_attributes = $this->buildAttributes($other);

        $url = UrlBuilder::build(array_merge(compact('controller', 'action'), $urlOptions));

        return "
            <form action=$url method='post'>
                <input type='submit' value='$text' $html_attributes>
            </form>
        ";
    }

    /**
     * @param $file
     * @return string
     */
    public function js($file)
    {
        $url = BASE_URL."webroot/js/$file";

        return "<script src=$url></script>";
    }
    /**
     * @param $file
     * @return string
     */
    public function css($file)
    {
        $url = BASE_URL."webroot/css/$file";

        return "<link rel='stylesheet' type='text/css' href=$url>";
    }

    /**
     * Creates a HTML link for this framework
     * @param $text
     * @param array $urlOptions
     * @param array $other
     * @return string
     * @internal param null $action
     * @internal param null $controller
     */
    public function link($text, array $urlOptions = [], array $other = [])
    {
        $text = $this->checkEscape($text, $other);
        $html_attributes = $this->buildAttributes($other);

        $controller = $this->controller;
        $action = $this->action;

        $url = UrlBuilder::build(
            array_merge(compact('controller', 'action'), $urlOptions)
        );

        return "<a href='$url' $html_attributes>$text</a>";
    }

    /**
     * @param $file
     * @param array $options
     * @return string
     */
    public function image($file, $options = [])
    {
        $html_attributes = $this->buildAttributes($options);
        $url = BASE_URL."webroot/image/$file";

        return "<img $html_attributes src='$url'>";
    }

}