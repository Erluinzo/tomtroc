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

    //human label for how long a member has been registered
    public static function membershipLabel(string $datetime): string
    {
        $diff = (new DateTime($datetime))->diff(new DateTime());

        if ($diff->y >= 1) {
            return $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
        }
        if ($diff->m >= 1) {
            return $diff->m . ' mois';
        }
        $days = max(1, $diff->d);
        return $days . ' jour' . ($days > 1 ? 's' : '');
    }
}
