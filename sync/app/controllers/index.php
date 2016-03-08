<?php 
class Index extends Controller{
	
	public function __construct(){
		parent::__construct();
		// Load Modals 
		$this->Url->setBaseurl(getBaseurl());
		
		$Header = $this->load_view('template/header');
		$Footer = $this->load_view('template/footer');
		$this->Template->setTemplate($Header,$Footer);
		
		
		$this->Modal = $this->load_modal('indexmodal');
		
		
	}
	// Home Page
	public function index(){
		$data = array();
		$this->Template->setContent($this->load_view('home',$data));
		$this->Template->render();
	}
	
	public function addUpdateUser($input){
		$user_id = false;
		if( isset($input['id']) && is_numeric($input['id'])){
			$user_id = $input['id'];
			$user = $this->Modal->getUser($user_id);
			if( !$user){ $user_id = false; }
		}
		$response = array();
		$response['userid'] = $this->Modal->addUpdateUser($input,$user_id);
		return $response;	
	}
	
	public function getUser($input){
		$id = isset($input['id'])&&is_numeric($input['id'])	?$input['id']:false;
		return $this->Modal->getUser($id);
	}
	
	
	
	
	public function about(){
		$this->Template->setContent($this->load_view('about'));
		$this->Template->render();
	}
	
	public function page_404(){
		header('HTTP/1.1 404 Page Not Found');
		$this->Template->setContent('<h1 class="margin-top-lg text-theme text-center">404</h1>');
		$this->Template->render();
	}
}