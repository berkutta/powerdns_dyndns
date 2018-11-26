<?php
// Application middleware

// Middleware
$app->add(function ($request, $response, $next) {
    if ( !( empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']) )) {
        
        $sth = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $sth->execute(array($_SERVER['PHP_AUTH_USER'], md5($_SERVER['PHP_AUTH_PW'])));
        
        if($sth->rowCount() == 1) {
            $response = $next($request, $response);

            return $response;
        }
    }
    
    $response->getBody()->write('badauth');

    return $response;
});