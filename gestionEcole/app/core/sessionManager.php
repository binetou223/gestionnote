<?php

function initSession(){
    if (session_status()===PHP_SESSION_NONE) {
        session_start();
    }
}

function getSession(string $key){
    return $_SESSION[$key] ?? null;
}

function setSession(string $key, mixed $value){
    return $_SESSION[$key] = $value;
}

function unsetSession(string $key){
    unset($_SESSION[$key]);
}
function destroy_session(): void {
    session_unset();
    session_destroy();
}