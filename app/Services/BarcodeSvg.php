<?php
namespace App\Services;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
class BarcodeSvg {
    public static function render(string $value): string {
        return (new Builder())->build(data:$value,size:240,margin:10,writer:new SvgWriter())->getString();
    }
}
