<?php

//helper functions
class Utils
{
    //get a value from the request, or a default if not set
    public static function request(string $name, mixed $default = null): mixed
    {
        $value = $_REQUEST[$name] ?? $default;

        //arrays are never expected here, they would break the string functions
        return is_array($value) ? $default : $value;
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

    //true when the form sent a file in this field
    public static function hasUpload(array $file): bool
    {
        return ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    }

    //check an uploaded picture, return an error message or null when it is fine
    public static function imageUploadError(array $file): ?string
    {
        $error = $file['error'] ?? UPLOAD_ERR_NO_FILE;

        if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
            return "L'image est trop lourde (2 Mo maximum).";
        }
        if ($error !== UPLOAD_ERR_OK) {
            return "Le fichier n'a pas pu être envoyé.";
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            return "L'image est trop lourde (2 Mo maximum).";
        }

        //only jpg and png are accepted, gd has no webp support on this server
        $info = @getimagesize($file['tmp_name']);
        if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
            return "Le fichier doit être une image JPG ou PNG.";
        }
        return null;
    }

    //keep a valid uploaded picture under img/ with a safe name, return its relative path
    public static function saveUpload(array $file, string $subDir): ?string
    {
        if (self::imageUploadError($file) !== null) {
            return null;
        }

        //the extension comes from the real content, not from the name sent by the browser
        $info = getimagesize($file['tmp_name']);
        $extension = $info[2] === IMAGETYPE_PNG ? 'png' : 'jpg';
        $name = $subDir . '/' . uniqid('', true) . '.' . $extension;

        if (!move_uploaded_file($file['tmp_name'], 'img/' . $name)) {
            return null;
        }
        return $name;
    }

    //short time label: hour today, day.month otherwise
    public static function shortTime(string $datetime): string
    {
        $ts = strtotime($datetime);
        return date('Y-m-d', $ts) === date('Y-m-d') ? date('H:i', $ts) : date('d.m', $ts);
    }
}
