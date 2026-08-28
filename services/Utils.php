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

    //store an uploaded picture as jpg, resized so its longest side is $maxSide at most
    public static function saveImage(array $file, string $subDir, int $maxSide): ?string
    {
        $source = self::loadUpload($file);
        if (!$source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $ratio = min(1, $maxSide / max($width, $height));
        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        $image = self::whiteCanvas($newWidth, $newHeight);
        imagecopyresampled($image, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        return self::writeJpeg($image, $subDir);
    }

    //store an uploaded picture as a square jpg (center crop)
    public static function saveSquareImage(array $file, string $subDir, int $size): ?string
    {
        $source = self::loadUpload($file);
        if (!$source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $side = min($width, $height);

        $image = self::whiteCanvas($size, $size);
        imagecopyresampled(
            $image,
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

        return self::writeJpeg($image, $subDir);
    }

    //decode the uploaded file with gd, null when it is not a valid picture
    private static function loadUpload(array $file): ?GdImage
    {
        if (self::imageUploadError($file) !== null) {
            return null;
        }
        $source = @imagecreatefromstring(file_get_contents($file['tmp_name']));
        return $source ?: null;
    }

    //blank white image, so transparent png areas do not turn black
    private static function whiteCanvas(int $width, int $height): GdImage
    {
        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
        return $image;
    }

    //write the picture under img/ with a unique name, return the relative path
    private static function writeJpeg(GdImage $image, string $subDir): ?string
    {
        $name = $subDir . '/' . uniqid('', true) . '.jpg';
        if (!imagejpeg($image, 'img/' . $name, 85)) {
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
