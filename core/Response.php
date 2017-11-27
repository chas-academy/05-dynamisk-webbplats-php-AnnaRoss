<?php

    require_once('./utils/Preferences.php');

    class Response 
    {

        private $templateDirectory;

        public function __construct() {}

        /**
        *
        * Renders a specified file
        *
        * @param string file path 
        * @param array parameters to pass to the view
        * @param int statuscode
        */
        public function render_file(string $filePath = null, array $params = [], int $statusCode = null)
        {
            if (isset($statusCode))
            {
                http_response_code($statusCode);
            }

            extract($params);

            ob_start();
            if (file_exists($filePath)) 
            {
                include($filePath);
            }
            $renderedView = ob_get_clean();
            return exit(print($renderedView));
        }
        
        public function render_template(string $template_path = null, array $params = [], int $statusCode = null)
        {
            $header = Preferences::$templateDirectory . 'header.html';
            $template_path = Preferences::$templateDirectory . $template_path;
            $footer = Preferences::$templateDirectory . 'footer.html';
            if (isset($statusCode))
            {
                http_response_code($statusCode);
            }

            extract($params);

            ob_start();
            if (file_exists($template_path)) 
            {   include($header);
                include($template_path);
                include($footer);
            }
            $renderedView = ob_get_clean();
            return exit(print($renderedView));

        }

        public function json($data, int $statusCode = null)
        {
            if (isset($statusCode)) 
            {
                http_response_code($statusCode);
            }

            $data = json_encode($data, JSON_PRETTY_PRINT);

            return exit(print($data));
        }

        public function redirect(string $url)
        {
            return exit(header('Location:'. $url));
        }

        public function status(int $statusCode = null)
        {
            http_response_code($statusCode);
        }

        public function send($data, int $statusCode = null)
        {
            if (isset($statusCode)) 
            {
                http_response_code($statusCode);
            }

            return exit(print($data));
        }

    }

?>
