<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;

abstract class FileHelper
{
    /**
     * Extract base64 value from string
     * 
     * @param string $encoded 
     * @return string 
     * 
     * @throws LogicException 
     * @throws InvalidArgumentException 
     * @throws ExceptionLogicException 
     */
    public static function extractBase64(string $encoded): string
    {
        // Decode the base64 file
        $strEncoded = $encoded;
        if (\preg_match('#^data:\w+/\w.+;base64,#i', $encoded)) {
            $strEncoded = \preg_replace('#^data:\w+/\w.+;base64,#i', '', $encoded);
        }
        return $strEncoded;
    }
    
    /**
     * Converts a base64 format file to an UploadedFile class
     * 
     * @param string $encoded 
     * @return UploadedFile 
     * 
     * @throws LogicException 
     * @throws InvalidArgumentException 
     * @throws ExceptionLogicException 
     */
    public static function fromBase64(string $encoded): UploadedFile
    {
        // Decode the base64 file
        $strEncoded = $encoded;
        if (\preg_match('#^data:\w+/\w.+;base64,#i', $encoded)) {
            $strEncoded = \preg_replace('#^data:\w+/\w.+;base64,#i', '', $encoded);
        }
        $fileData = \base64_decode($strEncoded);

        // Save it to temporary dir first.
        $tmpFilePath = \sys_get_temp_dir() . '/' . Str::uuid()->toString();
        \file_put_contents($tmpFilePath, $fileData);

        // This just to help us get file info.
        $tmpFile = new File($tmpFilePath);
        return new UploadedFile($tmpFile->getPathname(), $tmpFile->getFilename(), $tmpFile->getMimeType(), 0, true);
    }

    /**
     * Encode the file to base64
     * 
     * @param string $path 
     * @return string 
     */
    public static function toBase64(string $path): string
    {
        $emptyImage = '/var/www/html/storage/app/branco.jpg';
        $fileData = \base64_encode(\file_get_contents($emptyImage));
        $mimeType = \mime_content_type($emptyImage);
        
        if(file_exists($path)){
            $fileData = \base64_encode(\file_get_contents($path));
            $mimeType = \mime_content_type($path);
        }

        return "data:{$mimeType};base64,{$fileData}";
    }

    public static function storePath(?string $file): string | bool | null
    {
        $path = null;
        if ($file && !empty($file)) {
            $upFile = FileHelper::fromBase64($file);
            $path = $upFile->store("files/users/avatars");
        }

        return $path;
    }
}