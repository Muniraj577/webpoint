<?php

namespace App\Repository;

use App\Contracts\ContactInterface;
use App\Models\Contact;

class ContactRepository implements ContactInterface
{
    public $responseResource;

    public function __construct($responseResource)
    {
        $this->responseResource = $responseResource;
    }

    public function getAll()
    {
        return $this->responseResource::collection(Contact::get());
    }

    public function save($data)
    {
        $input = $data->except("_token");
        $contact = Contact::create($input);
        return $this->getById($contact->id);
    }

    public function getById($id)
    {
        return new $this->responseResource(Contact::find($id));
    }

    public function find($id)
    {
        return Contact::find($id);
    }

    public function update($data, $id)
    {
        $contact = $this->find($id);
        $input = $data->except("_token");
        $contact->update($input);
        return $this->getById($id);
//        return $contact->refresh(); // return collection after update
    }

    public function delete($id)
    {
        $contact = $this->find($id);
        return $contact->delete();
    }

}