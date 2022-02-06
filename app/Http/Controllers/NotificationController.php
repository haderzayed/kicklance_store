<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id){
          $user=Auth::user();
          $notification=$user->notifications()->findOrFail($id);
          $notification->markAsRead();
          return redirect()->to($notification->data['action']);
    }
}
