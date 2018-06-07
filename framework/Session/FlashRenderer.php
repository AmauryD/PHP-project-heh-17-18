<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 15:43
 */

namespace Framework\Session;


use Framework\View\View;

class FlashRenderer
{
    private $view;

    /**
     * FlashRenderer constructor.
     * FlashRenderer is used to pass messages to next page via session
     * @param View $view
     */
    public function __construct(View &$view)
    {
        $this->view = $view;
    }

    /**
     * Set the flash message in session , support only 1 message
     * @param $message
     * @param string $type
     */
    public function flash($message, $type = 'success')
    {
        $_SESSION['flash_messages'][] = [$type, $message];
    }

    /**
     * render the flash message , does not need an echo
     * @return bool
     */
    public function render()
    {
        if (isset($_SESSION['flash_messages'])) {
            foreach ($_SESSION['flash_messages'] as $flash_message) {
                $type = $flash_message[0];
                $message = $flash_message[1];
                $this->view->render("template/Template/Flash/$type.php",
                    compact('message')
                );
            }
            $_SESSION['flash_messages'] = [];
            return true;
        }
        return false;
    }
}