<?php

//helper functions
class Utils
{
    //get a value from the request, or a default if not set
    public static function request(string $name, mixed $default = null): mixed
    {
        return $_REQUEST[$name] ?? $default;
    }

    //redirect to an action of the router and stop the script
    public static function redirect(string $action): void
    {
        header('Location: index.php?action=' . $action);
        exit();
    }
}
