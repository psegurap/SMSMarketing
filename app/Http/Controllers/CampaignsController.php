<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function campaigns(){
        return view('campaigns');
    }

    public function preparefile(){
        $files = glob(base_path() . "/public/images/temporary_upload/*");
        $file = isset($files) ? $files[0] : false;

        $csv = array_map('str_getcsv', file($file));
        $columns_name = $csv[0];
        $rows = array_splice($csv, 1);



        // return $this->rows_to_object($columns_name, $rows);

        $db_columns = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Prone Number',
            'email_address' => 'Email Address',
            'property_address' => 'Property Address',
            'property_city' => 'Property City',
            'property_state' => 'Property State',
            'property_zip_code' => 'Property Zip Code',
            'mail_address' => 'Mail Address',
            'mail_city' => 'Mail City',
            'mail_state' => 'Mail State',
            'mail_zip_code' => 'Mail Zip Code',
        ];

        return view('configure_cvs', compact('columns_name', 'db_columns'));
    }

    // Prepare object with incoming columns and rows properties
    protected function rows_to_object($columms, $rows){

        $rows_object = [];

        for ($i= 0; $i < count($rows); $i++) { 
            $current_row = explode(";", $rows[$i][0]);
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
        $path = base_path() . "/public/images/temporary_upload";
        $file = $request['file'];

        //If the path doesn't exist, create it
        if(!file_exists($path)){
            mkdir($path);
        }

        // Move file to specified location
        $file->move($path, $file->getClientOriginalName());

        return response()->json("Done", 200);
    }

    public function remove_temporary(){
        // Delete any current file left in temporary folder
        $files = glob(base_path() . "/public/images/temporary_upload/*");

        // Deleting all the files in the list
        foreach($files as $file) {
            if(is_file($file)) 
                // Delete the file
                unlink($file); 
        }
    }
}
