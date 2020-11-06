<?php
require_once File::build_path(array('model', 'ModelBook.php'));

class controllerBook
{
    protected static $object = 'book';

    public static function readAll() {
        $tab_v = ModelBook::selectAll();
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }
}