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
        return $file;
        // return view('configure_cvs');
    }


    // FILES
    public function temporary_upload(Request $request){
        
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
