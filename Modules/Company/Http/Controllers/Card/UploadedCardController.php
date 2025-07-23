<?php

namespace Modules\Company\Http\Controllers\Card;

use App\Models\Package;
use App\Models\UploadedCard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Company\Http\Requests\CardRequest;
use Modules\Company\Repositories\UploadedCardRepository;

class UploadedCardController extends Controller
{
    public $repository;
    public function __construct()
    {
        $this->repository = new UploadedCardRepository();
    }

    public function edit(UploadedCard $card)
    {
        return view('company::uploaded_cards.edit',compact('card'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function store(Package $package)
    {

        $updated = $this->repository->store();
        return $updated ?
            redirect()->route('admin.uploaded-card-index.index',$package->id)->with('success', trans('messages.addOK')) :
            redirect()->route('admin.uploaded-card-index.index',$package->id)->with('warning', trans('messages.addNO'));
    }
    public function cancel(Package $package)
    {

        $updated = $this->repository->cancel();
        return $updated ?
            redirect()->route('admin.uploaded-card-index.index',$package->id)->with('success', trans('messages.deleteOK')) :
            redirect()->route('admin.uploaded-card-index.index',$package->id)->with('warning', trans('messages.deleteOK'));
    }
    public function update(CardRequest $request, UploadedCard $card)
    {
        $updated = $this->repository->update($request, $card);
        return $updated ?
            redirect()->route('admin.uploaded-card-index.index',$card->package_id)->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.uploaded-card-index.index',$card->package_id)->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request) {
        $data = $this->repository->destroy($request);
        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request) {
        $data = $this->repository->destroy_selected_rows($request);
        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
