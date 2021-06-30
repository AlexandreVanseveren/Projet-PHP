<?php 

class IndexPageView {
    private $page;
    private $render;
    
    function __construct() {
        $this->page = false;
        $this->render = false;
    }
    
    function displayPageAccueil($matchOffi){
		$buffer = $this->templatePageAccueil($matchOffi);
        $this->template($buffer);
        return $this->render;
    }
    
	function displayPageUtilisateurConnecté($matchOffi, $user) {
		$buffer = $this->templateUtilisateur($matchOffi,$user);
        $this->template($buffer);
        return $this->render;
    }
	
	function displayPageMembre($match,$demandeMembre) {
		$buffer = $this->templateMembre($match,$demandeMembre);
        $this->template($buffer);
        return $this->render;
    }
    
	function displayPageGerant($match,$demande,$utilisateur,$membre,$champions) {
		$buffer = $this->templateGerant($match,$demande,$utilisateur,$membre,$champions);
        $this->template($buffer);
        return $this->render;
    }
	
    function template($buffer) {
        $this->page = $this->generateHeader();
        $this->page .= $buffer;
        $this->page .= $this->generateFooter();
        $this->render = $this->generateShell();
    }
    
    function templatePageAccueil($matchOffi) {
		$buffer = $this->generateLogin();
        $buffer .= $this->generateTableMatchOffi($matchOffi);
		$buffer .= $this->generateRajoutUser();
		return $buffer;
    }
	
	function templateUtilisateur($matchOffi,$user) {
        $buffer = $this->generateTableMatchOffi($matchOffi);
		$buffer .= $this->generateChatGlobal($user);
		return $buffer;
    }
	
	function templateMembre($match,$demandeMembre) {
        $buffer = $this->generateRajoutDemande();
        $buffer .= $this->generateTableMatchOffi($match);
		$buffer .= $this->generateTabledemandeMembre($demandeMembre);	
        return $buffer;
    }
	
	function templateGerant($match,$demande,$utilisateur,$membre,$listChampions) {
        $buffer = $this->generateRajoutMatch($listChampions);
        $buffer .= $this->generateTableMatchGerant($match);
		$buffer .= $this->generateRajoutUserGerant();
		$buffer .= $this->generateTableUser($utilisateur);
		$buffer .= $this->generateTableDemande($demande);
		$buffer .= $this->generateTableMembre($membre);
        return $buffer;
    }
    
	function generateChatGlobal($user){
		ob_start();
            include 'views/template/ChatGlobal.php';
        return ob_get_clean();
	}
	
	function generateTableMembre($membre){
		ob_start();
            include 'views/template/TabUserAdminMembre.php';
        return ob_get_clean();
    }
	
	function generateRajoutMatch($listChampions){
		ob_start();
            include 'views/template/RajoutMatchGerant.php';
        return ob_get_clean();
    }
	
	function generateTableMatchGerant($listMatch){
		ob_start();
            include 'views/template/TabMatchGerant.php';
        return ob_get_clean();
    }
	
	function generateTableDemande($demandeMembre){
		ob_start();
            include 'views/template/tabDemandeGerant.php';
        return ob_get_clean();
    }
	
	function generateTabledemandeMembre($demandeMembre){
		ob_start();
            include 'views/template/tabDemandeMembre.php';
        return ob_get_clean();
    }
		
    function generateTableMatchOffi($matchOffi) {
        ob_start();
            include 'views/template/tabMatchUser.php';
        return ob_get_clean();
    }
	
	function generateRajoutDemande() {
        ob_start();
            include 'views/template/RajoutDemandeMembre.php';
        return ob_get_clean();
    }

	function generateRajoutUser() {
        ob_start();
            include 'views/template/RajoutUser.php';
        return ob_get_clean();
    }
	
	function generateRajoutUserGerant() {
        ob_start();
            include 'views/template/RajoutUserGerant.php';
        return ob_get_clean();
    }
	
	function generateLogin() {
        ob_start();
            include 'views/template/login.php';
        return ob_get_clean();
    }
    
	
	function generateTableUser($user_list) {
        ob_start();
            include 'views/template/tabUserAdmin.php';
        return ob_get_clean();
    }
    
	function generateShell() {
        ob_start();
            include 'views/template/shell.php';
        return ob_get_clean();
    }
	
    function generateHeader() {
        ob_start();
            include 'views/template/header.php';
        return ob_get_clean();
    }
    
    function generateFooter() {
        ob_start();
            include 'views/template/footer.php';
        return ob_get_clean();
    }
    
    function __get($property) {
        if (property_exists($this, $property)) {
			return $this->$property;
		}
    }
    
    function __set($property, $value) {
        if (property_exists($this, $property)) {
			$this->$property = $value;
		}
    }
}