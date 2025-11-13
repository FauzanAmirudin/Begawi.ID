<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk dashboard
        $stats = [
            'pages' => 1345,
            'posts' => 12456,
            'users' => 21,
            'files' => 1220,
            'categories' => 65,
            'comments' => 9876
        ];

        $users = [
            ['name' => 'Bena Atkins', 'status' => 'active', 'avatar' => 'BA'],
            ['name' => 'Brett Foster', 'status' => 'offline', 'avatar' => 'BF'],
            ['name' => 'Leona Todd', 'status' => 'offline', 'avatar' => 'LT'],
            ['name' => 'Ann Ortiz', 'status' => 'active', 'avatar' => 'AO'],
            ['name' => 'Nicholas Black', 'status' => 'active', 'avatar' => 'NB'],
            ['name' => 'Ollie Harrison', 'status' => 'wait', 'avatar' => 'OH'],
            ['name' => 'Vincent Reese', 'status' => 'wait', 'avatar' => 'VR'],
            ['name' => 'Ida Robertson', 'status' => 'active', 'avatar' => 'IR'],
        ];

        $events = [
            ['time' => '11:32', 'type' => 'page', 'title' => 'New Page', 'user' => 'Kay Phillips', 'desc' => 'About Page Company'],
            ['time' => '11:20', 'type' => 'comment', 'title' => 'New Comment', 'user' => 'Erik Pittman', 'desc' => 'You might remember the Dell computer commercials in which a youth reports this exciting news to his friends...'],
            ['time' => '11:18', 'type' => 'comment', 'title' => 'New Comment', 'user' => 'Erik Pittman', 'desc' => 'Category «Templates»'],
            ['time' => '11:16', 'type' => 'user', 'title' => 'New User', 'user' => 'Erik Pittman', 'desc' => 'New User Alberta Colon'],
            ['time' => '11:01', 'type' => 'post', 'title' => 'New Post', 'user' => 'Erik Pittman', 'desc' => 'Add New Post - Second Post-'],
        ];

        return view('admin.dashboard.index', compact('stats', 'users', 'events'));
    }
}