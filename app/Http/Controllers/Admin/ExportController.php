<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;
class ExportController extends Controller {
    public function download(Batch $batch): StreamedResponse {
        $batch->load('coupons');
        $tmp=tempnam(sys_get_temp_dir(),'qr_');
        $zip=new ZipArchive(); $zip->open($tmp,ZipArchive::CREATE|ZipArchive::OVERWRITE);
        $csv="code,url,redeemed_at\n";
        foreach ($batch->coupons as $c) {
            $url=url('/c/'.$c->code);
            $csv.="\"{$c->code}\",\"{$url}\",\"{$c->redeemed_at}\"\n";
            $qr=(new Builder())->build(data: $url, size: 300, margin: 10);
            $zip->addFromString("{$c->code}.png",$qr->getString());
        }
        $zip->addFromString('list_kupon.csv',$csv);
        $zip->close();
        return response()->streamDownload(function() use ($tmp){readfile($tmp); @unlink($tmp);},"batch-{$batch->id}.zip",['Content-Type'=>'application/zip']);
    }
}
