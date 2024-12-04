<?php

class Request
{
    public function getMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function getPath()
    {
        $request_path = $_SERVER["REQUEST_URI"] ?? '/';
        $position = strpos($request_path, '?');
        if ($position !== false) {
            $request_path = substr($request_path, 0, $position);
        }
        return $request_path;
    }
}
