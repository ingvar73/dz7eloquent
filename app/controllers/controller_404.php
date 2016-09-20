<?php

class Controller_404 extends Controller {

    public function action_index()
    {
        $this->view->generate('404_view.twig', array(
            "title" => "404 - Ошибка"
        ));
    }

}