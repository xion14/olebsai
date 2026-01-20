<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NotificationUser;
use App\Models\NotificationAdmin;
use App\Models\NotificationSeller;

class NotificationController extends Controller
{
    public function get_unread_user(Request $request)
    {
        $user_id = $request->user_id;
        $data = NotificationUser::where('user_id', $user_id)->where('is_read', 0)->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Success get unread notification'
        ]);
    }

    public function get_unread_admin(Request $request)
    {
        $data = NotificationAdmin::where('is_read', 0)->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Success get unread notification'
        ]);
    }

    public function get_unread_seller(Request $request)
    {
        $user_id = $request->user_id;
        $data = NotificationSeller::where('user_id', $user_id)->where('is_read', 0)->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Success get unread notification'
        ]);
    }

    public function read_user(Request $request)
    {
        $user_id = $request->user_id;
        NotificationUser::where('user_id', $user_id)->update(['is_read' => 1]);
        return response()->json([
            'status' => 'success',
            'message' => 'Success read notification'
        ]);
    }

    public function read_admin(Request $request)
    {
        NotificationAdmin::where('is_read', 0)->update(['is_read' => 1]);
        return response()->json([
            'status' => 'success',
            'message' => 'Success read notification'
        ]);
    }

    public function read_seller(Request $request)
    {
        $user_id = $request->user_id;
        NotificationSeller::where('user_id', $user_id)->update(['is_read' => 1]);
        return response()->json([
            'status' => 'success',
            'message' => 'Success read notification'
        ]);
    }


    public function get_user(Request $request)
    {
        $user_id = $request->user_id;
        $data = NotificationUser::where('user_id', $user_id)->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Success get notification'
        ]);
    }

    public function get_admin(Request $request)
    {
        $data = NotificationAdmin::latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Success get notification'
        ]);
    }

    public function get_seller(Request $request)
    {
        $user_id = $request->user_id;
        $data = NotificationSeller::where('user_id', $user_id)->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Success get notification'
        ]);
    }

    public function destroy_notif_user($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationUser::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Success delete notification'
        ]);
    }

    public function destroy_notif_admin($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationAdmin::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Success delete notification'
        ]);
    }

    public function destroy_notif_seller($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationSeller::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Success delete notification'
        ]);
    }

    public function mark_as_read_user($user_id)
    {
        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationUser::where('user_id', $user_id)->update(['is_read' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Success mark as read notification'
        ]);
    }

    public function mark_as_read_admin()
    {
        NotificationAdmin::update(['is_read' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Success mark as read notification'
        ]);
    }

    public function mark_as_read_seller($user_id)
    {
        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationSeller::where('user_id', $user_id)->update(['is_read' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Success mark as read notification'
        ]);
    }

    public function mark_read_user($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationUser::where('id', $id)->update(['is_read' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Success mark as read notification'
        ]);
    }

    public function mark_read_admin($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationAdmin::where('id', $id)->update(['is_read' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Success mark as read notification'
        ]);
    }

    public function mark_read_seller($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ]);
        }
        NotificationSeller::where('id', $id)->update(['is_read' => 1]);
        return response()->json([
            'success' => true,
            'message' => 'Success mark as read notification'
        ]);
    }
}