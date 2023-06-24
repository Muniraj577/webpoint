<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactDetailResource;
use App\Http\Resources\ContactListResource;
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

    public function index()
    {
        try {
            $contacts = $this->contactRepository->getAll();
            return $this->sendSuccessResponse($contacts, Response::HTTP_OK, 'Contacts fetched successfully');
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
