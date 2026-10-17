<?php
namespace App\Http\Controllers;
use App\Models\CmsSetting;
class ContactController extends Controller {
    public function index() {
        $contact = CmsSetting::getGroup('contact');
        $social  = CmsSetting::getGroup('social');
        return view('pages.contact', compact('contact', 'social'));
    }
}
