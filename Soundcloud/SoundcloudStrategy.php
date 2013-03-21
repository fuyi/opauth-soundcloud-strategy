<?php
/**
 * Soundcloud strategy for Opauth
 * based on http://developers.soundcloud.com/docs#authentication
 * 
 * More information on Opauth: http://opauth.org
 * 
 * @package      Opauth.SoundcloudStrategy
 * @author       fuyi (yvesfu@gmail.com)
 * @license      http://www.opensource.org/licenses/mit-license.php MIT
 * @link         https://github.com/fuyi/opauth-soundcloud-strategy
 * @version      0.1  init version
 */
require_once 'Services/Soundcloud.php';

class SoundcloudStrategy extends OpauthStrategy{

	/**
	 * Compulsory config keys, listed as unassociative arrays
	 * eg. array('app_id', 'app_secret');
	 * TODO: add config key to allow persist access token to session
	 */
	public $expects = array('client_id', 'secret');
    
	/**
	 *   sounc cloud client
	 */
	private $sc_client;
	
	public function __construct($strategy, $env)
	{
		parent::__construct($strategy, $env);
		$redirect_uri = $this->strategy['complete_url_to_strategy'].'int_callback';
		$this->sc_client = new Services_Soundcloud(
		  $this->strategy['client_id'], $this->strategy['secret'], $redirect_uri);
	}
	/**
	 * Auth request
	 */
	public function request(){
		// redirect user to authorize URL
		header("Location: " . $this->sc_client->getAuthorizeUrl());
	}
	
	/**
	 * Internal callback, after Soundcloud's OAuth
	 */
	public function int_callback(){
		if (array_key_exists('code', $_GET) && !empty($_GET['code'])){
			$code = $_GET['code'];
			$results = $this->sc_client->accessToken($code);
			
			if (!empty($results) && !empty($results['access_token'])){
				$me = json_decode($this->sc_client->get('me'));
				// print_r($me);    
				$this->auth = array(
					'provider' => 'Soundcloud',
					'uid' => $me->id,
				'info' => array(
					'username' => $me->username,
					'full_name' => $me->full_name,
					'avatar_url' => $me->avatar_url
				),
				'credentials' => array(
					'token' => $results['access_token'],
					'expires' => date('c', time() + $results['expires_in'])
				)
				);
				
				$this->callback(); 
			}
			else{
				$error = array(
					'provider' => 'Soundcloud',
					'code' => 'access_token_error',
					'message' => 'Failed when attempting to obtain access token',
					'raw' => $headers
				);
			
				$this->errorCallback($error);
			} 
		}
		else{
			$error = array(
				'provider' => 'Soundcloud',
				'code' => $_GET['error'],
				'message' => $_GET['error_description'],
				'raw' => $_GET
			);
			
			$this->errorCallback($error);
		}
	}
}