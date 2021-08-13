<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Property;
use App\MailAddress;

class CampaignsController extends Controller
{
    public function campaigns(){
        return view('campaigns');
    }

    // View to match selects with incoming columns.
    public function preparefile(){
        $files = glob(base_path() . "/resources/temporary_upload/*");
        $file = isset($files) ? $files[0] : false;

        $csv = array_map('str_getcsv', file($file));
        $columns_name = $csv[0];
        $rows = array_splice($csv, 1);

        $db_columns = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Prone Number',
            'email_address' => 'Email Address',
            'property_street_address' => 'Property Address',
            'property_city' => 'Property City',
            'property_state' => 'Property State',
            'property_zip_code' => 'Property Zip Code',
            'mail_street_address' => 'Mail Address',
            'mail_city' => 'Mail City',
            'mail_state' => 'Mail State',
            'mail_zip_code' => 'Mail Zip Code',
        ];

        return view('configure_cvs', compact('columns_name', 'db_columns'));
    }

    // Function to csv values to database.
    public function store_csv_values(Request $request){
        $files = glob(base_path() . "/resources/temporary_upload/*");
        $file = isset($files) ? $files[0] : false;

        $csv = array_map('str_getcsv', file($file));
        $columns_name = $csv[0];
        $rows = array_splice($csv, 1);
        $rows = $this->rows_to_object($columns_name, $rows);
        $columns_matched = $request->selects_matched;

        foreach ($rows as $row) {
            // Store contacts
            $contact_info = [
                'first_name' => $row->{$columns_matched['first_name']},
                'last_name' => $row->{$columns_matched['last_name']},
                'phone_number' => $row->{$columns_matched['phone_number']},
                'email_address' => $row->{$columns_matched['email_address']},
            ];

            $created_contact = Contact::create($contact_info);

            // Store property
            $property_info = [
                'property_street_address' => $row->{$columns_matched['property_street_address']},
                'property_city' => $row->{$columns_matched['property_city']},
                'property_state' => $row->{$columns_matched['property_state']},
                'property_zip_code' => $row->{$columns_matched['property_zip_code']},
                'contact_id' => $created_contact->id,
            ];
            Property::create($property_info);

            // Store mail address
            $mail_address_info = [
                'mail_street_address' => $row->{$columns_matched['mail_street_address']},
                'mail_city' => $row->{$columns_matched['mail_city']},
                'mail_state' => $row->{$columns_matched['mail_state']},
                'mail_zip_code' => $row->{$columns_matched['mail_zip_code']},
                'contact_id' => $created_contact->id,
            ];
            MailAddress::create($mail_address_info);

            
        }

        return [Contact::all(), Property::all(), MailAddress::all()];


        

        return [$request->selects_matched, $rows];
    }

    // Prepare object with incoming columns and rows properties
    protected function rows_to_object($columms, $rows){

        $rows_object = [];

        for ($i= 0; $i < count($rows); $i++) { 
            $current_row = $rows[$i];
            $current_row_object = new \stdClass();

            foreach ($current_row as $key => $value) {
                $column = $columms[$key];
                $current_row_object->$column = $value; 
            }

            array_push($rows_object, $current_row_object);
        }

        return $rows_object;
    } 


    // FILES
    protected function temporary_upload(Request $request){
        
        // Delete temporary files left in temporary_upload
        $this->remove_temporary();

        //Getting path to upload file
        $path = base_path() . "/resources/temporary_upload";
        $file = $request['file'];

        //If the path doesn't exist, create it
        if(!file_exists($path)){
            // mkdir($path);
        }

        // Move file to specified location
        $file->move($path, $file->getClientOriginalName());

        return response()->json("Done", 200);
    }

    public function remove_temporary(){
        // Delete any current file left in temporary folder
        $files = glob(base_path() . "/resources/temporary_upload/*");

        // Deleting all the files in the list
        foreach($files as $file) {
            if(is_file($file)) 
                // Delete the file
                unlink($file); 
        }
    }
}
