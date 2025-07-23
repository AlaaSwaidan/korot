<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable=[
        'supplier_id',
        'supplier_code',
        'purchase_order_date',
        'received_date',
        'currency_id',
        'total_before_tax',
        'total_after_tax',
        'tax_amount',
        'confirm',
        'confirm_date',
        'bank_id',
        'invoice_id',
        'qrcode',
        'total_discount_amount',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function products()
    {
        return $this->hasMany(PurchaseProduct::class,'purchase_order_id');
    }
    public function generateQRCode()
    {
        $generatedString = GenerateQrCode::fromArray([
            new Seller("مؤسسة بطاقات التجارية"), // seller name
            new TaxNumber(300453343300003), // seller tax number
            new InvoiceDate(Carbon::parse($this->purchase_order_date)->toISOString()), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount(number_format($this->total_after_tax,2,".","")), // invoice total amount
            new InvoiceTaxAmount(number_format($this->tax_amount,2,".","")) // invoice tax amount
            // TODO :: Support others tags
        ])->toBase64();
        if ($this->qrcode == null){
            $name = time().$this->id.randNumber(4);
            $qrcode =  QrCode::size(500)
                ->format('svg')
                ->errorCorrection('H')
//            ->color(8, 154, 175)
//            ->backgroundColor(255, 255, 255)
                ->style('round')
                ->generate($generatedString, public_path('uploads/qr-code-images/'.$name.'.svg'));
            $result = base64_encode($qrcode);
            $this->update(['qrcode'=>$name.'.svg']);
        }

        return $this->qrcode;
    }
}
