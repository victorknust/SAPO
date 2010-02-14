<?php defined('SYSPATH') OR die('No direct access allowed.');

class Usuarios_Controller extends Template_Controller {
 
 	public $template = 'template'; 
 
 	public $auto_render = TRUE;
 
 	public function __construct()
	{
		parent::__construct();
		
		$this->session = Session::instance();
	}
 
 	public function index()
	{
		$this->lista();
	
	}
	
	public function lista(){
		
		$usuarios = ORM::Factory('usuario')->find_all();
		
		$view = View::Factory('usuarios/lista');
		$view->set('usuarios', $usuarios);
		
		$this->template->content= $view;
	}
	
	
	public function formulario($id = FALSE){
		$usuario = ORM::Factory('usuario', $id);
		
		$grupos = ORM::Factory('grupo_acesso')->select_list('id', 'nome');
		
		$view = View::Factory('usuarios/formulario');
		$view->set('usuario', $usuario);
		$view->set('grupos', $grupos);
		
		$this->template->content= $view;
		
	}
	
	public function salvar(){
		
		$usuario = ORM::Factory('usuario', $_POST['id']);
		
		
		
		//so altera a senha se for preenchida
		if($_POST['senha'] == ''){
			
			unset($_POST['senha']);
			
		}else{
			
			$_POST['senha'] = md5($_POST['senha']);
			
		}
		
		$usuario = objects::match_and_save_attributes($usuario, $_POST, TRUE);	
		
		html::flash_message('Dados do usuario <b>'.$usuario->nome.'</b> salvos com sucesso!', 'success');
					
		url::redirect('usuarios/lista/');		
		
				
	}
	
	
	public function excluir($id){
		
		$usuario = ORM::Factory('usuario', $id);
		
		$nome = $usuario->nome;
		
		$usuario->delete();			
			
		html::flash_message('Usuário <b>'.$nome.'</b> excluído com sucesso!', 'success');
			
		url::redirect('usuarios/');
		
	}
	
	
}