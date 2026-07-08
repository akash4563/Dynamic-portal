<?php
function getSecretKey() {
    return getenv('APP_SECRET') ?: 'default-secret-key-for-local-dev-change-in-prod';
}

function generateAuthCookie($username) {
    $exp = time() + (86400); // 1 day
    $data = "user=" . urlencode($username) . "&exp=" . $exp;
    $sig = hash_hmac('sha256', $data, getSecretKey());
    return $data . "&sig=" . $sig;
}

function verifyAuthCookie($cookie_val) {
    parse_str($cookie_val, $parsed);
    if (!isset($parsed['user']) || !isset($parsed['exp']) || !isset($parsed['sig'])) {
        return false;
    }
    if (time() > $parsed['exp']) {
        return false;
    }
    $data = "user=" . urlencode($parsed['user']) . "&exp=" . $parsed['exp'];
    $expected_sig = hash_hmac('sha256', $data, getSecretKey());
    if (hash_equals($expected_sig, $parsed['sig'])) {
        return $parsed['user'];
    }
    return false;
}

function isLoggedIn() {
    if (isset($_COOKIE['auth_token'])) {
        return verifyAuthCookie($_COOKIE['auth_token']) !== false;
    }
    return false;
}

// Double Submit Cookie pattern for CSRF in stateless apps
function getCsrfToken() {
    if (!isset($_COOKIE['csrf_token'])) {
        $token = bin2hex(random_bytes(32));
        setcookie('csrf_token', $token, 0, '/');
        $_COOKIE['csrf_token'] = $token; // Make available immediately
        return $token;
    }
    return $_COOKIE['csrf_token'];
}

function verifyCsrfToken($token) {
    if (isset($_COOKIE['csrf_token']) && hash_equals($_COOKIE['csrf_token'], $token)) {
        return true;
    }
    return false;
}
?>