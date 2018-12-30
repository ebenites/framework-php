<?php
namespace Application\Providers;

class Session {
    
    private const APP = 'app';   // sesison.app.foo
    
    private $session;
    
    public function __construct() {
        $session_factory = new \Aura\Session\SessionFactory();
        $this->session = $session_factory->newInstance($_COOKIE);
    }
    
    /**
     * Session
     **/
    public function get($key) {
		return $this->session->getSegment(self::APP)->get($key);
	}
	
	public function set($key, $value) {
		$this->session->getSegment(self::APP)->set($key, $value);
	}
	
	public function clear() {
		$this->session->getSegment(self::APP)->clear();
	}
    
    /**
     * Flash
     **/
    public function setFlash(string $type, string $message) {
        $this->session->getSegment(self::APP)->setFlash($type, $message);
    }
    
    public function setFlashNow(string $type, string $message) {
        $this->session->getSegment(self::APP)->setFlashNow($type, $message);
    }
    
    public function getFlash($type) {
		return $this->session->getSegment(self::APP)->getFlash($type);
	}
	
    /**
     * Auth
     **/
    public function islogged(): bool {
		return ($this->session->getSegment(self::APP)->get('user') != null);
	}

	public function getUser() {
		return $this->session->getSegment(self::APP)->get('user');
	}
	
	public function setUser($user) {
		$this->session->getSegment(self::APP)->set('user', $user);
	}

}