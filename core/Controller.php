<?php

class Controller
{
    public function view($module, $view, $data = [])
    {
        extract($data);
        require "../modules/$module/views/$view.php";
    }
}
?>