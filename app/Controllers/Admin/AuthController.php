<?php

declare(strict_types=1);

namespace Admin;

final class AuthController extends \BaseController
{
    public function loginPage(): void
    {
        if (\Auth::check()) {
            $this->response->redirect(\base_url('admin/dashboard'));
        }
        $this->render('admin/auth/login', [
            'pageTitle' => 'Admin Login',
        ], 'admin_auth');
    }

    public function login(): void
    {
        $limiter = new \RateLimiter();
        $ipKey = 'login_' . md5($this->request->ip());
        if ($limiter->tooManyAttempts($ipKey, 5, 900)) {
            $mins = max(1, (int) ceil($limiter->availableIn($ipKey) / 60));
            \flash('error', 'Too many login attempts. Try again in ' . $mins . ' minutes.');
            $this->response->redirect(\base_url('admin'));
        }

        $username = trim((string) $this->request->post('username', ''));
        $password = (string) $this->request->post('password', '');

        if ($username === '' || $password === '') {
            \flash('error', 'Invalid credentials. Please try again.');
            $this->response->redirect(\base_url('admin'));
        }

        $adminModel = new \AdminUserModel();
        $user = $adminModel->findByUsername($username);

        usleep(\random_int(100_000, 300_000));

        $valid = $user !== null && \password_verify($password, (string) ($user['password_hash'] ?? ''));

        if (!$valid) {
            if ($user !== null) {
                $adminModel->recordFailedLogin((int) $user['id']);
            }
            $limiter->hit($ipKey, 900);
            \flash('error', 'Invalid credentials. Please try again.');
            $this->response->redirect(\base_url('admin'));
        }

        if ($adminModel->isLocked($user)) {
            \flash('error', 'Account temporarily locked. Try later.');
            $this->response->redirect(\base_url('admin'));
        }

        $limiter->clear($ipKey);
        $adminModel->resetLoginAttempts((int) $user['id']);
        $adminModel->updateLastLogin((int) $user['id']);
        \Auth::login($user);
        $this->response->redirect(\base_url('admin/dashboard'));
    }

    public function logout(): void
    {
        \Auth::logout();
        \flash('info', 'You have been logged out.');
        $this->response->redirect(\base_url('admin'));
    }
}
