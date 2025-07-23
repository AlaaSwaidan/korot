<?php

namespace Modules\Transfers\Entities;


use App\Models\Bank;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class Transfer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'providerable_id',
        'providerable_type',
        'userable_id',
        'userable_type',
        'type',
        'amount',
        'transfers_total',
        'collection_total',
        'indebtedness',
        'transfer_type',
        'collection_type',
        'collection_description',
        'confirm',
        'qrcode',
        'bank_name',
        'balance_total',
        'repayment_total',
        'profits_total',
        'pay_type',
        'profits',
        'image',
        'api_linked',
        'order_id',
        'collection_id',
        'transaction_id',
        'geidea_commission',
        'geidea_percentage',
        'cart_type',
    ];
    public function scopeOrder($query){
        return $query->orderBy('id', 'desc');
    }

    public function generateQRCode()
    {
        $generatedString = GenerateQrCode::fromArray([
            new Seller("مؤسسة بطاقات التجارية"), // seller name
            new TaxNumber(300453343300003), // seller tax number
            new InvoiceDate(Carbon::parse($this->created_at)->toISOString()), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount(number_format($this->amount,2,".","")), // invoice total amount
            new InvoiceTaxAmount(number_format(0,2,".","")) // invoice tax amount
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
    public function user()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
    public function distributor()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
    public function merchant()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id')->withTrashed();
    }
    public function admin()
    {
        return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    }
    public function fromAdmin()
    {
//        return $this->morphOne(Transfer::class, 'providerable');
        return $this->morphTo(__FUNCTION__, 'providerable_type', 'providerable_id')->withTrashed();
    }
    public function fromDistributor()
    {
        return $this->morphTo(__FUNCTION__, 'providerable_type', 'providerable_id');
    }
    public function order()
    {
        return $this->belongsTo( Order::class , 'order_id');
    }
    public function bank()
    {
        return $this->belongsTo( Bank::class , 'bank_name');
    }
    protected static function newFactory()
    {
        return \Modules\Transfers\Database\factories\TransferFactory::new();
    }
}
