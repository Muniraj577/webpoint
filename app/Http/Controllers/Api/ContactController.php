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
//        $ar = [
//            ['Hello', 'World', 'JavaScript'],
//            ['JavaScript', 'Program']
//        ];
//        $newarr = array_merge([], ...$ar);
//        $count = array_count_values($newarr);
//        return array_filter($newarr, function ($value) use($count){
//           return $count[$value] < 2;
//        });
        try {
            $contacts = $this->contactRepository->filter($request, 'desc');
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
//        dd($request->email, explode('@', 'gmail.com'));
//        dd(list($email, $domain) = explode('@', $request->email));
        try {
            $emailArray = ['gmail.com', 'webpoint.io'];
            list($email, $domain) = explode('@', $request->email);
            if (!in_array($domain, $emailArray)){
//            if ($domain !== 'webpoint.io'){
                return $this->sendErrorResponse(Response::HTTP_BAD_REQUEST, "The domain $domain is not supported");
            }
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
            if (!$contact){
                return $this->sendErrorResponse(Response::HTTP_NOT_FOUND, 'Contact not found');
            }
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
            $contact = $this->contactRepository->delete($id);
            if (!$contact){
                return $this->sendErrorResponse(Response::HTTP_NOT_FOUND, 'Contact not found');
            }
            DB::commit();
            return $this->sendSuccessResponse($data, Response::HTTP_OK, "Contact deleted successfully");
        } catch (\Exception $e){
            DB::rollBack();
            return $this->sendErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    private function getPrimeNumbers($n)
    {
        $primeNumbers = [];
        for ($i = 1; $i <= $n - 1; $i++){
            if ($i % ($i + $n - 1) != 0 ){
                $primeNumbers[] = $i;
            }
        }
        return $primeNumbers;
    }

//    multiple of 7 'Cocola'
// multiple of 3 7 5 'FizBuzz Cocola';
    public function getText($n){
        for ($i = 1; $i <= $n; $i++){
            if ($i % 3 == 0 && $i % 5 == 0 && $i%7==0){
                echo 'FizzBuzz Cocola' .$i ;
                echo '</br>';
                echo PHP_EOL;
            }elseif ($i % 3 == 0 && $i % 5 == 0){
                echo 'FizzBuzz' .$i ;
                echo '</br>';
                echo PHP_EOL;
            } elseif ($i % 5 == 0 ){
                echo 'Buzz' . $i;
                echo '</br>';
                echo PHP_EOL;
            } elseif ($i % 3 == 0 ){
                echo 'Fizz' . $i;
                echo '</br>';
                echo PHP_EOL;
            }
            elseif ($i % 7 == 0 ){
                echo 'Cocola' . $i;
                echo '</br>';
                echo PHP_EOL;
            }
        }
    }
}
