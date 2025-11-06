<?php
namespace App\Http\Controllers\Api;


use App\Services\TwelveApiService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TwelveController extends Controller
{
    protected $twelve;

    public function __construct(TwelveApiService $twelve)
    {
        $this->twelve = $twelve;
    }

    public function balance()
    {
        return response()->json($this->twelve->balance());
    }

    public function categories()
    {
        return response()->json($this->twelve->categories());
    }

    public function products(Request $request)
    {
        $categoryId = $request->input('category-id');
        return response()->json($this->twelve->products($categoryId));
    }

    public function productDetails($id)
    {
        return response()->json($this->twelve->productDetails($id));
    }

    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|string',
            'reseller_ref' => 'required|string',
        ]);

        $response = $this->twelve->purchaseVoucher(
            $validated['package_id'],
            $validated['reseller_ref']
        );

        return response()->json($response);
    }

    // Handle webhook callbacks
    public function webhook(Request $request)
    {
        $data = $request->all();

        if ($data['type'] === 'orders') {
            // Update local order status here
        } elseif ($data['type'] === 'products') {
            // Handle product updates or access changes
        }

        return response()->json(['success' => true]);
    }
}
