<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use Auth;

class TemplateController extends Controller
{
    public function templates() {
        $templates = Template::all();
        return view('templates', compact('templates'));
    }

    public function add_template(Request $request) {
        Template::create(['template' => $request->template, 'user_id' => Auth::user()->id]);
    }

    public function update_template(Request $request, $template_id) {
        Template::find($template_id)->update(['template' => $request->template]);
    }

    public function delete_template($template_id) {
        Template::find($template_id)->delete();
    }

    
}
