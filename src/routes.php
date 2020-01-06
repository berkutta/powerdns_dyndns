<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// DynDNS
$app->get('/nic/update', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT name FROM records JOIN zones ON records.domain_id = zones.domain_id WHERE zones.owner = (SELECT id FROM users WHERE username = ?) AND records.name = ?");
    $sth->execute(array($_SERVER['PHP_AUTH_USER'], $request->getParam('hostname')));
    $todos = $sth->fetchAll();

    if($sth->rowCount() == 1) {
        $sth = $this->db->prepare("UPDATE records SET records.content = ? WHERE records.name = ? AND records.type = 'A'");
        $sth->execute(array($request->getParam('myip'), $request->getParam('hostname')));

        if($sth->rowCount() == 1) {
            $response->getBody()->write('good '.$request->getParam('myip'));
        } else {
            $response->getBody()->write('nochg '.$request->getParam('myip'));
        }

        return $response;
    } else {
        $response->getBody()->write('nohost');
    }

    return $response;
});

// ACME
$app->post('/acme/update', function (Request $request, Response $response) {
    if($request->getParam('type') == "TXT") {
        $sth = $this->db->prepare("SELECT name FROM records JOIN zones ON records.domain_id = zones.domain_id WHERE zones.owner = (SELECT id FROM users WHERE username = ?) AND records.name = ?");
        $sth->execute(array($_SERVER['PHP_AUTH_USER'], $request->getParam('hostname')));
        $todos = $sth->fetchAll();

        if($sth->rowCount() == 1) {
            $sth = $this->db->prepare("UPDATE records SET records.content = ? WHERE records.name = ? AND records.type = 'TXT'");
            $sth->execute(array($request->getParam('token'), $request->getParam('hostname')));

            if($sth->rowCount() == 1) {
                $response->getBody()->write('OK');
            } else {
                $response->getBody()->write('OK');
            }

            return $response;
        } else {
            $response->withStatus(400);
        }
    } else {
        $response->withStatus(406);
    }

    $response->withStatus(406);

    return $response;
});
