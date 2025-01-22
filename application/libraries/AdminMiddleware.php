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
        log_message('debug', 'Session data: ' . print_r($ci->session->userdata(), true));
        if (!$ci->session->userdata('is_admin_logged_in')) {
            redirect('admin/login');
        }
    }
}
