# PowerDNS API

## Description

This is a simple Tool to get a DynDNS compatible API for your PowerDNS DNS System. It uses the same Users like you already have with PowerAdmin for the DynDNS API Login. Additional it also provides an Endpoint designed for requesting DNS challenge SSL certificates through Certbot.

## Installation

`composer install`

## DynDNS Mode

This picture shows the example configuration on an EdgeRouter Firewall

![configuration example](https://raw.githubusercontent.com/berkutta/powerdns_dyndns/master/edgemax.png)

## ACME Mode

Please take a look at following gist for TXT ACME mode: https://gist.github.com/berkutta/dc34857f01c6b0a63c7fabd1540513c7