<?php

namespace Bhsec\SimpleImage\Templates;

class QuoteTemplates extends Templates
{
    public static function make(array $opt): array
    {
        $text = $opt['text'];
        $waterMark = $opt['watermark'];
        $font = $opt['font'];
        $query = $opt['query'];
        $outputName = $opt['result']['output'];
        $mime = $opt['result']['mime'];
        $quality = $opt['result']['quality'];

        try {
            $option1 = [
                // main text
                'color' => 'white',
                'size' => 130,
                'anchor' => 'center',
                'fontFile' => parent::SOURCE . $font,
                'xOffset' => -30,
                'yOffset' => -(strlen($text) * 2 - 150),
                'shadow' => [
                    // shadow option
                    'x' => 12,
                    'y' => 12,
                    'color' => 'black',
                ],
            ];

            $option2 = [
                // watermark text
                'color' => 'white',
                'size' => 130,
                'anchor' => 'center',
                'fontFile' => parent::SOURCE . $font,
                'xOffset' => -30,
                'yOffset' => 600,
                'shadow' => [
                    // shadow option
                    'x' => 12,
                    'y' => 12,
                    'color' => 'black',
                ],
            ];
            $container = parent::getContainer();
            $container['query'] = $query;
            $image = $container['image'];
            $unsplash = $container['unsplash_small'];

            $image
                ->fromString($unsplash)
                ->resolution(320, 200)
                ->resize(2016, 2016)
                ->autoOrient()
                ->text(parent::filterParagraf($text, 35), $option1)
                ->text(parent::filterParagraf($waterMark, 35), $option2)
                ->toFile($outputName, $mime, $quality);

            return [
                'Exif' => $image->getExif(),
                'Orientation' => $image->getOrientation(),
                'Resolution' => $image->getResolution(),
                'AspectRatio' => $image->getAspectRatio(),
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
