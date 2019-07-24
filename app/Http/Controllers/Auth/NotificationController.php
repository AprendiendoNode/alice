<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use App\User;
use App\Models\Base\Message;
use App\Notifications\MessageViatic;

class NotificationController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    //Para php
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('notifications.index', [
          'notificacions' => auth()->user()->notifications,
          'unreadNotifications' => auth()->user()->unreadNotifications,
          'readNotifications' => auth()->user()->readNotifications
        ]);
    }
    public function read($id)
    {
      DatabaseNotification::find($id)->markAsRead();
      return back();
    }

    public function readbyfolio($id)
    {
      DatabaseNotification::find($id)->markAsRead();
    }

    public function destroy($id)
    {
      DatabaseNotification::find($id)->delete();
      return back();
    }

    //Para vue
    public function vue_index()
    {
      if (request()->ajax())
      {
        return auth()->user()->unreadNotifications;
      }
    }

}
