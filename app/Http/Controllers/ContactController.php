<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ContactController extends Controller
{

    public function getAllContact(Request $request)
    {
        $searchQuery = $request->query('search');

        $query = Contact::query();

        // Apply search filter if the search query is provided
        if ($searchQuery) {
            $query->where('full_name', 'LIKE', '%' . $searchQuery . '%');
        }

        $contacts = $query->paginate(5);

        $responseArray = [
            'status' => 'ok',
            'data' => $contacts,
        ];

        return response()->json($responseArray, 200);


    }
    public function createContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'email',
            'mobile_number' => 'required|digits:10',

        ]);

        if ($validator->fails()) {
            $responseArray = [
                'status' => 'error',
                'error' => $validator->errors(),
            ];

            return response()->json($responseArray, 422);
        }
        $input = $request->all();
        $contactData = [
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'mobile_number' => $input['mobile_number'],
        ];
        $contact = Contact::create($contactData);

        if ($contact) {

            $responseArray = [
                'status' => 'ok',
                'data' => $contact,
                'message' => "Contact created successfully"
            ];

            return response()->json($responseArray, 201);


        }
    }

    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();
        $responseArray = [
            'status' => 'ok',
            'message' => 'Successfully Deleted',
            'data' => $contact,
        ];

        return response()->json($responseArray, Response::HTTP_OK);

    }

    public function updateContact(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        // Validate the updated form data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'email',
            'mobile_number' => 'digits:10',

        ]);

        if ($validator->fails()) {
            $responseArray = [
                'status' => 'error',
                'error' => $validator->errors(),
            ];

            return response()->json($responseArray, 202);
        }

        $input = $request->all();
        $contactData = [
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'mobile_number' => $input['mobile_number'],
        ];
        $contact->update($contactData);
        $responseArray = [
            'status' => 'ok',
            'message' => 'Successfully updated',
            'data' => $contact,
        ];

        return response()->json($responseArray, Response::HTTP_OK);
    }
}