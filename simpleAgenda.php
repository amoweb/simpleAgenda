<?php
/**
 * Plugin simpleAgenda
 * Ajout d'un agenda simple à PluXml
 *
 * @version	1.0
 * @date	22/03/2015
 * @author	Amaury G.
 **/
class simpleAgenda extends plxPlugin {

	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 **/
	public function __construct($default_lang) {

        # appel du constructeur de la classe plxPlugin (obligatoire)
        parent::__construct($default_lang);

        # déclaration des hooks
		#$this->addHook('ThemeEndHead', 'ThemeEndHead');
        
        $this->setAdminProfil(PROFIL_ADMIN);
    }
}
?>
