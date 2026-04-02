<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize {
    public function isAuthenticated(): bool {
        return Session::has('user');
    }

    public function handle(string $role): void {
        if ($role === 'guest' && $this->isAuthenticated()) {
            redirect('/');
        } elseif ($role === 'auth' && !$this->isAuthenticated()) {
            redirect('/login');
        }
    }
}
