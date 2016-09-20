<?php

class Controller_About extends Controller {
    public function action_index()
    {
        $this->view->generate('onas_view.twig', array(
            "title" => "О сайте"
        ));
    }

    public function action_novyi()
    {
        print_r($_GET);
    }

    public function action_login()
    {
        var_dump($_GET);
    }
}