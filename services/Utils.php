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

    //validate, crop to a square and store an uploaded image, return its path under img/ or null
    public static function saveSquareImage(array $file, string $subDir, int $size = 400): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            return null;
        }

        //rebuild the image with gd, this drops anything that is not a real image
        $source = @imagecreatefromstring(file_get_contents($file['tmp_name']));
        if (!$source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $side = min($width, $height);
        $square = imagecreatetruecolor($size, $size);
        imagecopyresampled(
            $square,
            $source,
            0,
            0,
            (int) (($width - $side) / 2),
            (int) (($height - $side) / 2),
            $size,
            $size,
            $side,
            $side
        );

        $name = $subDir . '/' . uniqid('', true) . '.jpg';
        imagejpeg($square, 'img/' . $name, 85);
        return $name;
    }
}
