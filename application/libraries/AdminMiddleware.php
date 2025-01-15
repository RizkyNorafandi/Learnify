<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminMiddleware
{

    /**
     * Cek apakah admin sudah login
     */
    public static function is_logged_in()
    {
        $ci = &get_instance();
        if (!$ci->session->userdata('is_admin_logged_in')) {
            // Jika belum login, redirect ke halaman login
            redirect('admin/login');
        }
    }
}
