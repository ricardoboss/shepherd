<?php

require '../../vendor/autoload.php';

$config = Psalm\Spirit\Config::getInstance();

if (!$config instanceof Psalm\Spirit\Config\OAuthApp) {
	throw new \UnexpectedValueException('Cannot use oauth flow if config not proper');
}

$params = [
	'client_id' => $config->client_id,
	'redirect_uri' => 'https://' . $_SERVER['HTTP_HOST'] . '/auth/github/redirect',
	'allow_signup' => false,
	'scopes' => 'public_repo write:repo_hook',
	'state' => hash('sha256', $_SERVER['REMOTE_IP'], $config->client_secret)
];

$github_url = $config->gh_enterprise_url ?: 'https://github.com';

header('Location: ' . $github_url . '/login/oauth/authorize?' . http_build_query($params));