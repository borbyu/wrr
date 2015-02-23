<?php

/**
 * Class HelloWorldRoute *
 */
class HelloWorldRoute extends \Wrr\DefaultRoute {
    /**
     * Constructor
     */
    public function __construct() {
        $fun = function () {
            ob_start();
            //$myBlogApp::run();
            return ob_get_clean();
        };
        parent::__construct('^/blog$', $fun);
    }
}
