<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactListResource;
use App\Models\Contact;
use App\Repository\ContactRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    use ApiResponse;

    public $responseResource;

    protected $contactRepository;

    public function __construct()
    {
        $this->responseResource = ContactListResource::class;
        $this->contactRepository = new ContactRepository($this->responseResource);
    }

    public function index(Request $request)
    {
        try {
            $contacts = $this->contactRepository->filter($request);
            return $contacts;
//            $contacts = Contact::when(!blank($request->title) && $request->title !== null, function ($q) use($request){
//                $q->where('full_name', 'LIKE', "%".$request->title."%");
//            })->paginate(10);
//            return ContactListResource::collection($contacts)
//                ->response()
//                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->sendErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function store(ContactRequest $request)
    {
        try {
            DB::beginTransaction();
            $contact = $this->contactRepository->save($request);
            DB::commit();
            return $this->sendSuccessResponse($contact, Response::HTTP_OK, 'Contact created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function getContactDetail($id)
    {
        try {
            $contact = $this->contactRepository->getById($id);
            return $this->sendSuccessResponse($contact, Response::HTTP_OK, 'Contact fetched successfully');
        } catch (\Exception $e){
            return $this->sendErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(ContactRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $contact = $this->contactRepository->update($request, $id);
            DB::commit();
            return $this->sendSuccessResponse($contact, Response::HTTP_OK, "Contact updated successfully");
        } catch (\Exception $e){
            DB::rollBack();
            return $this->sendErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = [];
            DB::beginTransaction();
            $this->contactRepository->delete($id);
            DB::commit();
            return $this->sendSuccessResponse($data, Response::HTTP_OK, "Contact deleted successfully");
        } catch (\Exception $e){
            DB::rollBack();
            return $this->sendErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
